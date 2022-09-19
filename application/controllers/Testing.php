<?php
defined('BASEPATH') or exit('No direct script allowd');

class Testing extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        $this->load->model('inductionPowerModel', 'IPM');
    }

    function graphInduction(){
        $this->load->view('graphInduction');
    }

    function dataInductionPower1(){
        $datas = $this->IPM->getdataInductionPower1(); 

        $result = array();

        $categories_data    = array();
        $powers_data        = array();
        $dates_data         = array();

        $i      = 0;

        $start_time     = 0;
        $next_time      = 0;

        $positions      = [];
        $positions_time = [];

        foreach($datas as $data)
        {
            if($i == 0)
            {
                $start_time     = $data['time'];
                $positions[]    = $i;
                $positions_time[]   = $data['time'];

                $next_time      = date("H:i", strtotime("+30 minutes", strtotime($start_time)));
            } else if($data['time'] == $next_time)
            {
                $positions[]    = $i;
                $positions_time[]   = $data['time'];
                $next_time      = date("H:i", strtotime("+30 minutes", strtotime($next_time)));
            } else if(strtotime($data['time']) > strtotime($next_time))
            {
                $time_1     = strtotime($next_time);
                $time_2     = strtotime($data['time']);

                $difff      = ($time_2 - $time_1) / 60;


                if($difff < 30)
                {
                    $next_time      = date("H:i", strtotime("+30 minutes", strtotime($next_time)));
                    $positions[]        = $i;
                    $positions_time[]   = $data['time'];
                }
            }

            $categories_data[]      = $data['time'];
            $powers_data[]          = $data['power'];
            $dates_data[]           = $data['date'];

            $row    = array(
                'power'     => $data['power'],
                'date'      => $data['date']
            );

            $result[]   = $row;

            $i++;

        }

        $data       = array(
            "power"     => $powers_data,
            "time" => $categories_data,
            "date"      => $dates_data,
            "positions" => $positions,
            "positions_time"    => $positions_time
        );

        echo json_encode($data);

    }

    function convertTime()
    {
        $datetime       = 1658455239;

        date("H:i", $datetime);
    }
}