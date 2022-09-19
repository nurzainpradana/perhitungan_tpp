<?php
defined('BASEPATH') or exit('No Direct script access allowed');

class M_location extends CI_Model
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

        return $query->result();
    }

    private function _get_datatables_query()
    {
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
