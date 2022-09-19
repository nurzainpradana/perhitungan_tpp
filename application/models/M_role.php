<?php
defined('BASEPATH') or exit('No Direct script access allowed');

class M_role extends CI_Model
{

    var $column     = array("su.id", "e.employee_name");
    var $order      = array("su.id" => "asc");

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->search   = '';
    }

    function _loadrolelist()
    {
        $this->db->select("*");
        $this->db->from("storage_role");
        $this->db->order_by("status", "DESC");
        $this->db->order_by("role_name", "ASC");
    }

    function loadrolelist()
    {
        $this->_loadrolelist();

        return $this->db->get()->result();
    }

    function loadRoleListCount()
    {
        $this->_loadrolelist();

        return $this->db->get()->num_rows();
    }

    function loadRoleDetail($id)
    {
        $this->db->select("role_name");
        $this->db->from('storage_role');
        $this->db->where('id', $id);

        return $this->db->get()->row();
    }

    function loadMenuList()
    {
        $this->db->select("*");
        $this->db->from("storage_menu sm");
        $this->db->where("status", 1);
        $this->db->order_by("sm.menu_name", "asc");

        return $this->db->get()->result();
    }

    function getRoleMenuById($id)
    {
        $this->db->select("srm.*, sr.role_name, sm.menu_name");
        $this->db->from("storage_role_menu srm");
        $this->db->join("storage_role sr", "sr.id = srm.role_id");
        $this->db->join("storage_menu sm", "sm.id = srm.menu_id");
        $this->db->where("srm.id", $id);

        return $this->db->get()->result();
    }











    function _datatablesRoleMenu()
    {
        $this->db->select("rm.*, m.menu_name");
        $this->db->from("storage_role_menu rm");
        $this->db->join("storage_menu m", "rm.menu_id = m.id", "left");
        $this->db->order_by("m.menu_name", "asc");
        $this->db->where("role_id", $this->input->post('role_id'));
    }

    function datatablesRoleMenu()
    {
        $this->_datatablesRoleMenu();

        return $this->db->get()->result();
    }

    function countdatatablesRoleMenu()
    {
        $this->_datatablesRoleMenu();

        return $this->db->get()->num_rows();
    }

    function checkRoleMenu($role_id, $menu_id)
    {
        $this->db->select("*");
        $this->db->from("storage_role_menu");
        $this->db->where("role_id", $role_id);
        $this->db->where("menu_id", $menu_id);

        return $this->db->get()->first_row();
    }

    function checkRole($role_id)
    {
        return $this->db->query("SELECT * FROM storage_user_role
        where role_id = '$role_id'")->result();
    }
}
