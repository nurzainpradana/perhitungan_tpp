<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('logged') !== TRUE) {
            redirect(base_url() . 'index.php/Login');
        }

        $this->load->model(array("M_voucher_unregistered", "M_voucher_out", "M_voucher_registered"));
    }

    function index()
    {
        $datas['page_title']                    = "Dashboard";

        // $data['voucher_unregistered_count']     = $this->M_voucher_unregistered->count_filtered();
        // $data['voucher_out_count']              = $this->M_voucher_out->count_filtered();
        // $data['voucher_empt_scanfile']          = $this->M_voucher_registered->count_empty_scanfile();

        $this->load->view('layout/v_header', $datas);
        $this->load->view('layout/v_top_menu');
        $this->load->view('layout/v_sidebar');
        $this->load->view('dashboard/v_dashboard');
        $this->load->view('layout/v_footer');
    }
}
