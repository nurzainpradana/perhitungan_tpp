<?php
defined('BASEPATH') or exit('No Direct script access allowed');

class M_location2 extends CI_Model
{

    var $table      = "storage_location";
    var $column     = array("id", "location_name");
    var $order      = array("id" => "asc");

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->search   = '';
    }


    function insertLocation($data)
    {
        $sp         = "sp_insertLocation ?,?,?,?";
        $query     = $this->db->query($sp, $data);

        return $query->first_row();
    }

    function loadDetailLocation($location_id)
    {
        return $this->db->from("storage_location")->where('id', $location_id)->get()->first_row();
    }

    private function _get_datatables_query()
    {
        if($this->input->post('factory'))
        {
            $this->db->where('factory', $this->input->post('factory'));
        }

        if($this->input->post('location'))
        {
            $this->db->where('location', $this->input->post('location'));
        }

        if($this->input->post('column'))
        {
            $this->db->where('column', $this->input->post('column'));
        }

        if($this->input->post('row'))
        {
            $this->db->where('row', $this->input->post('row'));
        }
        
        $this->db->from($this->table);

        $i      = 0;

        foreach ($this->column as $item) {
            if(isset($_POST['search']))
            {
                if($_POST['search']['value']) ($i === 0) ? $this->db->like($item, $_POST['search']['value']) : $this->db->or_like($item, $_POST['search']['value']);
                $column[$i]     = $item;
            }
            
            $i++;
        }

        if (isset($_POST['oder']))
        {
            $this->db->order_by($column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if(isset($this->order))
        {
            $order      = $this->order;

            $this->db->order_by(key($order), $order[key($order)]);
        }
    }


    function loadLocationList()
    {
        $this->_get_datatables_query();

        if(isset($_POST['length']))
        {
            if($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query      = $this->db->get();

        return $query->result();
        
    }

    function loadFilteredLocationList($filter_data)
    {
        $this->db->from($this->table);

        $i      = 0;

        foreach($filter_data as $item){
            if(isset($filter_data['factory']) && $filter_data['factory'] != "" && $filter_data['factory'] != NULL)
            {
    
            }
        }

        foreach ($this->column as $item) {
            if(isset($_POST['search']))
            {
                if($_POST['search']['value']) ($i === 0) ? $this->db->like($item, $_POST['search']['value']) : $this->db->or_like($item, $_POST['search']['value']);
                $column[$i]     = $item;
            }
            
            $i++;
        }

        if (isset($_POST['oder']))
        {
            $this->db->order_by($column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if(isset($this->order))
        {
            $order      = $this->order;

            $this->db->order_by(key($order), $order[key($order)]);
        }

        if(isset($_POST['length']))
        {
            if($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query      = $this->db->get();

        return $query->result();
        
    }

    public function count_filtered()
    {
        $this->_get_datatables_query();

        $query  = $this->db->get();

        return $query->num_rows();
    }

    public function count_all()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }


}
