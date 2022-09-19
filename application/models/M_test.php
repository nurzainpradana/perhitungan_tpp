<?php
defined('BASEPATH') or exit('No Direct script access allowed');

class M_test extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    function loadMenuList($user_id, $level, $parent)
    {
        if ($level == 1) {
            return $this->db->query("SELECT DISTINCT sm.id, sm.*
            FROM storage_user su
            LEFT JOIN storage_user_role sur ON sur.id_user = su.id
            LEFT JOIN storage_role sr ON sr.id = sur.role_id
            LEFT JOIN storage_role_menu srm ON srm.role_id = sr.id 
            LEFT JOIN storage_menu sm ON sm.id = srm.menu_id
            WHERE su.user_id = '$user_id' AND sm.menu_level = '$level'
            ")->result();
        } else if ($parent == 0) {
            return $this->db->query("SELECT DISTINCT sm.id, sm.*
            FROM storage_user su
            LEFT JOIN storage_user_role sur ON sur.id_user = su.id
            LEFT JOIN storage_role sr ON sr.id = sur.role_id
            LEFT JOIN storage_role_menu srm ON srm.role_id = sr.id 
            LEFT JOIN storage_menu sm ON sm.id = srm.menu_id
            WHERE su.user_id = '$user_id' AND sm.menu_level = '$level'")->result();
        } else {
            return $this->db->query("SELECT DISTINCT sm.id, sm.*
            FROM storage_user su
            LEFT JOIN storage_user_role sur ON sur.id_user = su.id
            LEFT JOIN storage_role sr ON sr.id = sur.role_id
            LEFT JOIN storage_role_menu srm ON srm.role_id = sr.id 
            LEFT JOIN storage_menu sm ON sm.id = srm.menu_id
            WHERE su.user_id = '$user_id' AND sm.menu_level = '$level' AND sm.parent_menu = '$parent'")->result();
        }
    }
}
