<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class InductionPowerModel extends CI_Model {

    var $DBZIP5;
    
    public function __construct() {
        parent::__construct();

        $this->DBZIP5 = $this->load->database('zipco_iot', TRUE);

        
    }
    
    // --------------------------------------------------
    //Induction Power Meter 1
    // --------------------------------------------------

    function getdataInduction1(){
        $this->DBZIP5->select("round(Power,0) as Power, round(MetalTemp,0) as MetalTemp, round(BushingTemp1,0) as BushingTemp1, round(BushingTemp2,0) as BushingTemp2, round(BushingTemp3,0) as BushingTemp3, round(BushingTemp4,0) as BushingTemp4, round(LeakCurrent,0) as Leak, round(GR,0) as GR");
        $this->DBZIP5->from("V_IPM1");

        $query = $this->DBZIP5->get();
        return $query->row();
    }

    function getdataInductionPower1(){
        $this->DBZIP5->select("power, date, CONVERT(VARCHAR(5),date,108) as time");
        $this->DBZIP5->from('V_GraphInductionPower');
        $this->DBZIP5->where("date >=",date('Y-m-d'));
        $this->DBZIP5->where("CONVERT(VARCHAR(8),date,108) >=DATEADD(MINUTE, -270, CONVERT(VARCHAR(8),getdate(),108))");

        $this->DBZIP5->order_by('date','asc');


        $query = $this->DBZIP5->get();
        return $query->result_array();
    }

    function getdataInductionPower1test(){
        $this->DBZIP5->select("power, date, CONVERT(VARCHAR(5),date,108) as time");
        // $this->DBZIP5->select("power, date, CONVERT(VARCHAR(5),date,108) as time, CONVERT(VARCHAR(5),cast(cast(cast(date as numeric(38,18)) * 48 as int) / 48.0 as datetime),108) as jam");
        // $this->DBZIP5->select("power, CONVERT(VARCHAR(5),date,108) as time");
        $this->DBZIP5->from('V_GraphInductionPowerTest');
        $this->DBZIP5->where("date >=",date('Y-m-d'));
        $this->DBZIP5->where("CONVERT(VARCHAR(8),date,108) >=DATEADD(MINUTE, -270, CONVERT(VARCHAR(8),getdate(),108))");
        // $this->DBZIP5->limit(200);
        $this->DBZIP5->order_by('date','asc');

        $query = $this->DBZIP5->get();
        return $query->result_array();

        // $result = $this->DBZIP5->simple_query("SET NOCOUNT ON 
        //                     DECLARE @return_value int
        //                     EXEC    @return_value = [dbo].[SP_IOTPOwer1]
        //                             @dateFrom = '2022-07-05 06:41:42.000' @dateTo = '2022-07-05 11:20:48.000'")->fetch(PDO::FETCH_OBJ);
        // return $result->result_array();
        
        

        
    }

    function getdataInductionPower1test2(){
        // $this->DBZIP5->select("power, CONVERT(VARCHAR(5),date,108) as time, cast(cast(cast(date as numeric(38,18)) * 48 as int) / 48.0 as datetime),108) as jam");
        // $this->DBZIP5->from('V_GraphInductionPowerTest');
        // $this->DBZIP5->where("date >=",date('Y-m-d'));
        // $this->DBZIP5->where("CONVERT(VARCHAR(8),date,108) >=DATEADD(MINUTE, -270, CONVERT(VARCHAR(8),getdate(),108))");
        // // $this->DBZIP5->limit(200);
        // $this->DBZIP5->order_by('date','asc');
        
        

        // $query = $this->DBZIP5->get();
        // return $query->result_array();

        $s = '2022-07-05 06:41:42.000';
        $e = '2022-07-05 11:20:48.000';

        $sql = "exec SP_IOTPOwer1 ?,?;";
        $params = array($s,$e);
        $query = $this->DBZIP5->query($sql, $params);

        // $query = $this->DBZIP5->query("CALL SP_IOTPOwer1({$s})");


        $this->DBZIP5->select("data, jam");
        $this->DBZIP5->from('aris_test');
        $this->DBZIP5->order_by('data','asc');

        $query = $this->DBZIP5->get();
        return $query->result_array();


        return $query->result();

        
    }

    function getdataInductionMetalTemp1(){
        $this->DBZIP5->select("MetalTemp, date, CONVERT(VARCHAR(5),date,108) as time");
        $this->DBZIP5->from('V_GraphInductionMetalTemp');
        $this->DBZIP5->where("date >=",date('Y-m-d'));
        // $this->DBZIP5->where("CONVERT(VARCHAR(8),date,108) >=DATEADD(MINUTE, -270, CONVERT(VARCHAR(8),getdate(),108))");
        $this->DBZIP5->order_by('date','asc');

        $query = $this->DBZIP5->get();
        return $query->result_array();

    }

    function getdataInductionBushingTemp1(){
        $this->DBZIP5->select("bushtemp1, bushtemp2, bushtemp3, bushtemp4, date, CONVERT(VARCHAR(5),date,108) as time");
        $this->DBZIP5->from('V_GraphInductionBushingTemp');
        $this->DBZIP5->where("date >=",date('Y-m-d'));
        // $this->DBZIP5->where("CONVERT(VARCHAR(8),date,108) >=DATEADD(MINUTE, -270, CONVERT(VARCHAR(8),getdate(),108))");
        $this->DBZIP5->order_by('date','asc');

        $query = $this->DBZIP5->get();
        return $query->result_array();
    }

    function getdataInductionLeakGround(){
        $this->DBZIP5->select("leak, gr, date, CONVERT(VARCHAR(5),date,108) as time");
        $this->DBZIP5->from('V_GraphInductionLeakGround');
        $this->DBZIP5->where("date >=",date('Y-m-d'));
        // $this->DBZIP5->where("CONVERT(VARCHAR(8),date,108) >=DATEADD(MINUTE, -270, CONVERT(VARCHAR(8),getdate(),108))");
        $this->DBZIP5->order_by('date','asc');

        $query = $this->DBZIP5->get();
        return $query->result_array();
    }

    // --------------------------------------------------
    //Induction Power Meter 2
    // --------------------------------------------------

    function getdataInduction2(){
        $this->DBZIP5->select("round(Power,0) as Power, round(MetalTemp,0) as MetalTemp, round(BushingTemp1,0) as BushingTemp1, round(BushingTemp2,0) as BushingTemp2, round(BushingTemp3,0) as BushingTemp3, round(BushingTemp4,0) as BushingTemp4, round(LeakCurrent,0) as Leak, round(GR,0) as GR");
        $this->DBZIP5->from("V_IPM2");
        
        $query = $this->DBZIP5->get();
        return $query->row();
    }

    function getdataInductionPower2(){
        $this->DBZIP5->select("power, date, CONVERT(VARCHAR(8),date,108) as time");
        $this->DBZIP5->from('V_GraphInductionPower2');
        $this->DBZIP5->where("date >=",date('Y-m-d'));
        $this->DBZIP5->where("CONVERT(VARCHAR(8),date,108) >=DATEADD(MINUTE, -270, CONVERT(VARCHAR(8),getdate(),108))");
        // $this->DBZIP5->limit(1000);
        $this->DBZIP5->order_by('date','asc');

        $query = $this->DBZIP5->get();
        return $query->result_array();
    }

    function getdataInductionMetalTemp2(){
        $this->DBZIP5->select("MetalTemp, date, CONVERT(VARCHAR(8),date,108) as time");
        $this->DBZIP5->from('V_GraphInductionMetalTemp2');
        $this->DBZIP5->where("date >=",date('Y-m-d'));
        $this->DBZIP5->order_by('date','asc');

        $query = $this->DBZIP5->get();
        return $query->result_array();
    }

    function getdataInductionBushingTemp2(){
        $this->DBZIP5->select("bushtemp1, bushtemp2, bushtemp3, bushtemp4, date, CONVERT(VARCHAR(8),date,108) as time");
        $this->DBZIP5->from('V_GraphInductionBushingTemp2');
        $this->DBZIP5->where("date >=",date('Y-m-d'));
        $this->DBZIP5->order_by('date','asc');

        $query = $this->DBZIP5->get();
        return $query->result_array();
    }

    function getdataInductionLeakGround2(){
        $this->DBZIP5->select("leak, gr, date, CONVERT(VARCHAR(8),date,108) as time");
        $this->DBZIP5->from('V_GraphInductionLeakGround2');
        $this->DBZIP5->where("date >=",date('Y-m-d'));
        $this->DBZIP5->order_by('date','asc');

        $query = $this->DBZIP5->get();
        return $query->result_array();
    }



    function get_data_excel($sdate,$stime,$edate,$etime, $id){
        $this->DBZIP5->select("cast(Date as date) as Date, convert(char(8), Date, 108) Time, MetalTemp, Power, BushingTemp1, BushingTemp2, BushingTemp3, BushingTemp4, LeakCurrent, GR");

        if ($id==1) {
            $this->DBZIP5->from("V_IPMData1");
        } else {
            $this->DBZIP5->from("V_IPMData2");
        }
        // $this->DBZIP5->from("V_IPMData1");

        $this->DBZIP5->where('cast(Date as date) >=',$sdate);
        $this->DBZIP5->where('convert(char(8), Date, 108) >=',$stime);
        $this->DBZIP5->where('cast(Date as date) <=',$edate);
        $this->DBZIP5->where('convert(char(8), Date, 108) <=',$etime);

        // $this->DBZIP5->limit("100");
        $this->DBZIP5->order_by("Date", "asc");


        $query = $this->DBZIP5->get();
        
        //$query = $this->DBZIP5->query("SELECT a.spk_no FROM DT_SPK a");
        return $query;
    }

   
}