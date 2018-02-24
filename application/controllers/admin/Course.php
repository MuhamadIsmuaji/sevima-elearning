<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Course extends CI_Controller
{
    public function index()
    {
        $data['header'] = 'header';
        $data['content'] = 'admin/course/index';
        $data['footer'] = 'footer';

        $this->load->view('template', $data);
    }
}
