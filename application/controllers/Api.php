<?php
defined('BASEPATH') or exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Api extends RestController
{

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->load->model('View_Model', 'vw');
    }

    public function users_get()
    {
        // Users from a data store e.g. database
        $link = $this->get('link');
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
        $users = $this->vw->join3Table($join_data);
        if ($users) {
            $this->response($users, 200);
        } else {
            $this->response($data = [
                'status' => false,
                'message' => 'No users were found'
            ], 404);
        }
    }
}
