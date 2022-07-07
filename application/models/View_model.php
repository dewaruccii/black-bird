<?php

class View_model extends CI_Model
{
    // View

    // Update
    public function UpdateView($data)
    {
        $this->db->update('post_detail', [
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
    // join 3 table
    public function join3table($data)
    {
        $this->db->select($data['sel']);
        $this->db->from($data['frm']);
        $this->db->join($data['join'], $data['frm'] . '.' . $data['tbl_frm'] . '=' . $data['join'] . '.' . $data['tbl_join'], $data['type']);
        $this->db->join($data['join3'], $data['frm'] . '.' . $data['tbl_frm'] . '=' . $data['join3'] . '.' . $data['tbl_join3'], $data['type']);
        $this->db->order_by($data['order'] . ' ' . $data['order_con']);
        $this->db->where($data['where_tbl'] . '.' . $data['where_clm'], $data['where']);
        return $this->db->get()->result_array();
    }
}
