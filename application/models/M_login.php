<?php
defined('BASEPATH') or exit('No Direct script access allowed');

class M_login extends CI_Model
{
    function checkUserId($user_id, $pass)
    {
        $this->db->select("*");
        $this->db->from("tb_pegawai");
        $this->db->where("user_id", $user_id);
        $this->db->where("password", md5($pass));

        return $this->db->get()->row();
    }
}
