<?php
defined('BASEPATH') or exit('No Direct script access allowed');

class M_user extends CI_Model
{

    var $column     = array("su.id", "e.employee_name");
    var $order      = array("su.id" => "asc");

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->search   = '';
    }

    function getDetailUser($user_id)
    {
        $this->db->select("su.*, u.employee_name");
        $this->db->from("storage_user su");
        $this->db->join("ZipcoAdm.dbo.V_User u", "u.user_id = su.user_id");
        $this->db->where("su.id", $user_id);

        return $this->db->get()->first_row();
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
        $this->db->select("su.id, su.user_id user_id, e.idnpk, e.employee_name, sr.role_name");
        $this->db->from("storage_user su");
        $this->db->join("ZipcoAdm.dbo.MT_User u", "u.user_id = su.user_id", "left");
        $this->db->join("ZipcoAdm.dbo.DT_Employee e", "e.idnpk = u.idnpk", "left");
        $this->db->join("storage_role sr", "sr.id = su.user_role", "left");

        $i      = 0;

        foreach ($this->column as $item) {
            if (isset($_POST['search'])) {
                if ($_POST['search']['value']) ($i === 0) ? $this->db->like($item, $_POST['search']['value']) : $this->db->or_like($item, $_POST['search']['value']);
                $column[$i]     = $item;
            }

            $i++;
        }

        if (isset($_POST['order'])) {
            $this->db->order_by($column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order      = $this->order;

            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function loadRoleList()
    {
        $this->db->select("*");
        $this->db->from("storage_role sr");
        $this->db->order_by("sr.role_name", "asc");

        return $this->db->get()->result();
    }

    function loadEmployeeList()
    {
        $this->db->select("*");
        $this->db->from("ZipcoAdm.dbo.V_User");
        $this->db->order_by("employee_name", "ASC");
        $this->db->where("employee_name IS NOT NULL");
        $this->db->where("user_id NOT IN (SELECT user_id FROM storage_user)");
        $this->db->where("status = 1");

        return $this->db->get()->result();
    }


    function loadUserList()
    {
        $this->_get_datatables_query();

        if (isset($_POST['length'])) {
            if ($_POST['length'] != -1)
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
        $this->db->from("storage_user");
        return $this->db->count_all_results();
    }

    public function deleteLocation($location_id)
    {
        if ($this->db->query("SELECT location_id FROM storage_voucher_history WHERE location_id = $location_id")->num_rows() > 0) {
            return FALSE;
        } else {
            return $this->db->where('id', $location_id)->delete($this->table);
        }
    }

    public function loadLocationListOption()
    {
        return $this->db->query("SELECT * FROM storage_location
        ")->result();
    }

    function _datatablesUserRole()
    {
        $this->db->select("ur.*, sr.role_name");
        $this->db->from("storage_user_role ur");
        $this->db->join("storage_role sr", "sr.id = ur.role_id", "left");
        $this->db->where("ur.id_user", $this->input->post('user_id'));

        $this->db->order_by("sr.role_name", "asc");
    }

    function checkUserRole($user_id, $role_id)
    {
        $this->db->select("*");
        $this->db->from("storage_user_role");
        $this->db->where("id_user", $user_id);
        $this->db->where("role_id", $role_id);

        return $this->db->get()->num_rows();
    }

    function datatablesUserRole()
    {
        $this->_datatablesUserRole();

        return $this->db->get()->result();
    }

    function countdatatablesUserRole()
    {
        $this->_datatablesUserRole();

        return $this->db->get()->num_rows();
    }
}
