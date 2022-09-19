<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Approval extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('logged') !== TRUE) {
            redirect(base_url() . 'index.php/Login');
        }

        $this->load->model(array("M_pegawai", "M_approval"));
    }

    function index()
    {
        $datas['page_title']            = "Approval";

        $this->load->view('layout/v_header', $datas);
        $this->load->view('layout/v_top_menu');
        $this->load->view('layout/v_sidebar');
        $this->load->view('approval/v_approval');
        $this->load->view('layout/v_footer');
    }

    function loadJabatanListDatatables()
    {

        $jabatan            = $this->M_jabatan->loadDataJabatanDatatables();

        $data               = array();
        $no                 = $_POST['start'];

        $i                  = 0;
        foreach ($jabatan as $item) {
            $no++;
            $row        = array();

            $row[]      = $item->nama_jabatan;
            $row[]      = $item->unit_kerja;
            $row[]      = "
            <button data-id='$item->id_jabatan' class='btn btn-xs btn-success' onclick='editJabatan($item->id_jabatan)' title='Edit Jabatan'><i class='fa fa-edit'></i></button>
            <button data-id='$item->id_jabatan' class='btn btn-xs btn-danger' onclick='deleteJabatan($item->id_jabatan)' title='Hapus Jabatan'><i class='fa fa-trash'></i></button>
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

    function Add()
    {
        $nama_jabatan       = $this->input->post("nama_jabatan");
        $unit_kerja         = $this->input->post("unit_kerja");

        $data       = array(
            "nama_jabatan"      => $nama_jabatan,
            "unit_kerja"        => $unit_kerja
        );

        $insert             = $this->M_crud->insert("tb_jabatan", $data);

        if($insert){
            $response_status        = "success";
            $response_message       = "Berhasil menambahkan Jabatan";
        } else {
            $response_status        = "failed";
            $response_message       = "Gagal menambahkan Jabatan";
        }

        echo json_encode(array(
            "status"        => $response_status,
            "message"       => $response_message
        ));
    }

    function Update()
    {
        $id_jabatan         = $this->input->post("id_jabatan");
        $nama_jabatan       = $this->input->post("nama_jabatan");
        $unit_kerja         = $this->input->post("unit_kerja");

        $data       = array(
            "nama_jabatan"      => $nama_jabatan,
            "unit_kerja"        => $unit_kerja
        );

        $where      = array(
            "id_jabatan"        => $id_jabatan
        );

        $update             = $this->M_crud->update("tb_jabatan", $data, $where);

        if($update){
            $response_status        = "success";
            $response_message       = "Berhasil mengedit Jabatan";
        } else {
            $response_status        = "failed";
            $response_message       = "Gagal mengedit Jabatan";
        }

        echo json_encode(array(
            "status"        => $response_status,
            "message"       => $response_message
        ));
    }


    function edit()
    {
        $id_jabatan     = $this->input->post("id_jabatan");

        $jabatan        = $this->M_jabatan->getDetailJabatan($id_jabatan);

        if($jabatan)
        {
            $response_data      = $jabatan;
            $response_status    = "success";
            $response_message   = "Successfully";
        } else {
            $response_data      = null;
            $response_status    = "failed";
            $response_message   = "Gagal mendapatkan Data Jabatan";
        }

        echo json_encode(array(
            "status"        => $response_status,
            "message"       => $response_message,
            "data"          => $response_data
        ));
    }

    function delete()
    {
        $id_jabatan         = $this->input->post("id_jabatan");

        $where             = array(
            "id_jabatan"            => $id_jabatan
        );

        $delete     = $this->M_crud->delete("tb_jabatan", $where);

        if($delete)
        {
            $response_status        = "success";
            $response_message       = "Berhasil menghapus Data Jabatan";
        } else {
            $response_status        = "failed";
            $response_message       = "Gagal menghapus Data Jabatan";
        }

        echo json_encode(array(
            "status"        => $response_status,
            "message"       => $response_message
        ));
    }

    function loadJabatanListOption()
    {
        $jabatan           = $this->M_jabatan->loadJabatanList();

        $result     = "<option value=''>-- Pilih Jabatan --</option>";

        foreach ($jabatan as $item) {
            $result .= "<option value='$item->id_jabatan'>$item->nama_jabatan</option>";
        }

        echo $result;
    }
}