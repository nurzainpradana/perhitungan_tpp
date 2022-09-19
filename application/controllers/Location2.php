<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Location2 extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('logged') !== TRUE) {
            redirect(base_url() . 'index.php/Login');
        }

        $this->load->model(array('M_location2'));
    }

    function index()
    {

        $data['location']       = $this->M_location2->loadLocationList();


        $this->load->view('layout/v_header');
        $this->load->view('layout/v_top_menu');
        $this->load->view('layout/v_sidebar');
        $this->load->view('location/v_location2', $data);
        $this->load->view('layout/v_footer');
    }

    function insert()
    {
        $data       = array(
            'factory'       => $this->input->post("factory"),
            'location'      => $this->input->post("location"),
            'columns'       => $this->input->post("columns"),
            'row'           => $this->input->post("row")
        );


        $insert     = $this->M_location2->insertLocation($data);

        if ($insert) {
            if ($insert->Result == "success") {
                echo json_encode(array("status" => "true"));
            } else if ($insert->Result == "exists") {
                echo json_encode(array("status" => "false", "message" => "Exists Data"));
            } else if ($insert->Result == "failed") {
                echo json_encode(array("status" => "false", "message" => "failed to insert"));
            }
        } else {
            echo json_encode(array("status" => "false", "message" => "failed"));
        }
    }
}
