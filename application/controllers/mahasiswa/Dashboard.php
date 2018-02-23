<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    public function index()
    {
        $data['message'] = 'Hello world';
        $data['header'] = 'header';
        $data['content'] = 'mahasiswa/dashboard/index';
        $data['footer'] = 'footer';

        $this->load->view('template', $data);
    }
}
