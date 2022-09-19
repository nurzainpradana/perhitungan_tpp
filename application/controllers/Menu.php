<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu extends CI_Controller
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

        $this->load->model(array('M_menu'));
        $this->module       = "MENU";
    }

    function index()
    {
        $datas['page_title']        = "Menu";

        $this->load->view('layout/v_header', $datas);
        $this->load->view('layout/v_top_menu');
        $this->load->view('layout/v_sidebar');
        $this->load->view('menu/v_menu');
        $this->load->view('layout/v_footer');
    }

    function insert()
    {
        $url        = $this->input->post("url");
        if ($url == NULL) {
            $url = "";
        }

        $data       = array(
            'menu_name'             => strtoupper($this->input->post("menu_name")),
            'url'                   => strtoupper($this->input->post("url")),
            'menu_level'            => strtoupper($this->input->post("menu_level")),
            'is_parent_menu'        => strtoupper($this->input->post("is_parent_menu")),
            'parent_menu'           => strtoupper($this->input->post("parent_menu")),
            'menu_icon'             => strtolower($this->input->post("menu_icon")),
            'status'                => strtoupper($this->input->post("status"))
        );

        $insert     = $this->M_menu->insert($data);

        if ($insert) {
            $this->userlog->saveLogWithData($this->module, "Insert Menu Successfully", "SUCCESS", $data);

            echo json_encode(array("status" => "true"));
        } else {
            $this->userlog->saveLogWithData($this->module, "Failed to Insert Menu", "FAILED", $data);
            echo json_encode(array("status" => "false", "message" => "failed"));
        }
    }

    function datatablesList()
    {

        $user      = $this->M_menu->loadlist();

        $data               = array();

        $no                 = $_POST['start'];

        foreach ($user as $item) {
            $no++;
            $row        = array();
            $row[]      = $item->menu_level;

            $menu_orders    = "";

            $menu_orders    .= $item->menu_order . "   ";


            if ($item->menu_order > $item->order_start) {
                $menu_orders    .= "<a href='#' onclick='orderup($item->id)'><i class='fas fa-angle-double-up'></i></a> ";
            }


            if ($item->menu_order < $item->order_end) {
                $menu_orders    .= "<a href='#' onclick='orderdown($item->id)'><i class='fas fa-angle-double-down'></i></a>";
            }


            $row[]      = $menu_orders;

            $menu_name      = $item->menu_name;
            if ($item->is_parent_menu == 1) {
                $menu_name .= " <i class='fas text-primary fa-chevron-circle-down'></i>";
            }

            $row[]      = $menu_name;
            $url        = "-";
            if ($item->url != "" && $item->url != null) {
                $url        = $item->url;
            }
            $row[]      = $url;

            $menu_icon      = "-";
            if ($item->menu_icon != "" && $item->menu_icon != null) {
                $menu_icon  = "<i class='fa " . $item->menu_icon . " nav-icon'></i> $item->menu_icon";
            }
            $row[]      = $menu_icon;
            if ($item->parent_menu == 0) {
                $parent_menu    = '-';
            } else {
                $parent_menu    = $item->parent_menu_name;
            }
            $row[]      = $parent_menu;

            if ($item->status == 1) {
                $status     = "<span class='btn-sm btn-success'>Enable</span>";
            } else {
                $status     = "<span class='btn-sm btn-danger'>Disable</span>";
            }
            $row[]      = $status;
            $row[]      = "
            <button onclick='edit($item->id)' class='btn btn-xs btn-primary' title='Edit'><i class='fa fa-edit'></i></button>
            <button onclick='deletemenu($item->id)' class='btn btn-xs btn-danger' title='Delete'><i class='fa fa-trash'></i></button>
            ";

            $data[]     = $row;
        }

        $output         = array(
            "draw"              => $_POST['draw'],
            "recordsTotal"      => $this->M_menu->loadListCount(),
            "recordsFiltered"   => $this->M_menu->loadListCount(),
            "data"              => $data,
        );

        // output to json format

        echo json_encode($output);
    }

    function loadParentMenu()
    {
        $level                  = $this->input->post("level");

        $parent_menu            = $this->M_menu->loadParentMenuByLevel($level);

        $result         = "<option value='0'>No Parent Menu</option>";


        if ($parent_menu) {
            print_r($parent_menu);
            foreach ($parent_menu as $parent) {
                $result .= "<option value='$parent->id'>$parent->menu_name</option>";
            }
        }
        echo $result;
    }

    function editMenu()
    {
        $menu_id            = $this->input->post("menu_id");

        $menu               = $this->M_menu->loadMenuDetail($menu_id);

        $response_status    = "failed";
        $response_message   = "";
        $response_data      = null;

        if ($menu) {
            $response_status    = "success";
            $response_message   = "Successfully";
            $response_data      = $menu;
        } else {
            $response_message   = "Failed to get Menu Data";
        }

        $result     = array(
            'status'        => $response_status,
            'message'       => $response_message,
            'data'          => $response_data
        );

        echo json_encode($result);
    }

    function processUpdateMenu()
    {
        $menu_id            = $this->input->post("edit_menu_id");
        $menu_level         = $this->input->post("edit_menu_level");
        $menu_name          = $this->input->post("edit_menu_name");
        $url                = $this->input->post("edit_url");
        $menu_icon          = $this->input->post("edit_menu_icon");
        $parent_menu        = $this->input->post("edit_parent_menu");
        $is_parent_menu     = $this->input->post("edit_is_parent_menu");
        $status             = $this->input->post("edit_status");

        $data               = array(
            'id'                => $menu_id,
            'menu_level'        => $menu_level,
            'menu_name'         => $menu_name,
            'url'               => $url,
            'menu_icon'         => $menu_icon,
            'parent_menu'       => $parent_menu,
            'is_parent_menu'    => $is_parent_menu,
            'status'            => $status
        );

        // $where              = array(
        //     'id'        => $menu_id
        // );

        $update             = $this->M_menu->updateMenu($data);

        $response_status        = 'failed';
        $response_message       = '';

        if ($update) {
            if ($update->Result == 'success') {
                $response_status    = 'success';
                $response_message   = 'Update Menu Successfully!';
            } else {
                $response_message   = $update->message;
            }
        } else {
            $response_message   = "Failed when update Menu";
        }

        $result             = array(
            'status'            => $response_status,
            'message'           => $response_message
        );

        echo json_encode($result);
    }

    function orderup()
    {
        $menu_id    = $this->input->post("menu_id");

        $query      = $this->M_menu->orderup($menu_id);

        $response_status    = "failed";
        $response_message   = "";

        if ($query) {
            if ($query->Result == "success") {
                $response_status    = $query->Result;
                $response_message   = $query->message;
            } else {
                $response_message      = $query->message;
            }
        } else {
            $response_message      = "Failed Process Order Up Menu";
        }

        $result     = array(
            'status'        => $response_status,
            'message'       => $response_message
        );

        echo json_encode($result);
    }

    function orderdown()
    {
        $menu_id    = $this->input->post("menu_id");

        $query      = $this->M_menu->orderdown($menu_id);

        $response_status    = "failed";
        $response_message   = "";

        if ($query) {
            if ($query->Result == "success") {
                $response_status    = $query->Result;
                $response_message   = $query->message;
            } else {
                $response_message      = $query->message;
            }
        } else {
            $response_message      = "Failed Process Order Down Menu";
        }

        $result     = array(
            'status'        => $response_status,
            'message'       => $response_message
        );

        echo json_encode($result);
    }

    function deletemenu()
    {
        $menu_id        = $this->input->post("menu_id");

        $query          = $this->M_menu->delete($menu_id);

        if ($query) {
            if ($query->Result == 'success') {
                $response_status    = "success";
                $response_message   = $query->message;
            } else {
                $message = "Failed when Process Delete";

                $response_status    = "failed";
                $response_message   = $message;
            }
        } else {
            $response_message   = "Failed to Process Delete";
        }

        $result     = array(
            'status'        => $response_status,
            'message'       => $response_message
        );

        echo json_encode($result);
    }
}
