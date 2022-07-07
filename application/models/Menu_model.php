<?php

class Menu_model extends CI_Model
{
    // User Menu
    public function getUsermenu()
    {
        return $this->db->get('user_menu')->result_array();
    }
    public function addUsermenu($data)
    {
        $this->db->insert('user_menu', $data);
        return $this->db->affected_rows();
    }
    public function editUsermenu($data)
    {
        $this->db->update('user_menu', $data, [
            'id' => $data['id']
        ]);
        return $this->db->affected_rows();
    }
    public function getWhereUsermenu($id)
    {
        return $this->db->get_where('user_menu', [
            'id' => $id
        ])->row_array();
    }
    public function delUserMenu($data)
    {
        $this->db->delete('user_menu', [
            'id' => $data['id']
        ]);

        return $this->db->affected_rows();
    }


    // Access User Menu

    public function getAccessuser()
    {
        $this->db->select('*');
        $this->db->from('user_menu');
        $this->db->join('user_access_menu', 'user_menu.id = user_access_menu.menu_id', 'left');
        $this->db->order_by('role_id ASC');

        return $this->db->get()->result_array();
    }
    public function addUserAccess($data)
    {
        $this->db->insert('user_access_menu', $data);
        return $this->db->affected_rows();
    }
    public function getWhereAccess($menu_id, $role)
    {
        return $this->db->get_where('user_access_menu', [
            'menu_id' => $menu_id,
            'role_id' => $role
        ])->num_rows();
    }
    public function delAccessMenu($data)
    {
        $this->db->delete('user_access_menu', [
            'role_id' => $data['role'],
            'menu_id' => $data['menu']
        ]);

        return $this->db->affected_rows();
    }

    // Sub Menu

    public function getSubMenu()
    {
        return $this->db->get('sub_menu')->result_array();
    }
    public function addSubMenu($data)
    {
        $this->db->insert('sub_menu', $data);
        return $this->db->affected_rows();
    }
    public function delSubMenu($data)
    {
        $this->db->delete('sub_menu', [
            'uniq_key' => $data['uniq_key']
        ]);
        return $this->db->affected_rows();
    }
    public function editSubMenu($data)
    {
        $this->db->update('sub_menu', $data, [
            'uniq_key' => $data['uniq_key']
        ]);
        return $this->db->affected_rows();
    }


    // End Sub Menu

    // Tree
    public function addTree($data)
    {
        $this->db->insert('sub_menu_tree', $data);
        return $this->db->affected_rows();
    }
    public function delTree($data)
    {
        $this->db->delete('sub_menu_tree', [
            'uniq_key' => $data['uniq_key']
        ]);
        return $this->db->affected_rows();
    }
    public function editTree($data)
    {
        $this->db->update('sub_menu_tree', $data, [
            'uniq_key' => $data['uniq_key']
        ]);
        return $this->db->affected_rows();
    }
    // End Tree





    // query where if needed
    public function getWhere($tbl, $where)
    {
        return $this->db->get_where($tbl, $where)->result_array();
    }
    // join if needed
    public function join2Table($data)
    {
        $this->db->select($data['sel']);
        $this->db->from($data['frm']);
        $this->db->join($data['join'], $data['frm'] . '.' . $data['tbl_frm'] . '=' . $data['join'] . '.' . $data['tbl_join'], $data['type']);
        $this->db->order_by($data['order'] . ' ' . $data['order_con']);
        return $this->db->get()->result_array();
    }
}
