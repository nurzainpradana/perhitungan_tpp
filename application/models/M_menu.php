<?php
defined('BASEPATH') or exit('No Direct script access allowed');

class M_Menu extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->search   = '';
    }

    function _loadlist()
    {
        $this->db->select("sm.*, (SELECT TOP 1 menu_name FROM storage_menu sm2 WHERE sm2.id = sm.parent_menu) parent_menu_name,
        (SELECT TOP 1 menu_order FROM storage_menu sm1 WHERE sm1.menu_level = sm1.menu_level AND sm1.parent_menu = sm.parent_menu ORDER BY menu_order ASC) order_start, 
        (SELECT TOP 1 menu_order FROM storage_menu sm1 WHERE sm1.menu_level = sm1.menu_level AND sm1.parent_menu = sm.parent_menu ORDER BY menu_order DESC) order_end, 
        ");
        $this->db->from("storage_menu sm");
        $this->db->order_by("sm.status", "DESC");
        $this->db->order_by("sm.menu_level", "ASC");
        $this->db->order_by("sm.menu_order", "ASC");

        if ($this->input->post("menu_name")) {
            $this->db->where("sm.menu_name", $this->input->post("menu_name"));
        }

        if ($this->input->post("menu_level")) {
            $this->db->where("sm.menu_level", $this->input->post("menu_level"));
        }

        if ($this->input->post("parent_menu")) {
            $this->db->where("sm.parent_menu", $this->input->post("parent_menu"));
        }

        if ($this->input->post("status")) {
            $this->db->where("sm.status", $this->input->post("status"));
        }

        if ($this->input->post("url")) {
            $this->db->where("sm.url", $this->input->post("url"));
        }

        if ($this->input->post("is_parent_menu")) {
            $this->db->where("sm.is_parent_menu", $this->input->post("is_parent_menu"));
        }
    }

    function loadlist()
    {
        $this->_loadlist();

        return $this->db->get()->result();
    }

    function loadListCount()
    {
        $this->_loadlist();

        return $this->db->get()->num_rows();
    }

    function  updateMenu($data)
    {
        $sp     = "sp_menuupdate ?,?,?,?,?,?,?,?";
        $query  = $this->db->query($sp, $data);

        return $query->first_row();
    }

    function insert($data)
    {
        $sp = "sp_menuinsert ?,?,?,?,?,?,?";
        $query  = $this->db->query($sp, $data);

        return $query->first_row();
    }

    function loadParentMenuByLevel($level)
    {
        $this->db->select("id, menu_name");
        $this->db->from("storage_menu");
        $this->db->where("menu_level", $level - 1);
        $this->db->where("is_parent_menu", 1);
        $this->db->order_by("menu_order", "ASC");

        return $this->db->get()->result();
    }

    function loadMenuDetail($menu_id)
    {
        $this->db->select('*');
        $this->db->from("storage_menu");
        $this->db->where("id", $menu_id);

        return $this->db->get()->row();
    }

    function orderup($menu_id)
    {
        $sp = "sp_menuorderup $menu_id";
        $query  = $this->db->query($sp);

        return $query->first_row();
    }

    function orderdown($menu_id)
    {
        $sp = "sp_menuorderdown $menu_id";
        $query  = $this->db->query($sp);

        return $query->first_row();
    }

    function delete($menu_id)
    {
        $sp = "sp_menudelete $menu_id";
        $query  = $this->db->query($sp);

        return $query->first_row();
    }
}
