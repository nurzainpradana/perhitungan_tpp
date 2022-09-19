<?php
class UserLog
{
    function __construct()
    {
        $this->CI = &get_instance();
        $this->CI->load->model('M_crud');
    }

    function saveLog($module, $content_desc, $status)
    {
        $data       = array(
            'datetime'          => date("Y-m-d H:i:s"),
            'user_id'              => $this->CI->session->userdata('user_id'),
            'module'            => $module,
            'content_desc'      => $content_desc,
            'status'            => $status,
            'ip_address'        => $_SERVER['REMOTE_ADDR']
        );

        $this->CI->M_crud->insert('storage_user_log', $data);
    }

    function saveLogWithData($module, $content_desc, $status, $data)
    {
        $data       = array(
            'datetime'          => date("Y-m-d H:i:s"),
            'user_id'              => $this->CI->session->userdata('user_id'),
            'module'            => $module,
            'content_desc'      => $content_desc,
            'status'            => $status,
            'data'              => json_encode($data),
            'ip_address'        => $_SERVER['REMOTE_ADDR']
        );

        $this->CI->M_crud->insert('storage_user_log', $data);
    }
}
