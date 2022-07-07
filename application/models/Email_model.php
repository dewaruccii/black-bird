<?php 

class Email_model extends CI_Model{

    public function sendEmail($data){
       return $this->db->insert('email_send',$data);
    }
    public function cek_token($data){
        return $this->db->get_where('email_send',[
            'uniq' => $data['token'],
            'email' =>$data['email'],
            
        ])->num_rows();
    }
    public function get_info_token($data){
        return $this->db->get_where('email_send',[
            'uniq' => $data['token'],
            'email' =>$data['email'],
        ])->result_array();
    }
    public function edit_token($data){
        return $this->db->update('email_send',[
            'is_active' => 0
        ],[
            'uniq' => $data['token']
        ]);
    }

}