<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Myerror extends CI_Controller
{

    public function index()
    {
        $data  = [
            'detail' => [
                'title' => "404"
            ]
        ];

        $this->load->view("error/404", $data);
    }
}
