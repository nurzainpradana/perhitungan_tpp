<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Location extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        $this->load->model(array('M_location'));
    }

    function index()
    {

        $data['location']       = $this->M_location->loadLocationList();
        

        $this->load->view('layout/v_header');
        $this->load->view('layout/v_top_menu');
        $this->load->view('layout/v_sidebar');
        $this->load->view('location/v_location', $data);
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


        $insert     = $this->M_location->insertLocation($data);
        
        print_r($insert);

        // if($insert)
        // {
        //     print_r($insert);
        //     if($insert->Result == "success")
        //     {
        //         echo json_encode(array("status" => "true"));
        //     } else if($insert->Result == "exists")
        //     {
        //         echo json_encode(array("status" => "false", "message" => "exist"));
        //     }
        // } else {
        //     echo json_encode(array("status" => "false", "message" => "failed"));
        // }
        // if($insert)
        // {
        //     $this->session->set_flashdata('success', 'Insert New Location Successfully');
        //     redirect('index.php/Location', 'refresh');
        // } else {
        //     $this->session->set_flashdata('error', 'Insert New Location Failed');
        //     redirect('index.php/Location', 'refresh');
        // }
    }

}