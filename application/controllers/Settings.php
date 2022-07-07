<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Settings extends CI_Controller
{

    public function __construct()
    {

        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library('bmw_functions');
        $this->load->model('Akun_model', 'akun');
        $this->load->model('Web_model', 'web_settings');
        $this->load->model('User_model', 'user_m');
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
            $link = [
                'segment1' => $this->uri->segment(1),
                'segment2' => $this->uri->segment(2)
            ];
            $data = [
                'title' => 'Settings',
                'profile' => $profile,
                'settings' => $settings,
                'link' => $link
            ];

            $this->load->view("templates/home-h", $data);
            $this->load->view("templates/home-t-s", $data);
            $this->load->view("templates/home-nav", $data);
            $this->load->view("home/settings/index");
            $this->load->view("templates/home-f");
        }
    }
    public function profile()
    {
        if (!isset($this->session->userdata['email'])) {
            $data = [
                'email' => $this->session->userdata('email'),
                'role_id' => $this->session->userdata('role_id')
            ];
            redirect('/');
        } else {
            $this->form_validation->set_rules('nama', 'Name', 'required');


            if ($this->form_validation->run() == false) {

                $profle = $this->user_m->getInfo($this->session->userdata('email'));
                $settings = $this->web_settings->get_web_settings();

                $settings = $settings[0];
                // $link = [
                //     'segment1' => $this->uri->segment(1),
                //     'segment2' => $this->uri->segment(2)
                // ];
                // $dat = [
                //     ''
                // ];
                $data = [
                    'title' => 'Settings',
                    'link' => $this->bmw_functions->breadcrumb(),
                    'profile' => $profle,
                    'settings' => $settings,
                    'type_detail' => [
                        'post' => $this->user_m->cekNums([
                            'type' => '3',
                            'author' => $this->session->userdata('email')
                        ]),
                        'draft' => $this->user_m->cekNums([
                            'type' => '1',
                            'author' => $this->session->userdata('email')
                        ]),
                        'private' => $this->user_m->cekNums([
                            'type' => '2',
                            'author' => $this->session->userdata('email')
                        ])
                    ]
                ];
                $this->load->view("templates/home-h", $data);
                $this->load->view("templates/home-t-s", $data);
                $this->load->view("templates/home-nav", $data);
                $this->load->view("home/settings/profile");
                $this->load->view("templates/home-f");
            } else {
                $nama = $this->input->post('nama');
                $phone = $this->input->post('phone');
                $notes = $this->input->post('notes');
                if ($phone == "" || $phone == "-") {
                    $phone = '';
                } else {
                    $phone = $phone;
                }
                if ($notes == "" || $notes == "-") {
                    $notes = '';
                } else {
                    $notes = $notes;
                }
                // if ($nama == $nama || $phone == $phone || $notes == $notes) {
                //     $this->session->set_flashdata('message', '<script>  Swal.fire({
                //         position: `top-end`,
                //         icon: `error`,
                //         title: `Profile not updated`,
                //         showConfirmButton: false,
                //         timer: 2000
                //       })</script>');
                //     redirect('settings/profile');
                // }
                $data = [
                    'nama' => $nama,
                    'phone' => $phone,
                    'notes' => $notes
                ];
                $this->user_m->editProfile($data);
                $this->session->set_flashdata('message', '<script>  Swal.fire({
                    position: `top-end`,
                    icon: `success`,
                    title: `Profile has been updated`,
                    showConfirmButton: false,
                    timer: 1500
                  })</script>');
                redirect('settings/profile');
            }
        }
    }
    public function password()
    {
        $profle = $this->user_m->getInfo($this->session->userdata('email'));
        $settings = $this->web_settings->get_web_settings();

        $settings = $settings[0];
        $data = [
            'title' => 'Password',
            'link' => $this->bmw_functions->breadcrumb(),
            'profile' => $profle,
            'settings' => $settings,
        ];
        if ($this->uri->segment(3) == "c") {
            $this->form_validation->set_rules('old', 'Old', 'required|min_length[6]', [
                'required' => 'Old Password cannot be empty'
            ]);
            $this->form_validation->set_rules('new', 'New', 'required|min_length[6]', [
                'required' => 'New Password cannot be empty'
            ]);
            $this->form_validation->set_rules('retype', 'Retype', 'required|min_length[6]|matches[new]', [
                'required' => 'Re-type Password cannot be empty'
            ]);
        }
        if ($this->form_validation->run() == false) {
            $this->load->view("templates/home-h", $data);
            $this->load->view("templates/home-t-s", $data);
            $this->load->view("templates/home-nav", $data);
            $this->load->view("home/settings/password");
            $this->load->view("templates/home-f");
        } else {
            if ($this->uri->segment(3) == "c") {
                $info_akun = $this->akun->getInfoAkun($profle['email']);
                $info_akun = $info_akun[0];
                if (password_verify($this->input->post('old'), $info_akun['password'])) {
                    // go
                    $hash = password_hash($this->input->post('new'), PASSWORD_DEFAULT);
                    $detail = [
                        'password' => $hash,
                        'email' => $info_akun['email']
                    ];
                    if ($this->akun->editPassword($detail) > 0) {
                        $this->session->set_flashdata('message', '<script>  Swal.fire({
                            position: `top-end`,
                            icon: `success`,
                            title: `Password has been change`,
                            showConfirmButton: false,
                            timer: 1500
                          })</script>');
                        redirect('settings/password');
                    }
                } else {
                    $this->session->set_flashdata('message', '<script>  Swal.fire({
                        position: `top-end`,
                        icon: `error`,
                        title: `Wrong old Password!`,
                        showConfirmButton: false,
                        timer: 1500
                      })</script>');
                    redirect('settings/password');
                }
            }
        }
    }
}
