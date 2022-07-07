<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu_management extends CI_Controller
{
    public $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library('bmw_functions');
        $this->load->model('Akun_model', 'akun');
        $this->load->model('Web_model', 'web_settings');
        $this->load->model('User_model', 'user_m');
        $this->load->model('Menu_model', 'menu');
        // $this->load->model('Home_model');
    }
    public function index()
    {
        if (!isset($this->session->userdata['email'])) {

            redirect('/');
        } else {
            if ($this->session->userdata['role_id'] > 1) {
                redirect('home');
            }
            $profile = $this->user_m->getInfo($this->session->userdata('email'));
            $settings = $this->web_settings->get_web_settings();

            $settings = $settings[0];
            // $this->bmw_functions->cekAccessMenu();
            // die;
            $data = [
                'title' => 'Menu Management',
                'profile' => $profile,
                'settings' => $settings,
                'link' => $this->bmw_functions->breadcrumb()
            ];
            $this->load->view("templates/home-h", $data);
            $this->load->view("templates/home-t-s", $data);
            $this->load->view("templates/home-nav", $data);
            $this->load->view("menu/index");
            $this->load->view("templates/home-f");
        }
    }


    // Child
    public function user()
    {
        if (!isset($this->session->userdata['email'])) {

            redirect('/');
        } else {

            if ($this->session->userdata['role_id'] > 1) {
                redirect('home');
            }
            $this->form_validation->set_rules('name', 'Name', 'required|is_unique[user_menu.menu]');
            if ($this->form_validation->run() == false) {
                //delete
                $uri = $this->uri->segment(3);
                if ($uri == "del") {
                    $id = $this->uri->segment(4);
                    $data = [
                        'id' => $id,

                    ];

                    $this->_delUserMenu($data);
                }
                // end delete
                $profile = $this->user_m->getInfo($this->session->userdata('email'));
                $settings = $this->web_settings->get_web_settings();
                $user_menu = $this->menu->getUsermenu();
                $settings = $settings[0];

                $data = [
                    'title' => 'User Menu Management',
                    'profile' => $profile,
                    'settings' => $settings,
                    'data_user_menu' => $user_menu,
                    'link' => $this->bmw_functions->breadcrumb()
                ];
                $this->load->view("templates/home-h", $data);
                $this->load->view("templates/home-t-s", $data);
                $this->load->view("templates/home-nav", $data);
                $this->load->view("menu/user");
                $this->load->view("templates/home-f");
            } else {
                $uri = $this->uri->segment(3);
                $id =  $this->input->post("id");
                $name =  $this->input->post("name");
                $data = [
                    'id' => $id,
                    'menu' => $name
                ];
                if ($uri == "add") {

                    $this->_userAdd($data);
                } else if ($uri == "edit") {

                    $this->_userEdit($data);
                }
            }
        }
    }
    public function user_access()
    {
        if (!isset($this->session->userdata['email'])) {

            redirect('/');
        } else {
            if ($this->session->userdata['role_id'] > 1) {
                redirect('home');
            }
            $this->form_validation->set_rules('role_id', 'Role', 'required');
            $this->form_validation->set_rules('menu', 'Menu', 'required');
            if ($this->form_validation->run() == false) {
                // delete
                $uri = $this->uri->segment(3);
                if ($uri == "del") {
                    $role = $this->uri->segment(4);
                    $menu = $this->uri->segment(5);

                    $data = [
                        'role' => $role,
                        'menu' => $menu
                    ];

                    $this->_delUserAccess($data);
                }
                // end delete
                $profile = $this->user_m->getInfo($this->session->userdata('email'));
                $settings = $this->web_settings->get_web_settings();
                $access = $this->menu->getAccessuser();
                $role_id = $this->menu->getUsermenu();
                $settings = $settings[0];

                $data = [
                    'title' => 'Menu Management',
                    'profile' => $profile,
                    'settings' => $settings,
                    'data_user_menu' => $access,
                    'role_id' => $role_id,
                    'link' => $this->bmw_functions->breadcrumb()
                ];
                $this->load->view("templates/home-h", $data);
                $this->load->view("templates/home-t-s", $data);
                $this->load->view("templates/home-nav", $data);
                $this->load->view("menu/user_access");
                $this->load->view("templates/home-f");
            } else {
                $uri = $this->uri->segment(3);
                if ($uri == "add") {
                    // $join_data = [
                    //     'sel' => '*',
                    //     'frm' => 'user_menu',
                    //     'tbl_frm' => 'id',
                    //     'join' => '',
                    //     'tbl_join' => '',
                    //     'type' => '',
                    //     'order' => '',
                    //     'order_con' => ''
                    // ];
                    // $join = $this->menu->join2Table($join_data);

                    $role = $this->input->post("role_id");
                    $menu = $this->input->post("menu");

                    $role_text = $this->menu->getWhereUsermenu($role);
                    $role_text = $role_text['menu'];

                    $data = [
                        'id' => '',
                        'role_id' => $role,
                        'menu_id' => $menu,
                        'role_text' => $role_text
                    ];

                    $this->_accessAdd($data);
                }
            }
        }
    }

    public function sub_menu()
    {
        if (!isset($this->session->userdata['email'])) {

            redirect('/');
        } else {
            if ($this->session->userdata['role_id'] > 1) {
                redirect('home');
            }
            // delete
            $uri = $this->uri->segment(3);

            if ($uri == "del") {

                $uniq = $this->uri->segment(4);

                $data = [
                    'uniq_key' => $uniq
                ];

                $this->_delSubmenu($data);
            }
            // end delete
            $this->form_validation->set_rules('menu_id', 'Menu_Id', 'required');
            $this->form_validation->set_rules('title', 'Title', 'required');
            $this->form_validation->set_rules('icon', 'Icon', 'required');
            if ($this->form_validation->run() == false) {

                $profile = $this->user_m->getInfo($this->session->userdata('email'));
                $settings = $this->web_settings->get_web_settings();

                $user_menu_name = $this->menu->getUsermenu();

                $join_data = [
                    'sel' => '*',
                    'frm' => 'sub_menu',
                    'tbl_frm' => 'menu_id',
                    'join' => 'user_menu',
                    'tbl_join' => 'id',
                    'type' => 'left',
                    'order' => 'menu_id',
                    'order_con' => 'ASC'
                ];
                $join = $this->menu->join2Table($join_data);
                $settings = $settings[0];

                $data = [
                    'title' => 'Sub Menu Management',
                    'profile' => $profile,
                    'settings' => $settings,
                    'data_user_menu' => $join,
                    'user_menu' => $user_menu_name,
                    'link' => $this->bmw_functions->breadcrumb()
                ];
                $this->load->view("templates/home-h", $data);
                $this->load->view("templates/home-t-s", $data);
                $this->load->view("templates/home-nav", $data);
                $this->load->view("menu/sub_menu");
                $this->load->view("templates/home-f");
            } else {
                $uri = $this->uri->segment(3);
                if ($uri == "add") {

                    $menu_id = $this->input->post('menu_id');
                    $title = $this->input->post('title');
                    $url = $this->input->post('url');
                    $icon = $this->input->post('icon');
                    $uniq = $this->bmw_functions->generate_string($this->permitted_chars, 15);

                    if (!isset($_POST['badges'])) {
                        $badges = 0;
                    } else {
                        $badges = 1;
                    }
                    if (!isset($_POST['tree'])) {
                        $tree = 0;
                        $id_tree = 0;
                    } else {
                        $tree = 1;
                        $id_tree = $this->bmw_functions->generate_string($this->permitted_chars, 5);
                    }
                    if (!isset($_POST['active'])) {
                        $active = 0;
                    } else {
                        $active = 1;
                    }
                    $data = [
                        'id' => '',
                        'menu_id' => $menu_id,
                        'id_tree' => $id_tree,
                        'uniq_key' => $uniq,
                        'title' => $title,
                        'url' => $url,
                        'icon' => $icon,
                        'is_badges' => $badges,
                        'is_tree' => $tree,
                        'is_active' => $active
                    ];

                    $this->__subMenuAdd($data);
                } else if ($uri == "edit") {
                    $menu_id = $this->input->post('menu_id');
                    $title = $this->input->post('title');
                    $url = $this->input->post('url');
                    $icon = $this->input->post('icon');
                    $uniq = $this->input->post('uniq_key');
                    if (!isset($_POST['badges'])) {
                        $badges = 0;
                    } else {
                        $badges = 1;
                    }
                    if (!isset($_POST['tree'])) {
                        $tree = 0;
                    } else {
                        $tree = 1;
                    }
                    if (!isset($_POST['active'])) {
                        $active = 0;
                    } else {
                        $active = 1;
                    }
                    $data = [

                        'menu_id' => $menu_id,

                        'uniq_key' => $uniq,
                        'title' => $title,
                        'url' => $url,
                        'icon' => $icon,
                        'is_badges' => $badges,
                        'is_tree' => $tree,
                        'is_active' => $active
                    ];

                    $this->_editSubMenu($data);
                }
            }
        }
    }

    public function tree()
    {
        if (!isset($this->session->userdata['email'])) {

            redirect('/');
        } else {

            if ($this->session->userdata['role_id'] > 1) {
                redirect('home');
            }
            $this->form_validation->set_rules('menu_id', 'Menu_Id', 'required');
            $this->form_validation->set_rules('title', 'Title', 'required');
            $this->form_validation->set_rules('url', 'Url', 'required');
            $this->form_validation->set_rules('icon', 'Icon', 'required');
            if ($this->form_validation->run() == false) {
                $uri = $this->uri->segment(3);
                if ($uri == "del") {

                    $uniq = $this->uri->segment(4);

                    $data = [
                        'uniq_key' => $uniq
                    ];

                    $this->_delTree($data);
                }
                $profile = $this->user_m->getInfo($this->session->userdata('email'));
                $settings = $this->web_settings->get_web_settings();

                $user_menu_name = $this->menu->getWhere('sub_menu', [
                    'is_tree' => 1
                ]);

                $join_data = [
                    'sel' => '*',
                    'frm' => 'sub_menu_tree',
                    'tbl_frm' => 'menu_id',
                    'join' => 'user_menu',
                    'tbl_join' => 'id',
                    'type' => 'left',
                    'order' => 'menu_id',
                    'order_con' => 'ASC'
                ];
                $join = $this->menu->join2Table($join_data);
                $settings = $settings[0];

                $data = [
                    'title' => 'Sub Menu Tree Management',
                    'profile' => $profile,
                    'settings' => $settings,
                    'data_user_menu' => $join,
                    'link' => $this->bmw_functions->breadcrumb(),
                    'user_menu' => $user_menu_name
                ];
                $this->load->view("templates/home-h", $data);
                $this->load->view("templates/home-t-s", $data);
                $this->load->view("templates/home-nav", $data);
                $this->load->view("menu/sub_menu_tree");
                $this->load->view("templates/home-f");
            } else {
                $uri = $this->uri->segment(3);
                if ($uri == "add") {
                    $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                    $opt = $this->input->post('menu_id');
                    $opt = explode(',', $opt);
                    $menu_id = $opt[0];
                    $id_tree = $opt[1];

                    $title = $this->input->post('title');
                    $url = $this->input->post('url');
                    $icon = $this->input->post('icon');
                    $uniq = $this->bmw_functions->generate_string($permitted_chars, 15);
                    if (!isset($_POST['badges'])) {
                        $badges = 0;
                    } else {
                        $badges = 1;
                    }


                    if (!isset($_POST['active'])) {
                        $active = 0;
                    } else {
                        $active = 1;
                    }
                    $data = [
                        'id' => '',
                        'menu_id' => $menu_id,
                        'id_tree' => $id_tree,
                        'uniq_key' => $uniq,
                        'title' => $title,
                        'url' => $url,
                        'icon' => $icon,
                        'is_badges' => $badges,
                        'is_active' => $active
                    ];

                    $this->__treeAdd($data);
                } else if ($uri == "edit") {
                    $menu_id = $this->input->post('menu_id');
                    $title = $this->input->post('title');
                    $url = $this->input->post('url');
                    $icon = $this->input->post('icon');
                    $uniq = $this->input->post('uniq_key');
                    if (!isset($_POST['badges'])) {
                        $badges = 0;
                    } else {
                        $badges = 1;
                    }

                    if (!isset($_POST['active'])) {
                        $active = 0;
                    } else {
                        $active = 1;
                    }
                    $data = [

                        'menu_id' => $menu_id,
                        'uniq_key' => $uniq,
                        'title' => $title,
                        'url' => $url,
                        'icon' => $icon,
                        'is_badges' => $badges,
                        'is_active' => $active
                    ];

                    $this->_editTree($data);
                }
            }
        }
    }

    // End Child



    //  Add Data

    private function _userAdd($data)
    {
        if ($this->menu->addUsermenu($data) > 0) {

            $this->session->set_flashdata('message', '<script>  Swal.fire({
                position: `top-end`,
                icon: `success`,
                title: `User Menu has been added`,
                showConfirmButton: false,
                timer: 2000
              })</script>');
            redirect('menu_management/user');
        }
    }

    private function _accessAdd($data)
    {

        if ($this->menu->addUserAccess($data) > 0) {
            $this->session->set_flashdata('message', '<script>  Swal.fire({
                position: `top-end`,
                icon: `success`,
                title: `User Access has been added`,
                showConfirmButton: false,
                timer: 2000
              })</script>');
            redirect('menu_management/user_access');
        }
    }
    private function __subMenuAdd($data)
    {
        if ($this->menu->addSubMenu($data) > 0) {
            $this->session->set_flashdata('message', '<script>  Swal.fire({
                position: `top-end`,
                icon: `success`,
                title: `Sub Menu has been added`,
                showConfirmButton: false,
                timer: 2000
              })</script>');
            redirect('menu_management/sub_menu');
        }
    }
    private function __treeAdd($data)
    {
        if ($this->menu->addTree($data) > 0) {
            $this->session->set_flashdata('message', '<script>  Swal.fire({
                position: `top-end`,
                icon: `success`,
                title: `Sub Menu Tree has been added`,
                showConfirmButton: false,
                timer: 2000
              })</script>');
            redirect('menu_management/tree');
        }
    }
    // End Add Data

    // Edit Data
    private function _userEdit($data)
    {
        if ($this->menu->editUsermenu($data) > 0) {

            $this->session->set_flashdata('message', '<script>  Swal.fire({
                position: `top-end`,
                icon: `success`,
                title: `User Menu has been Updated`,
                showConfirmButton: false,
                timer: 2000
              })</script>');
            redirect('menu_management/user');
        }
    }
    private function _editSubMenu($data)
    {
        if ($this->menu->editSubMenu($data) > 0) {

            $this->session->set_flashdata('message', '<script>  Swal.fire({
                position: `top-end`,
                icon: `success`,
                title: `Sub Menu has been Updated`,
                showConfirmButton: false,
                timer: 2000
              })</script>');
            redirect('menu_management/sub_menu');
        }
    }
    private function _editTree($data)
    {
        if ($this->menu->editTree($data) > 0) {

            $this->session->set_flashdata('message', '<script>  Swal.fire({
                position: `top-end`,
                icon: `success`,
                title: `Sub Menu Tree has been Updated`,
                showConfirmButton: false,
                timer: 2000
              })</script>');
            redirect('menu_management/tree');
        }
    }
    // End Edit Dat


    // Delete Data
    private function _delUserAccess($data)
    {
        if ($this->menu->delAccessMenu($data) > 0) {
            $this->session->set_flashdata('message', '<script>  Swal.fire({
                position: `top-end`,
                icon: `success`,
                title: `User Access has been deleted`,
                showConfirmButton: false,
                timer: 2000
              })</script>');
            redirect('menu_management/user_access');
        }
    }
    private function _delUserMenu($data)
    {
        if ($this->menu->delUserMenu($data) > 0) {
            $this->session->set_flashdata('message', '<script>  Swal.fire({
                position: `top-end`,
                icon: `success`,
                title: `User Menu has been deleted`,
                showConfirmButton: false,
                timer: 2000
              })</script>');
            redirect('menu_management/user');
        }
    }

    private function _delSubmenu($data)
    {
        if ($this->menu->delSubMenu($data) > 0) {
            $this->session->set_flashdata('message', '<script>  Swal.fire({
                position: `top-end`,
                icon: `success`,
                title: `Sub Menu has been deleted`,
                showConfirmButton: false,
                timer: 2000
              })</script>');
            redirect('menu_management/sub_menu');
        }
    }
    private function _delTree($data)
    {
        if ($this->menu->delTree($data) > 0) {
            $this->session->set_flashdata('message', '<script>  Swal.fire({
                position: `top-end`,
                icon: `success`,
                title: `Sub Menu Tree has been deleted`,
                showConfirmButton: false,
                timer: 2000
              })</script>');
            redirect('menu_management/tree');
        }
    }
    // End Delete Data
}
