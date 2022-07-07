<?php

class User_model extends CI_Model
{
    public function getInfo($email)
    {
        return $this->db->get_where('user_profile', [
            'email' => $email
        ])->row_array();
    }
    public function addProfile($data)
    {
        $this->db->insert('user_profile', $data);
    }
    public function editProfile($data)
    {

        $this->db->update('user_profile', $data, ['email' => $this->session->userdata('email')]);
    }
    public function cekNums($data)
    {
        return $this->db->get_where('post_detail', [
            'author' => $data['author'],
            'type' => $data['type']
        ])->num_rows();
    }
}
