<?php
defined('BASEPATH') or exit('No direct script access allowed');

class V extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library('pdf');
        $this->load->model('Web_model', 'web_settings');
        $this->load->model('View_model', 'vw');
        $this->load->model('Write_model', 'wrt');
    }
    public function index()
    {
        $link = $this->input->get('r', false);

        if ($link == null) {
            // notfound
            echo "not found";
            die;
        }
        $join_data = [
            'sel' => '*',
            'frm' => 'post_detail',
            'tbl_frm' => 'id_post',
            'join' => 'post',
            'tbl_join' => 'id_post',
            'type' => 'left',
            'order' => 'author',
            'order_con' => 'ASC',
            'where' => $link,
            'where_tbl' => 'post_detail',
            'where_clm' => 'link',
            'join3' => 'security_post',
            'tbl_join3' => 'id_post'
        ];
        $join = $this->vw->join3Table($join_data);
        if (!$join) {
            redirect('myerror');
        } else {

            $join = $join[0];
            // type draft
            if ($join['type'] == 1) {
                // not found 
                // draft

                redirect('myerror');
            } else if ($join['type'] == 2) {
                // private redirect
                redirect('myerror');
            } else {

                // if password added
                if ($join['password'] == 1) {
                    if ($this->session->has_userdata('key')) {
                        if (password_verify($this->session->userdata('key'), $join['password_post'])) {
                            // pass if true
                        } else {
                            // redirect to password open

                            redirect('v/password/' . $join['link']);
                        }
                    } else {
                        // redirect to password open
                        redirect('v/password/' . $join['link']);
                    }
                }
                // end

                $info_view = $join;



                $data = [
                    'title' => 'View',
                    'detail' => $info_view,
                ];
                if (isset($_GET['download'])) {
                    if ($this->input->get('download') == "yes") {
                        // $this->pdf->setPaper('A2', 'potrait');
                        // $this->pdf->filename = $info_view['title'] . '.pdf';
                        // $this->pdf->load_view('/view/save', $data);
                        redirect('v/book/' . $info_view['link']);
                    }
                }

                $this->load->view("templates/view-h", $data);
                $this->load->view("view/index");
                $this->load->view("templates/view-f");
                $watch = $info_view['watch'];
                $watch = $watch + 1;

                $view = [
                    'clm_set' => 'watch',
                    'set' => $watch,
                    'clm_where' => 'link',
                    'where' => $info_view['link']
                ];
                $this->vw->UpdateView($view);
            }
        }
    }
    public function book()
    {
        $uri = $this->uri->segment(3);
        $uri = $uri;
        if ($uri == "") {
            // not found
            echo "Not Found";
            die;
        }
        $join_data = [
            'sel' => '*',
            'frm' => 'post_detail',
            'tbl_frm' => 'id_post',
            'join' => 'post',
            'tbl_join' => 'id_post',
            'type' => 'left',
            'order' => 'author',
            'order_con' => 'ASC',
            'where' => $uri,
            'where_tbl' => 'post_detail',
            'where_clm' => 'link',
            'join3' => 'security_post',
            'tbl_join3' => 'id_post'
        ];
        $join = $this->vw->join3Table($join_data);

        if (!$join) {
            // not found
            echo "Not Found";
            die;
        }
        $join = $join[0];
        if ($join['password'] == 1) {
            if ($this->session->has_userdata('key')) {
                if (password_verify($this->session->userdata('key'), $join['password_post'])) {
                    // pass if true
                } else {
                    // redirect to password open

                    redirect('v/password/' . $join['link']);
                }
            } else {
                // redirect to password open
                redirect('v/password/' . $join['link']);
            }
        }
        $data = [
            'title' => $join['title'],
            'detail' => $join
        ];
        $this->load->view('view/save', $data);
    }

    public function password()
    {
        $link = $this->uri->segment(3);
        if ($link == null) {
            // notfound
            redirect('');
        }
        $join_data = [
            'sel' => '*',
            'frm' => 'post_detail',
            'tbl_frm' => 'id_post',
            'join' => 'security_post',
            'tbl_join' => 'id_post',
            'type' => 'left',
            'order' => 'author',
            'order_con' => 'ASC',
            'where' => $link,
            'where_tbl' => 'post_detail',
            'where_clm' => 'link'
        ];
        $join = $this->vw->join2Table($join_data);
        if (!$join) {
            // if not found
            redirect('');
        }
        $join = $join[0];
        if (password_verify($this->session->userdata('key'), $join['password_post'])) {
            redirect('/v?r=' . $join['link']);
        }
        $this->form_validation->set_rules('password', 'Password', 'required');
        if ($this->form_validation->run() == false) {
            $settings = $this->web_settings->get_web_settings();
            $settings = $settings[0];
            $data = [
                'title' => 'Password for ' . $join['title'],
                'data' => $join,
                'name_bold' => $settings['name_bold'],
                'name_light' => $settings['name_light']
            ];
            $this->load->view('templates/new-login-h', $data);
            $this->load->view('view/password');
            $this->load->view('templates/new-login-f');
        } else {
            $password = $this->input->post('password');
            if (password_verify($password, $join['password_post'])) {
                $key = [
                    'key' => $password
                ];
                $this->session->set_userdata($key);
                redirect('/v?r=' . $join['link']);
            } else {
                $this->session->set_flashdata('message', '<script>
                Swal.fire({
                    icon: "error",
                    title: "Failure authentication",
                    text: "Password Wrong!",
                    
                  })
                    </script>');
                // var_dump($this->session->flashdata('message'));
                redirect('v/password/' . $join['link']);
                // redirect('/');
            }
        }
    }
}
