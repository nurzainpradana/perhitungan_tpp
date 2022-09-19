<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Role extends CI_Controller
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

        $this->load->model(array('M_role', 'M_menu'));
        $this->module       = "ROLE";
    }

    function index()
    {
        $datas['page_title']        = "Role";

        $data['menu_list']          = $this->M_menu->loadlist();

        $this->load->view('layout/v_header', $datas);
        $this->load->view('layout/v_top_menu');
        $this->load->view('layout/v_sidebar');
        $this->load->view('role/v_role', $data);
        $this->load->view('layout/v_footer');
    }

    function insert()
    {
        $data       = array(
            'role_name'       => strtoupper($this->input->post("role"))
        );

        $insert     = $this->M_crud->insert("storage_role", $data);

        if ($insert) {
            $this->userlog->saveLogWithData($this->module, "Insert Role Successfully", "SUCCESS", $data);

            echo json_encode(array("status" => "true"));
        } else {
            $this->userlog->saveLogWithData($this->module, "Failed to Insert Role", "FAILED", $data);
            echo json_encode(array("status" => "false", "message" => "failed"));
        }
    }

    function loadDetailRole()
    {
        $role_id        = $this->input->post("role_id");

        $response_status    = 'failed';
        $response_message   = '';
        $response_data      = null;

        $role           = $this->M_role->loadRoleDetail($role_id);

        if ($role) {
            $response_status    = "success";
            $response_message   = "Successfully";
            $response_data      = $role;
        } else {
            $response_message   = "Failed to get Detail Role";
        }

        $result     = array(
            'status'        => $response_status,
            'message'       => $response_message,
            'data'          => $response_data
        );

        echo json_encode($result);
    }

    function datatablesRoleList()
    {

        $user      = $this->M_role->loadrolelist();

        $data               = array();

        $no                 = $_POST['start'];

        foreach ($user as $item) {
            $no++;
            $row        = array();
            $row[]      = $no;

            // $row[]      = "<a class='text-bold text-primary' title='Edit' onclick='editLocation(".$location->id.")'>".$location->location_name."</a>";
            $row[]      = "$item->role_name";

            // $row[]      = "
            // <button class='btn btn-xs btn-primary' onclick='roleMenu($item->id)'><i class='fa fa-edit'></i></button>
            // ";

            $row[]      = "
            <a class='btn btn-xs btn-secondary' href='" . base_url() . "index.php/Role/SetMenu/" . $item->id . "'><i class='fa fa-bars'></i> </a>
            <button onclick='deleteRole($item->id)' class='btn btn-xs btn-danger'><i class='fa fa-trash'></i></button>
            ";

            $data[]     = $row;
        }

        $output         = array(
            "draw"              => $_POST['draw'],
            "recordsTotal"      => $this->M_role->loadRoleListCount(),
            "recordsFiltered"   => $this->M_role->loadRoleListCount(),
            "data"              => $data,
        );

        // output to json format

        echo json_encode($output);
    }

    function setMenu($id)
    {
        $data['role_menu']      = $this->M_role->getRoleMenuById($id);
        $data['menu_list']      = $this->M_role->loadMenuList($id);

        $role                   = $this->M_role->loadRoleDetail($id);

        $data['role_id']        = $id;
        $data['role_name']      = $role->role_name;

        $datas['page_title']        = "Role";

        $this->load->view('layout/v_header', $datas);
        $this->load->view('layout/v_top_menu');
        $this->load->view('layout/v_sidebar');
        $this->load->view('role/v_role_menu', $data);
        $this->load->view('layout/v_footer');
    }

    function updateRole()
    {
        $role_id        = $this->input->post("role_id");
        $role_name      = $this->input->post("role_name");

        $response_status    = 'failed';
        $response_message   = '';

        if ($role_id != null && $role_id != "") {
            $data       = array(
                'role_name'     => strtoupper($role_name)
            );

            $where      = array(
                'id'            => $role_id
            );

            $update     = $this->M_crud->update('storage_role', $data, $where);

            if ($update) {
                $response_status    = "success";
                $response_message   = "Update Role Successfully";
            } else {
                $response_message   = "Failed to update Role";
            }
        } else {
            $response_message       = "Failed to Update, Check Role Id";
        }

        $result     = array(
            'status'        => $response_status,
            'message'       => $response_message
        );

        echo json_encode($result);
    }


    function addRoleMenu()
    {
        $menu_id        = $this->input->post("menu_id");
        $role_id        = $this->input->post("role_id");

        $response_status    = 'failed';
        $response_message   = '';

        if ($menu_id != "" && $menu_id != null && $role_id != null && $role_id != "") {

            $data       = array(
                'role_id'      => $role_id,
                'menu_id'      => $menu_id
            );

            $check      = $this->M_role->checkRoleMenu($role_id, $menu_id);

            if ($check) {
                $response_message   = "Menu Already Registered";
            } else {
                $insert     = $this->M_crud->insert("storage_role_menu", $data);

                if ($insert) {
                    $response_status    = "success";
                    $response_message   = "Add Role Menu Successfully";
                } else {
                    $response_message   = "Failed when add Role Menu";
                }
            }
        } else {
            $response_message   = "Failed to Add Role Menu, Check Your Data";
        }

        $result     = array(
            "status"        => $response_status,
            "message"       => $response_message
        );

        echo json_encode($result);
    }

    function deleteRoleMenu()
    {
        $response_status    = 'failed';
        $response_message   = '';

        $where      = array(
            'id'            => $this->input->post("role_menu_id")
        );

        $delete     = $this->M_crud->delete("storage_role_menu", $where);

        if ($delete) {
            $response_status    = "success";
            $response_message   = "Delete Role Menu Successfully";
        } else {
            $response_status    = "failed";
            $response_message   = "Failed when Delete Role Menu";
        }

        $result     = array(
            'status'        => $response_status,
            'message'       => $response_message
        );

        echo json_encode($result);
    }









    function datatablesRoleMenu()
    {
        if ($this->input->post('role_id')) {
            $role_id    = $this->input->post('role_id');
            $menu       = $this->M_role->datatablesRoleMenu();

            $data   = array();
            if ($menu) {
                foreach ($menu as $i) {
                    $row        = array();
                    $row[]      = $i->menu_name;
                    $row[]      = "
                    <button onclick='deleteRoleMenu($i->id)' class='btn btn-sm btn-danger'><i class='fa fa-trash'></i></button>
                    ";

                    $data[]     = $row;
                }
            }

            $output         = array(
                "draw"              => $_POST['draw'],
                "recordsTotal"      => $this->M_role->countdatatablesRoleMenu(),
                "recordsFiltered"   => $this->M_role->countdatatablesRoleMenu(),
                "data"              => $data,
            );
        } else {
            $output         = array(
                "draw"              => 0,
                "recordsTotal"      => $this->M_role->countdatatablesRoleMenu(),
                "recordsFiltered"   => $this->M_role->countdatatablesRoleMenu(),
                "data"              => array(),
            );
        }


        // output to json format

        echo json_encode($output);
    }

    function deleteRole()
    {
        $role_id        = $this->input->post("role_id");

        $check          = $this->M_role->checkRole($role_id);

        $response_status    = "failed";
        $response_message   = "";

        if (count($check) > 0) {
            $response_message       = "Role Currently used";
        } else {
            $where      = array(
                'id'        => $role_id
            );

            $delete     = $this->M_crud->delete("storage_role", $where);

            $where      = array(
                'role_id'        => $role_id
            );

            $delete     = $this->M_crud->delete("storage_role_menu", $where);

            if ($delete) {
                $response_status    = "success";
                $response_message   = "Delete Role Successfully";
            } else {
                $response_message   = "Failed when Delete Role";
            }
        }

        $result         = array(
            'status'        => $response_status,
            'message'       => $response_message
        );

        echo json_encode($result);
    }
}
