<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->load->view('login_form');
    }

    public function submit()
    {
        $user_email = $this->input->post('email');
        $user_password = $this->input->post('password');

        if ($user_email == "admin@admin.com" && $user_password == "admin123") {
            $session_data = array(
                'is_login' => 'Yes',
            );

            $this->session->set_userdata($session_data);
            redirect('/generate');
        } else {
            redirect('/');
        }
    }
}