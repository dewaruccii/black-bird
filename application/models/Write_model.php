<?php

class Write_model extends CI_Model
{
    // POST DETAIL
    public function getInfoPost($data)
    {
        return $this->db->get_where('post_detail', [
            'author' => $data
        ])->result_array();
    }
    public function getInfoPostById($data)
    {
        return $this->db->get_where('post_detail', [
            'id_post' => $data
        ])->row_array();
    }
    public function addDetail($data)
    {
        $this->db->insert('post_detail', $data);
        return $this->db->affected_rows();
    }
    public function cekNumsDetail($data)
    {
        return $this->db->get_where('post_detail', [
            'id_post' => $data
        ])->num_rows();
    }


    // POST SECURITY

    public function addSecurity($data)
    {
        $this->db->insert('security_post', $data);
        return $this->db->affected_rows();
    }
    public function cekNumsSecurityPost($data)
    {
        return $this->db->get_where('security_post', [
            'id_post' => $data
        ])->num_rows();
    }




    // POST

    public function cekPost($data)
    {
        return $this->db->get_where('post', [
            'id_post' => $data
        ])->row_array();
    }
    public function addPost($data)
    {
        $this->db->insert('post', $data);
        return $this->db->affected_rows();
    }
    public function cekNumsPost($data)
    {
        return $this->db->get_where('post', [
            'id_post' => $data
        ])->num_rows();
    }

    public function editPost($data)
    {
        $this->db->update('post', [
            'content' => $data['content']
        ], [
            'id_post' => $data['id_post']
        ]);
        return $this->db->affected_rows();
    }


    //  Delete

    public function deletePost($data)
    {
        $this->db->delete('post', [
            'id_post' => $data
        ]);
        return $this->db->affected_rows();
    }
    public function deleteSecurityPost($data)
    {
        $this->db->delete('security_post', [
            'id_post' => $data
        ]);
        return $this->db->affected_rows();
    }
    public function deleteDetailPost($data)
    {
        $this->db->delete('post_detail', [
            'id_post' => $data
        ]);
        return $this->db->affected_rows();
    }


    // GLOBAL EDIT
    public function Edit($data)
    {
        $this->db->update($data['table_edit'], [
            $data['clm_set'] => $data['set']
        ], [
            $data['clm_where'] => $data['where']
        ]);
        return $this->db->affected_rows();
    }



    // jOIN 2 TABLE
    public function join2Table($data)
    {
        $this->db->select($data['sel']);
        $this->db->from($data['frm']);
        $this->db->join($data['join'], $data['frm'] . '.' . $data['tbl_frm'] . '=' . $data['join'] . '.' . $data['tbl_join'], $data['type']);
        $this->db->order_by($data['order'] . ' ' . $data['order_con']);
        $this->db->where($data['where_tbl'] . '.' . $data['where_clm'], $data['where']);
        return $this->db->get()->result_array();
    }
}
