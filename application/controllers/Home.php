<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Akun_model', 'akun');
        $this->load->model('Web_model', 'web_settings');
        $this->load->model('User_model', 'user_m');
        $this->load->library('bmw_functions');
        // $this->load->model('Home_model');
    }

    public function index()
    {

        if (!isset($this->session->userdata['email'])) {
            $data = [
                'email' => $this->session->userdata('email'),
                'role_id' => $this->session->userdata('role_id')
            ];
            redirect('/');
        } else {
            $profile = $this->user_m->getInfo($this->session->userdata('email'));
            $settings = $this->web_settings->get_web_settings();

            $settings = $settings[0];

            $data = [
                'email' => $this->session->userdata('email'),
                'role_id' => $this->session->userdata('role_id'),
                'title' => 'Dashboard',
                'profile' => $profile,
                'settings' => $settings,
                'link' => $this->bmw_functions->breadcrumb()
            ];

            $this->load->view("templates/home-h", $data);
            $this->load->view("templates/home-t-s", $data);
            $this->load->view("templates/home-nav", $data);
            $this->load->view("home/index");
            $this->load->view("templates/home-f");
        }
    }
}
