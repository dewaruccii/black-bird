<?php
defined('BASEPATH') or exit('No direct script access allowed');
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';
class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Akun_model', 'akun');
        $this->load->model('Email_model', 'email_send');
        $this->load->model('Web_model', 'web_settings');
        $this->load->model('User_model', 'user_m');
    }
    // testing func
    public function test()
    {
        $data = [
            'title' => 'Testing',
        ];
        $this->load->view("templates/new-login-h", $data);
        $this->load->view("auth/forgot");
        $this->load->view("templates/new-login-f");
    }
    // end testing func
    public function index()
    {

        if (isset($this->session->userdata['email'])) {
            $data = [
                'email' => $this->session->userdata('email'),
                'role_id' => $this->session->userdata('role_id')

            ];
            redirect('home');
        } else {
            $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
            $this->form_validation->set_rules('password', 'Password', 'required');
            if ($this->form_validation->run() == false) {
                $settings = $this->web_settings->get_web_settings();
                $settings = $settings[0];
                $data = [
                    'title' => 'Login Page',
                    'name_bold' => $settings['name_bold'],
                    'name_light' => $settings['name_light'],
                ];
                $this->load->view('templates/new-login-h', $data);

                $this->load->view('auth/index');
                $this->load->view('templates/new-login-f');
            } else {
                $this->_login();
            }
        }
    }
    public function register()
    {
        $this->form_validation->set_rules('name', 'Name', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[akun.email]', [
            'is_unique' => 'This email has already registered!'
        ]);
        $this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[3]|matches[password2]', [
            'matches' => 'Password dont match!',
            'min_length' => 'Password too short!'
        ]);
        $this->form_validation->set_rules('password2', 'Password', 'required|trim|matches[password]');

        if ($this->form_validation->run() == false) {

            $settings = $this->web_settings->get_web_settings();
            $settings = $settings[0];
            $data = [
                'title' => 'Register Page',
                'name_bold' => $settings['name_bold'],
                'name_light' => $settings['name_light'],
            ];
            $this->load->view('templates/new-reg-h', $data);
            $this->load->view('auth/register');
            $this->load->view('templates/new-login-f');
        } else {
            $this->_register();
        }
    }
    public function forgot()
    {
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
        if ($this->form_validation->run() == false) {

            $settings = $this->web_settings->get_web_settings();
            $settings = $settings[0];
            $data = [
                'title' => 'Forgot Password',
                'name_bold' => $settings['name_bold'],
                'name_light' => $settings['name_light'],
            ];
            $this->load->view('templates/new-login-h', $data);
            $this->load->view('auth/forgot');
            $this->load->view('templates/new-login-f');
        } else {
            $this->_forgot();
        }
    }
    private function _forgot()
    {
        $email = $this->input->post('email');
        $akun = $this->akun->getAkunByEmail($email);

        if ($akun) {
            $token = bin2hex(random_bytes(32));
            $token_url = base_url('auth/reset_password?email=' . $email . '&token=' . $token);
            $user_token = [
                'uniq' => $token,
                'type' => 'Forgot Password',
                'email' => $email,
                'is_active' => 1
            ];
            $this->email_send->sendEmail($user_token);
            $this->_sendEmail($token_url, $email, $akun['nama'], "Reset Password", 2);
            $this->session->set_flashdata('message', '<script>
            Swal.fire({
                icon: "success",
                title: "Congratulation!",
                text: "Please check your email to reset your password!",
                footer: "<a href=' . base_url() . '>Back to Login?</a>",
                
              })
            </script>');
            redirect('auth/forgot');
        } else {
            $this->session->set_flashdata('message', '<script>
            Swal.fire({
                icon: "error",
                title: "Oops..",
                text: "This Email is not registered",
                
              })
            </script>');
            redirect('auth/forgot');
        }
    }
    private function _login()
    {
        $email = $this->input->post('email');
        $password = $this->input->post('password');
        $user = $this->akun->getInfoAkun($email);
        $user = $user[0];

        if ($user) {
            if (password_verify($password, $user['password'])) {
                if ($user['is_active'] == 1) {
                    $data = [
                        'email' => $user['email'],
                        'role_id' => $user['role_id']
                    ];
                    $this->session->set_userdata($data);
                    // redirect('home');
                    // REDIRECT FUNCTIONS
                    if ($user['role_id'] == 1) {
                        redirect('admin');
                    } else {
                        redirect('settings/profile');
                    }
                } else {
                    $this->session->set_flashdata('message', '<script>
                    Swal.fire({
                        icon: "error",
                        title: "Oops..",
                        text: "This Account is not active!",
                        
                      })
                    </script>');
                    redirect('/');
                }
            } else {
                $this->session->set_flashdata('message', '<script>
                Swal.fire({
                    icon: "error",
                    title: "Oops..",
                    text: "Password Wrong!",
                    
                  })
                </script>');
                redirect('/');
            }
        } else {
            $this->session->set_flashdata('message', '<script>
            Swal.fire({
                icon: "error",
                title: "Oops..",
                text: "This email is not registered!",
                
              })
            </script>');
            redirect('/');
        }
    }
    private function _register()
    {
        $data = [
            'id_akun' => rand(555555, 9999999),
            'email' => htmlspecialchars($this->input->post('email', true)),
            'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
            'role_id' => 2,
            'is_active' => 0,
            'created_at' => time()
        ];
        $user_dat = [
            'id_akun' => $data['id_akun'],
            'email' => $data['email'],
            'nama' => htmlspecialchars($this->input->post('name', true)),
            'image' => 'default.jpg',
            'phone' => '',
            'location' => '',
            'notes' => '',
        ];
        $random_token = bin2hex(random_bytes(32));
        $token = base_url('auth/verify?email=' . $data['email'] . '&token=' . $random_token);
        $email_data = [
            'uniq' => $random_token,
            'type' => 'Activated Account',
            'email' => $data['email'],
            'is_active' => 1
        ];
        $this->akun->register($data);
        $this->user_m->addProfile($user_dat);
        $this->email_send->sendEmail($email_data);
        $this->_sendEmail($token, $data['email'], $data['nama'], "Activated Account", 1);
        $this->session->set_flashdata('message', '<script>
        Swal.fire({
            icon: "success",
            title: "Congratulation!",
            text: "Your account has been created. Please cek your email to activated your account!",
            footer: "<a href=' . base_url() . '>Back to Login?</a>",
            
          })
        </script>');
        redirect('auth/register');
    }
    private function _sendEmail($token, $to, $name, $type, $info)
    {
        $mail = new PHPMailer(true);

        try {
            //Server settings
            // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
            $mail->isSMTP();                     // Send using SMTP
            $mail->Host       = 'tls://smtp.gmail.com';                    // Set the SMTP server to send through
            $mail->SMTPAuth   = true;             // Enable SMTP authentication
            $mail->SMTPSecure = 'TLS';
            $mail->Username   = 'lioncompany48@gmail.com';                     // SMTP username
            $mail->Password   = 'zzkfkucuhxbopmtj';                               // SMTP password
            // $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
            //Recipients
            // $mail->setFrom();
            $mail->addAddress($to, $name);     //Add a recipient
            // $mail->addAddress('ellen@example.com');               //Name is optional
            $mail->addReplyTo("lioncompany48@gmail.com", "Alexandro 77");
            // $mail->addCC('cc@example.com');
            // $mail->addBCC('bcc@example.com');

            //Attachments
            // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
            // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
            //Logic
            if ($info == 1) {
                $info = "you need to confirm your account";
            } elseif ($info == 2) {
                $info = "you need to reset your password";
            }


            //End Logic
            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $email_template = base_url('assets/html/mail_template.html');
            $message = file_get_contents($email_template);
            $message = str_replace('%btntext%', $type, $message);
            $message = str_replace('%txtnama%', $name, $message);
            $message = str_replace('%txtinfo%', $info, $message);
            $message = str_replace('%token%', $token, $message);
            $mail->Subject = $type;
            $mail->msgHTML($message);
            // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
            if ($mail->send()) {
                echo 'Success';
            } else {
                echo 'Error';
                die;
            }
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

    public function reset_password()
    {
        $dat = [
            'email' => $this->input->get('email'),
            'token' => $this->input->get('token')
        ];

        if ($this->email_send->cek_token($dat) > 0) {
            $info = $this->email_send->get_info_token($dat);
            $info = $info[0];

            if ($info['is_active'] == 1) {

                $this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[6]|matches[password2]', [
                    'matches' => 'Password dont match!',
                    'min_length' => 'Password too short!'
                ]);
                $this->form_validation->set_rules('password2', 'Password', 'required|trim|min_length[6]|matches[password]', [
                    'matches' => 'Password dont match!',
                    'min_length' => 'Password too short!'
                ]);

                if ($this->form_validation->run() == false) {

                    $settings = $this->web_settings->get_web_settings();
                    $settings = $settings[0];
                    $data = [
                        'title' => 'Reset Password',
                        'name_bold' => $settings['name_bold'],
                        'name_light' => $settings['name_light'],
                    ];
                    $data['url'] = base_url('auth/reset_password?email=' . $dat['email'] . '&token=' . $dat['token']);
                    $this->load->view('templates/new-login-h', $data);
                    $this->load->view('auth/reset');
                    $this->load->view('templates/new-login-h');
                } else {
                    $email = $this->input->get('email');

                    $password = $this->input->post('password');
                    $this->akun->reset_password($email, $password);
                    $this->email_send->edit_token($dat);
                    $this->session->set_flashdata('message', '<script>
                       Swal.fire({
                         icon: "success",
                         title: "Congratulation!",
                         text: "Your password has been changed!",
                       
                         
                          })
                       </script>');
                    redirect('/');
                }
            } else {
                $this->session->set_flashdata('message', '<script>
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Your token has been expired!",
                 
                    
                  })
                </script>');
                redirect('/');
            }
        } else {
            $this->session->set_flashdata('message', '<script>
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "Your token is invalid!",
             
                
              })
            </script>');
            redirect('/');
        }
    }

    public function verify()
    {
        $data = [
            'email' => $this->input->get('email'),
            'token' => $this->input->get('token')
        ];

        if ($this->email_send->cek_token($data) > 0) {
            $info = $this->email_send->get_info_token($data);
            $info = $info[0];
            if ($info['is_active'] == 1) {
                $this->akun->activate_account($data);
                $this->email_send->edit_token($data);
                $this->session->set_flashdata('message', '<script>
                Swal.fire({
                    icon: "success",
                    title: "Congratulation!",
                    text: "Your account has been activated!",
                    
                    
                  })
                </script>');
                redirect('/');
            } else {
                $this->session->set_flashdata('message', '<script>
                Swal.fire({
                    icon: "error",
                    title: "Oops..",
                    text: "This link expired!",
                    
                  })
                </script>');
                redirect('/');
            }
        } else {
            $this->session->set_flashdata('message', '<script>
            Swal.fire({
                icon: "error",
                title: "Oops..",
                text: "Token Wrong!",
                
              })
            </script>');
            redirect('/');
        }
    }

    public function logout()
    {
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('role_id');
        $this->session->set_flashdata('message', '<script>
        Swal.fire({
            icon: "success",
            title: "Logout Success!",
            text: "You have been logout!",
          
            
          })
        </script>');
        redirect('/');
    }
}
