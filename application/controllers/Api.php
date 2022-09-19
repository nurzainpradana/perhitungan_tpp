<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Api extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        $this->load->model(array('M_location', 'M_voucher_unregistered', 'M_voucher_registered'));
    }



    // Untuk load autocomplete ketika input location
    function getLocationArray()
    {
        $response_data          = array();

        $location           = $this->M_location->loadLocationListOption();

        if ($location) {
            foreach ($location as $item) {
                $response_data[]    = $item->location_name;
            }
        }

        echo json_encode($response_data);
    }
}
