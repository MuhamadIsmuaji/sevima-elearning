<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Register extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->auth();
    }

    public function auth()
    {
        $user = $this->session->userdata('sevima-elearning');

        if ($user) {
            $redirectTo = Lib::getRedirectTo($user->role_id);
            redirect($redirectTo);
        }
    }

    public function index()
    {
        if (empty($_POST)) {
        } else {
        }

        $data['message'] = 'Hello world';
        $data['header'] = 'header';
        $data['content'] = 'register/index';
        $data['footer'] = 'footer';

        $this->load->view('template', $data);
    }
}
