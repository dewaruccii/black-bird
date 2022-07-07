<?php

class Akun_model extends CI_Model
{
    public function cekAkun($data)
    {
        return $this->db->get_where('akun', [
            'email' => $data['email']
        ])->num_rows();
    }
    public function getInfoAkun($email)
    {
        return $this->db->get_where('akun', [
            'email' => $email
        ])->result_array();
    }
    public function register($data)
    {
        return $this->db->insert('akun', $data);
    }
    public function editPassword($data)
    {
        $this->db->update('akun', [
            'password' => $data['password']
        ], [
            'email' => $data['email']
        ]);
        return $this->db->affected_rows();
    }
    public function activate_account($data)
    {
        $this->db->update('akun', [
            'is_active' => 1
        ], [
            'email' => $data['email']
        ]);
        return $this->db->affected_rows();
    }
    public function getAkunByEmail($email)
    {
        return $this->db->get_where('akun', [
            'email' => $email
        ])->row_array();
    }
    public function reset_password($email, $password)
    {
        $this->db->update('akun', [
            'password' => password_hash($password, PASSWORD_DEFAULT)
        ], [
            'email' => $email
        ]);
        return $this->db->affected_rows();
    }
}
