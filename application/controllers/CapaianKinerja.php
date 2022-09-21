<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CapaianKinerja extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('logged') !== TRUE) {
            redirect(base_url() . 'index.php/Login');
        }

        $this->load->model(array(
            "M_pegawai", "M_jabatan",
            "M_capaian_kinerja"
        ));
    }

    function index()
    {
        $datas['page_title']            = "Jabatan";

        $this->load->view('layout/v_header', $datas);
        $this->load->view('layout/v_top_menu');
        $this->load->view('layout/v_sidebar');
        $this->load->view('capaian_kinerja/v_capaian_kinerja');
        $this->load->view('layout/v_footer');
    }

    function loadCapaianKinerjaListDatatables()
    {

        $jabatan            = $this->M_capaian_kinerja->loadDataCapaianKinerjaDatatables();

        $data               = array();
        $no                 = $_POST['start'];

        $i                  = 0;
        foreach ($jabatan as $item) {
            $no++;
            $row        = array();

            $row[]      = $item->nama;
            $row[]      = $item->nama_jabatan;
            $row[]      = $item->presentase_produktivitas_kerja;
            $row[]      = "
            <button data-id='$item->id' class='btn btn-xs btn-success' onclick='editJabatan($item->id)' title='Edit Jabatan'><i class='fa fa-edit'></i></button>
            <button data-id='$item->id' class='btn btn-xs btn-danger' onclick='deleteJabatan($item->id)' title='Hapus Jabatan'><i class='fa fa-trash'></i></button>
            ";

            $data[]     = $row;
            $i++;
        }

        $output         = array(
            "draw"              => $_POST['draw'],
            "recordsTotal"      => $this->M_jabatan->count_all(),
            "recordsFiltered"   => $this->M_jabatan->count_filtered(),
            "data"              => $data,
        );

        // output to json format

        echo json_encode($output);
    }

    function add()
    {
        $id_pegawai                 = $this->input->post("id_pegawai");
        $presentase_produktivitas   = $this->input->post("presentase_produktivitas");
        $periode                    = $this->input->post("periode");

        $data           = array(
            "id_pegawai"                    => $id_pegawai,
            "nilai_produktivitas_kerja"     => $presentase_produktivitas,
            "periode"                       => date("Ym", strtotime($periode))
        );

        $insert         = $this->M_crud->insert("tb_capaian_kerja", $data);

        if ($insert) {
            $response_status        = "success";
            $response_message       = "Berhasil menyimpan data capaian kerja pegawai";
        } else {
            $response_status        = "failed";
            $response_message       = "Gagal menyimpan data capaian kerja pegawai";
        }

        echo json_encode(array(
            "status"        => $response_status,
            "message"       => $response_message
        ));
    }
}
