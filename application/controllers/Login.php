<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{

    var $module;

    function __construct()
    {
        parent::__construct();

        $this->load->model(array('M_login'));
        $this->module       = "LOGIN";
    }

    function index()
    {
        $this->load->view('login/v_login');
    }

    function DaftarSession($row)
    {
        $sess       = array(
            'logged'            => TRUE,
            'user_id'           => $row->user_id,
            'nip_pegawai'       => $row->nip_pegawai,
            'nama'              => $row->nama,
            'id_jabatan'        => $row->id_jabatan
        );  

        $this->session->set_userdata($sess);
    }

    function CheckLogin()
    {
        $user_id        = $this->input->post('user_id');
        $password       = $this->input->post('password');

        if ($user_id == null || $password == null) {
            $this->session->set_flashdata('error', 'Periksa User Id / Password Anda');
            redirect('index.php/Login', 'refresh');
        } else {
            $data           = array(
                'user_id'   => $user_id,
                'pass'      => $password
            );

            $check            = $this->M_login->checkUserId($user_id, $password); // sp_checkLogin

            if (!$check) {
                // $this->userlog->saveLogWithData($this->module, "Login Gagal", "FAILED", $data);
                $this->session->set_flashdata('error', 'Failed to Sign In');
                redirect('index.php/Login', 'refresh');
            } else {

                /**
                 * USER ROLE CHECK
                 * ==========================================================================
                 * jika user belum di set rolenya, maka akan di redirect ke halaman Login
                 * 
                 * by Zain
                 */
                // $menu_level_1        = $this->M_dashboard->loadMenuList($user_id, 1, 0);

                // if (count($menu_level_1) == 0) {
                //     $this->userlog->saveLogWithData($this->module, "Periksa Akses User Anda", "FAILED", $data);
                //     $this->session->set_flashdata('error', 'Periksa Akses User Anda');
                //     redirect('index.php/Login', 'refresh');
                // } else {
                    $this->DaftarSession($check);
                    // $this->userlog->saveLogWithData($this->module, "Login Berhasil", "SUCCESS", $data);


                    redirect('index.php/Dashboard', 'refresh');
                // }
            }
        }
    }

    function logout()
    {
        $this->session->sess_destroy();
        redirect('index.php/Login');
    }
}
