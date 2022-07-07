<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Write extends CI_Controller
{
    public $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    public function __construct()
    {
        // $pass = password_hash("", PASSWORD_DEFAULT);
        // if (password_verify("", $pass)) {
        //     // pass
        // } else {
        //     echo $pass;
        // }
        // die;
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library('bmw_functions');
        $this->load->model('Akun_model', 'akun');
        $this->load->model('Web_model', 'web_settings');
        $this->load->model('User_model', 'user_m');

        $this->load->model('Write_model', 'wrt');
    }
    public function index()
    {
        if (!isset($this->session->userdata['email'])) {

            redirect('/');
        } else {
            $this->form_validation->set_rules('title', 'Title', 'required');
            if ($this->form_validation->run() == false) {

                $email = $this->session->userdata('email');
                $profile = $this->user_m->getInfo($email);
                $settings = $this->web_settings->get_web_settings();

                $settings = $settings[0];
                // $this->bmw_functions->cekAccessMenu();
                // die;


                // $assets = [
                //     'link' =>  ['plugins/summernote/summernote-bs4.min.css', 'plugins/summernote/summernote-bs5.min.css'],
                //     'script' => [
                //         'link' => ['plugins/summernote/summernote-bs4.min.js'],
                //         'func' => [' $("#summernote").summernote()']
                // //     ]
                // ];

                $data = [
                    'title' => 'Write',
                    'profile' => $profile,
                    'settings' => $settings,
                    'link' => $this->bmw_functions->breadcrumb(),
                    'post_detail' =>  $this->wrt->getInfoPost($email)
                ];
                $this->load->view("templates/home-h", $data);
                $this->load->view("templates/home-t-s", $data);
                $this->load->view("templates/home-nav", $data);
                $this->load->view("write/index");
                $this->load->view("templates/home-f");
            } else {

                $id_post = $this->bmw_functions->generate_string($this->permitted_chars, 7);
                $author = $this->session->userdata('email');
                $title = $this->input->post('title');
                $type = 1;
                $watch = 0;
                $link = $this->bmw_functions->generate_string($this->permitted_chars, 10);
                $password = $this->input->post('password');

                $data_security = [
                    'id_post' => $id_post,
                    'password_post' => $password
                ];

                if ($password == "") {
                    $password = 0;
                } else {
                    $password = 1;
                }
                $post_at = time();
                $data_detail = [
                    'id_post' => $id_post,
                    'author' => $author,
                    'title' => $title,
                    'type' => $type,
                    'watch' => $watch,
                    'link' => $link,
                    'password' => $password,
                    'post_at' => $post_at
                ];
                $this->_addPost($data_detail, $data_security);
            }
        }
    }

    private function _addPost($data_detail, $data_security)
    {
        if ($this->wrt->addDetail($data_detail) > 0) {
            $pass = password_hash("", PASSWORD_DEFAULT);
            if (password_verify($data_security['password_post'], $pass)) {
                // pass
            } else {
                $data_security['password_post'] = password_hash($data_security['password_post'], PASSWORD_DEFAULT);
                $this->wrt->addSecurity($data_security);
            }
            $this->session->set_flashdata('message', '<script>  Swal.fire({
                position: `top-end`,
                icon: `success`,
                title: `Post has been Created`,
                showConfirmButton: false,
                timer: 2000
              })</script>');
            redirect('write/e/' . $data_detail['link']);
        }
    }


    // Write Post

    public function e()
    {
        $this->form_validation->set_rules('summernote', 'Summernote', 'required');
        $id_post = $this->uri->segment(3);
        if ($this->form_validation->run() == false) {

            $email = $this->session->userdata('email');
            $profile = $this->user_m->getInfo($email);
            $settings = $this->web_settings->get_web_settings();

            $settings = $settings[0];
            $assets = [
                'link' =>  ['plugins/summernote/summernote-bs4.min.css'],
                'script' => [
                    'link' => ['plugins/summernote/summernote-bs4.min.js', 'dist/js/script.js'],
                    'func' => [' $("#summernote").summernote({height: 390,focus: true})']
                ]
            ];


            if (!$this->wrt->getInfoPostById($id_post)) {
                redirect('write');
            }
            if ($this->wrt->cekPost($id_post)) {

                $join_data = [
                    'sel' => '*',
                    'frm' => 'post_detail',
                    'tbl_frm' => 'id_post',
                    'join' => 'post',
                    'tbl_join' => 'id_post',
                    'type' => 'left',
                    'order' => 'author',
                    'order_con' => 'ASC',
                    'where_tbl' => 'post_detail',
                    'where_clm' => 'id_post',
                    'where' => $id_post
                ];
                $join = $this->wrt->join2Table($join_data);
                $join = $join[0];
                $edit_data = $join;
            } else {
                $edit_data = $this->wrt->getInfoPostById($id_post);
            }
            $data = [
                'title' => 'Write',
                'profile' => $profile,
                'settings' => $settings,
                'link' => $this->bmw_functions->breadcrumb(),
                'assets' => $assets,
                'detail' => $edit_data,
                'post_detail' =>  $this->wrt->getInfoPost($email)
            ];
            $this->load->view("templates/home-h", $data);
            $this->load->view("templates/home-t-s", $data);
            $this->load->view("templates/home-nav", $data);
            $this->load->view("write/post/index");
            $this->load->view("templates/home-f");
        } else {
            $data = [
                'id_post' => $id_post,
                'content' => $this->input->post('summernote')
            ];
            $type = $this->uri->segment(4);
            $privacy = [
                'table_edit' => 'post_detail',
                'clm_set' => 'type',
                'set' => $type,
                'clm_where' => 'id_post',
                'where' => $id_post
            ];
            if ($this->wrt->cekPost($id_post)) {
                if ($this->wrt->editPost($data) > 0) {
                    $this->wrt->Edit($privacy);
                    $this->session->set_flashdata('message', '<script>  Swal.fire({
                        position: `top-end`,
                        icon: `success`,
                        title: `Succes Edit`,
                        showConfirmButton: false,
                        timer: 2000
                      })</script>');
                    redirect('write/');
                }
            } else {
                if ($this->wrt->addPost($data) > 0) {
                    $this->wrt->Edit($privacy);
                    $this->session->set_flashdata('message', '<script>  Swal.fire({
                    position: `top-end`,
                    icon: `success`,
                    title: `Succes Post`,
                    showConfirmButton: false,
                    timer: 2000
                  })</script>');
                    redirect('write/');
                };
            }
        }
    }

    // Delete 

    public function d()
    {
        $id_post = $this->uri->segment(3);

        if ($this->wrt->cekNumsDetail($id_post) > 0) {
            $this->wrt->deleteDetailPost($id_post);
            if ($this->wrt->cekNumsPost($id_post) > 0) {
                $this->wrt->deletePost($id_post);
            }
            if ($this->wrt->cekNumsSecurityPost($id_post)) {
                $this->wrt->deleteSecurityPost($id_post);
            }
            $this->session->set_flashdata('message', '<script>  Swal.fire({
                position: `top-end`,
                icon: `success`,
                title: `Post has been deleted!`,
                showConfirmButton: false,
                timer: 2000
              })</script>');
            redirect('write/');
        } else {
            $this->session->set_flashdata('message', '<script>  Swal.fire({
                position: `top-end`,
                icon: `error`,
                title: `Post Not Found,Please Check again!`,
                showConfirmButton: false,
                timer: 2000
              })</script>');
            redirect('write/');
        }
    }
    // end write post
}
