<?php 

class Web_model extends CI_Model{

    public function get_web_settings(){
        return $this->db->get('web_settings')->result_array();
    }


}