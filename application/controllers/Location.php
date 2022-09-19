<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Location extends CI_Controller
{
    var $module;

    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('logged') !== TRUE) {
            redirect(base_url() . 'index.php/Login');
        }

        if (!$this->menulibrary->checkUserAccess()) {
            redirect(base_url() . 'index.php');
        }

        $this->load->model(array('M_location'));
        $this->module       = "LOCATION";
    }

    function index()
    {
        $data['location']       = $this->M_location->loadLocationList();

        $datas['page_title']        = "Location";

        $this->load->view('layout/v_header', $datas);
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
            'row'           => $this->input->post("row"),
            'box'           => $this->input->post("box"),
            'bantex'        => $this->input->post("bantex"),
            'user'          => $this->session->userdata("user_id")
        );


        $insert     = $this->M_location->insertLocation($data); // sp_locationinsert

        if ($insert) {
            if ($insert->Result == "success") {
                $this->userlog->saveLogWithData($this->module, "Insert Location Successfully", "SUCCESS", $data);

                echo json_encode(array("status" => "true"));
            } else if ($insert->Result == "exists") {
                $this->userlog->saveLogWithData($this->module, "Failed when insert Location, Exist Data", "FAILED", $data);

                echo json_encode(array("status" => "false", "message" => "Exists Data"));
            } else if ($insert->Result == "failed") {
                $this->userlog->saveLogWithData($this->module, "Failed when insert Location", "FAILED", $data);

                echo json_encode(array("status" => "false", "message" => "failed to insert"));
            }
        } else {
            $this->userlog->saveLogWithData($this->module, "Failed to Insert Location", "FAILED", $data);
            echo json_encode(array("status" => "false", "message" => "failed"));
        }
    }

    function deleteLocation()
    {
        $location_id        = $this->input->post('location_id');

        $response_status    = "failed";
        $response_message   = NULL;

        $delete             = $this->M_location->deleteLocation($location_id);

        if ($delete) {
            $response_status        = "success";
            $response_message       = "Delete Location Successfully";

            $this->userlog->savelog($this->module, "Delete Location ($location_id) Successfully", strtoupper($response_status));
        } else {
            $response_message       = "Failed to Delete Location, Currently is used";
            $this->userlog->savelog($this->module, "Failed to delete this Location ($location_id), Location currently is used", strtoupper($response_status));
        }

        $result     = array(
            'status'       => $response_status,
            'message'      => $response_message
        );

        header("content-type:application/json");
        echo json_encode($result);
    }

    /**
     * DATATABLES LOCATION
     * ================================================
     */
    function loadLocationList()
    {

        $location_list      = $this->M_location->loadLocationList();
        $data               = array();
        $no                 = $_POST['start'];

        foreach ($location_list as $location) {
            $no++;
            $row        = array();
            $row[]      = $no;
            $row[]      = $location->location_name;
            $row[]      = " <a href='#' class='btn btn-xs btn-danger' onclick='deleteLocation(" . $location->id . ")'><i class='fas fa-trash'></i></a>";
            $data[]     = $row;
        }

        $output         = array(
            "draw"              => $_POST['draw'],
            "recordsTotal"      => $this->M_location->count_all(),
            "recordsFiltered"   => $this->M_location->count_filtered(),
            "data"              => $data,
        );
        echo json_encode($output);
    }
}
