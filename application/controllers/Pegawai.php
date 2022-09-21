<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pegawai extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('logged') !== TRUE) {
            redirect(base_url() . 'index.php/Login');
        }

        $this->load->model(array("M_pegawai", "M_jabatan"));
    }

    function index()
    {
        $datas['page_title']            = "Pegawai";

        $this->load->view('layout/v_header', $datas);
        $this->load->view('layout/v_top_menu');
        $this->load->view('layout/v_sidebar');
        $this->load->view('pegawai/v_pegawai');
        $this->load->view('layout/v_footer');
    }

    function loadPegawaiListDatatables()
    {

        $pegawai               = $this->M_pegawai->loadDataPegawaiDatatables();

        $data               = array();
        $no                 = $_POST['start'];

        $i                  = 0;
        foreach ($pegawai as $item) {
            $no++;
            $row        = array();
            $row[]      = $item->nip_pegawai;
            $row[]      = $item->nama;
            $row[]      = $item->nama_jabatan;
            $row[]      = $item->user_id;
            $row[]      = $item->level;
            $row[]      = "
            <button data-id='$item->id_pegawai' class='btn btn-xs btn-success' onclick='editPegawai($item->id_pegawai)' title='Edit Pegawai'><i class='fa fa-edit'></i></button>
            <button data-id='$item->id_pegawai' class='btn btn-xs btn-danger' onclick='deletePegawai($item->id_pegawai)' title='Hapus Pegawai'><i class='fa fa-trash'></i></button>
            ";

            $data[]     = $row;
            $i++;
        }

        $output         = array(
            "draw"              => $_POST['draw'],
            "recordsTotal"      => $this->M_pegawai->count_all(),
            "recordsFiltered"   => $this->M_pegawai->count_filtered(),
            "data"              => $data,
        );

        // output to json format

        echo json_encode($output);
    }

    function AddPegawai()
    {
        $nama_pegawai       = $this->input->post("nama_pegawai");
        $nip_pegawai        = $this->input->post("nip_pegawai");
        $jabatan            = $this->input->post("jabatan");
        $user_id            = $this->input->post("user_id");
        $level              = $this->input->post("level");
        $password           = md5($this->input->post("password"));

        $data       = array(
            "nama"              => $nama_pegawai,
            "nip_pegawai"       => $nip_pegawai,
            "id_jabatan"        => $jabatan,
            "user_id"           => $user_id,
            "level"             => $level,
            "password"          => $password
        );

        $insert             = $this->M_crud->insert("tb_pegawai", $data);

        if ($insert) {
            $response_status        = "success";
            $response_message       = "Berhasil menambahkan Pegawai";
        } else {
            $response_status        = "failed";
            $response_message       = "Gagal menambahkan Pegawai";
        }

        echo json_encode(array(
            "status"        => $response_status,
            "message"       => $response_message
        ));
    }

    function UpdatePegawai()
    {
        $id_pegawai         = $this->input->post("id_pegawai");
        $nama_pegawai       = $this->input->post("nama_pegawai");
        $nip_pegawai        = $this->input->post("nip_pegawai");
        $jabatan            = $this->input->post("jabatan");
        $user_id            = $this->input->post("user_id");
        $level              = $this->input->post("level");
        $password           = md5($this->input->post("password"));

        $data       = array(
            "nama"              => $nama_pegawai,
            "nip_pegawai"       => $nip_pegawai,
            "id_jabatan"        => $jabatan,
            "user_id"           => $user_id,
            "level"             => $level,
            "password"          => $password
        );

        $where      = array(
            "id_pegawai"        => $id_pegawai
        );

        $update             = $this->M_crud->update("tb_pegawai", $data, $where);

        if ($update) {
            $response_status        = "success";
            $response_message       = "Berhasil mengedit Pegawai";
        } else {
            $response_status        = "failed";
            $response_message       = "Gagal mengedit Pegawai";
        }

        echo json_encode(array(
            "status"        => $response_status,
            "message"       => $response_message
        ));
    }


    function edit()
    {
        $id_pegawai     = $this->input->post("id_pegawai");

        $pegawai        = $this->M_pegawai->getDetailPegawai($id_pegawai);

        if ($pegawai) {
            $response_data      = $pegawai;
            $response_status    = "success";
            $response_message   = "Successfully";
        } else {
            $response_data      = null;
            $response_status    = "failed";
            $response_message   = "Gagal mendapatkan Data Pegawai";
        }

        echo json_encode(array(
            "status"        => $response_status,
            "message"       => $response_message,
            "data"          => $response_data
        ));
    }

    function delete()
    {
        $id_pegawai         = $this->input->post("id_pegawai");

        $where             = array(
            "id_pegawai"            => $id_pegawai
        );

        $delete     = $this->M_crud->delete("tb_pegawai", $where);

        if ($delete) {
            $response_status        = "success";
            $response_message       = "Berhasil menghapus Data Pegawai";
        } else {
            $response_status        = "failed";
            $response_message       = "Gagal menghapus Data Pegawai";
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

    function loadPegawaiListOption()
    {
        $pegawai           = $this->M_pegawai->loadPegawaiList();

        $result     = "<option value=''>-- Pilih Pegawai --</option>";

        foreach ($pegawai as $item) {
            $result .= "<option value='$item->id_pegawai'>$item->nama</option>";
        }

        echo $result;
    }
}
