<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class MenuLibrary
{
    function __construct()
    {
        $this->CI = &get_instance();
        $this->CI->load->model('M_dashboard');
    }

    function loadSideBarMenu($user_id)
    {
        $user_id    = $this->CI->session->userdata("user_id");

        $menu_level_1        = $this->CI->M_dashboard->loadMenuList($user_id, 1, 0);

        $html_out       = "";

        // if (count($menu_level_1) == 0) {
        //     redirect(base_url('index.php/Login'));
        // }

        foreach ($menu_level_1 as $menu1) {
            /**
             * MENU LEVEL 1
             */
            if ($menu1->is_parent_menu == 1) {

                $is_active  = $this->CI->router->fetch_class() == $menu1->url ? 'active' : '';
                $html_out .= "
                    <li class='nav-header'>
                        <a href='"  . $menu1->url . "' class='nav-link'>
                        </a> $menu1->menu_name
                    </li>
                    ";
                // echo ">$menu1->menu_name";
                // echo "<br>";

                $menu_level_2        = $this->CI->M_dashboard->loadMenuList($user_id, 2, $menu1->id);

                foreach ($menu_level_2 as $menu2) {
                    // MENU LEVEL 2

                    // echo ">> $menu2->menu_name";
                    // echo "<br>";
                    if ($menu2->is_parent_menu == 1) {
                        $menu_level_3        = $this->CI->M_dashboard->loadMenuList($user_id, 3, $menu2->id);

                        $url        = "#";

                        if ($menu2->url != "" && $menu2->url != null) {
                            $url        =  $menu2->url;
                        }

                        $is_active  = $this->CI->router->fetch_class() == $menu2->url ? 'active' : '';

                        $html_out = $html_out . "<li class='nav-item'>
                            <a href='"  . base_url('index.php/' . $url) . "' class='nav-link $is_active'>";

                        if ($menu2->menu_icon != null && $menu2->menu_icon != "") {
                            $html_out .= "<i class='fa " . $menu2->menu_icon . " nav-icon'></i>";
                        }

                        $html_out .= "
                        
                        <p>
                            $menu2->menu_name
                            
                            <i class='right fas fa-angle-left'></i> </p></a>
                          <ul class='nav nav-treeview'>";

                        foreach ($menu_level_3 as $menu3) {
                            // echo ">>> $menu3->menu_name";
                            // echo "<br>";
                            $url        = "#";

                            if ($menu3->url != "" && $menu3->url != null) {
                                $url        =  $menu3->url;
                            }

                            $is_active  = $this->CI->router->fetch_class() == $menu3->url ? 'active' : '';

                            if ($menu3->url != "" && $menu3->url != null) {
                                $html_out .= "<li class='nav-item'>
                                    <a href='"   . base_url('index.php/' . $url) . "' class='nav-link $is_active'>";

                                if ($menu3->menu_icon != null && $menu3->menu_icon != "") {
                                    $html_out .= "<i class='fa " . $menu3->menu_icon . " nav-icon'></i><p>";
                                }

                                $html_out .= $menu3->menu_name . "</p></a></li>";
                            }
                        }
                        $html_out .= "</ul></li>";
                    } else {
                        $url        = "#";

                        if ($menu2->url != "" && $menu2->url != null) {
                            $url        =  $menu2->url;
                        }

                        $is_active  = $this->CI->router->fetch_class() == $menu2->url ? 'active' : '';

                        if ($menu2->url != "" && $menu2->url != null) {
                            $html_out = $html_out . "<li class='nav-item'>
                            <a href='"  . base_url('index.php/' . $url) . "' class='nav-link $is_active'>";

                            if ($menu2->menu_icon != null && $menu2->menu_icon != "") {
                                $html_out .= "<i class='fa " . $menu2->menu_icon . " nav-icon'></i><p>";
                            }

                            $html_out .= $menu2->menu_name . "</p></a></li>";
                        }
                    }
                }
            } else {
                $url        = "#";

                if ($menu1->url != "" && $menu1->url != null) {
                    $url        = $menu1->url;
                }

                $is_active  = $this->CI->router->fetch_class() == $menu1->url ? 'active' : '';

                if ($menu1->url != "" && $menu1->url != null) {
                    $html_out = $html_out . "<li class='nav-item'>
                        <a href='" . base_url('index.php/' . $url) . "' class='nav-link $is_active'>";

                    if ($menu1->menu_icon != null && $menu1->menu_icon != "") {
                        $html_out .= "<i class='fa " . $menu1->menu_icon . " nav-icon'></i><p>";
                    }

                    $html_out .= $menu1->menu_name . "</p></a></li>";
                }

                // echo "$menu1->menu_name";
                // echo "<br>";
            }
        }

        echo $html_out;

        // return $html_out;
    }

    function checkUserAccess()
    {
        $check  = $this->CI->M_dashboard->checkUserAccessMenu($this->CI->session->userdata("user_id"), $this->CI->router->fetch_class());

        if ($check) {
            return true;
        } else {
            return false;
        }
    }
}
