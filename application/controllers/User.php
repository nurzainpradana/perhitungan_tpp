<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
    var $module;

    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('logged') !== TRUE) {
            redirect(base_url() . 'index.php/Login');
        }

        if (!$this->menulibrary->checkUserAccess()) {
            redirect(base_url() . 'index.php');
        }

        $this->load->model(array('M_user'));
        $this->module       = "USER";
    }

    function index()
    {
        $datas['page_title']        = "User";

        $data['employee']      = $this->M_user->loadEmployeeList();
        $data['role']           = $this->M_user->loadRoleList();

        $this->load->view('layout/v_header', $datas);
        $this->load->view('layout/v_top_menu');
        $this->load->view('layout/v_sidebar');
        $this->load->view('user/v_user', $data);
        $this->load->view('layout/v_footer');
    }

    function insert()
    {
        $data       = array(
            'user_id'               => $this->input->post("employee")
        );

        $insert     = $this->M_crud->insert("storage_user", $data);

        if ($insert) {
            $this->userlog->saveLogWithData($this->module, "Insert User Successfully", "SUCCESS", $data);

            echo json_encode(array("status" => "true"));
        } else {
            $this->userlog->saveLogWithData($this->module, "Failed to Insert User", "FAILED", $data);
            echo json_encode(array("status" => "false", "message" => "failed"));
        }
    }

    function updateUser()
    {
        $data       = array(
            'user_role'     => $this->input->post("role_id")
        );

        $where      = array(
            'id'            => $this->input->post("id")
        );

        $update     = $this->M_crud->update("storage_user", $data, $where);

        if ($update) {
            $response_status    = "success";
            $response_message   = "Update User Successfully";
        } else {
            $response_status    = "failed";
            $response_message   = "Failed when Update User";
        }

        $result     = array(
            'status'        => $response_status,
            'message'       => $response_message
        );

        echo json_encode($result);
    }

    function datatablesUserList()
    {

        $user      = $this->M_user->loaduserlist();

        $data               = array();

        $no                 = $_POST['start'];

        foreach ($user as $item) {
            $no++;
            $row        = array();
            $row[]      = $no;

            // $row[]      = "<a class='text-bold text-primary' title='Edit' onclick='editLocation(".$location->id.")'>".$location->location_name."</a>";
            $row[]      = "$item->idnpk - $item->employee_name";

            $row[]      = "
            <a href='" . base_url() . 'index.php/User/setRole/' . $item->id . "' class='btn btn-xs btn-success' title='User Role'><i class='fa fa-bars'></i></a>
            <button onclick='deleteUser($item->id)' class='btn btn-xs btn-danger' title='Delete User'><i class='fa fa-trash'></i></button>
            ";
            $data[]     = $row;
        }

        $output         = array(
            "draw"              => $_POST['draw'],
            "recordsTotal"      => $this->M_user->count_all(),
            "recordsFiltered"   => $this->M_user->count_filtered(),
            "data"              => $data,
        );

        // output to json format

        echo json_encode($output);
    }

    function addUserRole()
    {
        $user_id        = $this->input->post("user_id");
        $role_id        = $this->input->post("role_id");

        $check      = $this->M_user->checkUserRole($user_id, $role_id);

        $data       = array(
            'id_user'       => $this->input->post("user_id"),
            'role_id'       => $this->input->post("role_id")
        );

        $insert     = $this->M_crud->insert("storage_user_role", $data);

        if ($insert) {
            $response_status    = "success";
            $response_message   = "Add User Role Successfully";
        } else {
            $response_status    = "failed";
            $response_message   = "Failed to Add User Role";
        }

        $result         = array(
            'status'        => $response_status,
            'message'       => $response_message
        );

        echo json_encode($result);
    }

    function deleteUser()
    {
        $where          = array(
            'id'    => $this->input->post('id')
        );

        $delete     = $this->M_crud->delete("storage_user", $where);

        $where          = array(
            'id_user'    => $this->input->post('id')
        );

        $delete     = $this->M_crud->delete("storage_user_role", $where);

        if ($delete) {
            $response_status    = "success";
            $response_message   = "Delete User Successfully";
        } else {
            $response_status    = "failed";
            $response_message   = "Failed when delete User";
        }

        $result     = array(
            'status'        => $response_status,
            'message'       => $response_message
        );

        echo json_encode($result);
    }

    function deleteUserRole()
    {
        $where          = array(
            'id'    => $this->input->post('user_role_id')
        );

        $delete     = $this->M_crud->delete("storage_user_role", $where);

        if ($delete) {
            $response_status    = "success";
            $response_message   = "Delete User Role Successfully";
        } else {
            $response_status    = "failed";
            $response_message   = "Failed when delete User Role";
        }

        $result     = array(
            'status'        => $response_status,
            'message'       => $response_message
        );

        echo json_encode($result);
    }

    function setRole($id)
    {
        $user   = $this->M_user->getDetailUser($id);

        $data['id']             = $id;
        $data['employee_name']  = $user->employee_name;
        $data['role']           = $this->M_user->loadRoleList();

        $datas['page_title']        = "User Role";

        $this->load->view('layout/v_header', $datas);
        $this->load->view('layout/v_top_menu');
        $this->load->view('layout/v_sidebar');
        $this->load->view('user/v_user_role', $data);
        $this->load->view('layout/v_footer');
    }

    function detailUser()
    {
        $user_id        = $this->input->post("id");

        $user           = $this->M_user->getDetailUser($user_id);

        if ($user) {
            $response_status    = "success";
            $response_message   = "Successfully";
            $response_data      = $user;
        } else {
            $response_status    = "failed";
            $response_message   = "Failed to get User Detail";
            $response_data      = null;
        }

        $result         = array(
            'status'        => $response_status,
            'message'       => $response_message,
            'data'          => $response_data
        );

        echo json_encode($result);
    }

    function datatablesUserRole()
    {
        if ($this->input->post('user_id')) {
            $menu       = $this->M_user->datatablesUserRole();

            $data   = array();
            if ($menu) {
                foreach ($menu as $i) {
                    $row        = array();
                    $row[]      = $i->role_name;
                    $row[]      = "
                    <button onclick='deleteUserRole($i->id)' class='btn btn-sm btn-danger'><i class='fa fa-trash'></i></button>
                    ";

                    $data[]     = $row;
                }
            }

            $output         = array(
                "draw"              => $_POST['draw'],
                "recordsTotal"      => $this->M_user->countdatatablesUserRole(),
                "recordsFiltered"   => $this->M_user->countdatatablesUserRole(),
                "data"              => $data,
            );
        } else {
            $output         = array(
                "draw"              => 0,
                "recordsTotal"      => 0,
                "recordsFiltered"   => 0,
                "data"              => array(),
            );
        }


        // output to json format

        echo json_encode($output);
    }
}
