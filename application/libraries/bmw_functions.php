<?php



class bmw_functions
{

    protected $CI;
    public function __construct()
    {
        $this->CI = &get_instance();
    }
    public function generate_string($input, $strength = 16)
    {
        $input_length = strlen($input);
        $random_string = '';
        for ($i = 0; $i < $strength; $i++) {
            $random_character = $input[mt_rand(0, $input_length - 1)];
            $random_string .= $random_character;
        }

        return $random_string;
    }

    public function breadcrumb()
    {
        $this->CI->load->helper('url');
        return  [
            'segment1' => $this->CI->uri->segment(1),
            'segment2' => $this->CI->uri->segment(2)
        ];
    }
    public function cekAccessMenu()
    {
        $this->CI->load->model('Menu_model', 'menu');
        $this->CI->load->library('session');

        $role_id = $this->CI->session->userdata('role_id');

        // if ($this->menu->getWhere('user_access_menu', [
        //     'role_id' => $role_id
        // ]) > 0) {
        // }

        var_dump($this->CI->menu->getWhere('user_access_menu', [
            'role_id' => $role_id
        ]));
    }
}
