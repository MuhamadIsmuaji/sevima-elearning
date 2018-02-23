<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Register extends CI_Controller
{
    private $role_datas = null;
    private $roles_validation = '';    

    public function __construct()
    {
        parent::__construct();
        $this->auth();
        $this->load->library(['form_validation']);
        $this->load->model(['M_roles' => 'roles', 'M_users' => 'users']);

//      find all roles data (expect admin) for form option
        $this->role_datas = $this->roles->findAllByCondition(['id !=' => 1]);

//      get role validation string for form validation
        foreach($this->role_datas as $key => $role) {
            $concat = sizeof($this->role_datas) - 1 == $key ? '' : ',';
            $this->roles_validation .= $role->id . $concat;
        }
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
        $data['header'] = 'header';
        $data['content'] = 'register/index';
        $data['footer'] = 'footer';
        $data['roles'] = $this->role_datas;
        
        if (empty($_POST)) {
            $this->load->view('template', $data);
        } else {
            $post = $this->input->post();
            $redirectTo = 'register';

//          Form validation rules and error messages
            $this->form_validation->set_rules('name', 'Nama Lengkap', 'trim|required|max_length[50]', [
                'required' => '%s wajib diisi.',
                'max_length' => '%s tidak boleh melebihi 50 karakter.',
            ]);

            $this->form_validation->set_rules('email', 'Email', 'trim|required|max_length[50]|valid_email|is_unique[users.email]', [
                'required' => '%s wajib diisi.',
                'max_length' => '%s tidak boleh melebihi 50 karakter.',
                'valid_email' => '%s tidak valid.',
                'is_unique' => 'Email yang anda gunakan sudah terdaftar.'                                            
            ]);

            $this->form_validation->set_rules('role_id', 'Daftar Sebagai', 'trim|required|max_length[1]|in_list[' . $this->roles_validation . ']', [
                'required' => '%s wajib diisi.',
                'max_length' => '%s tidak valid.',
                'in_list' => '%s tidak valid.',                
            ]);

            $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[4]|alpha_numeric', [
                'required' => '%s wajib diisi.',
                'min_length' => '%s minimal terdiri dari 4 karakter atau lebih.',
                'alpha_numeric' => '%s hanya boleh terdiri dari huruf dan angka.',                                                
            ]);

            $this->form_validation->set_rules('passwordconf', 'Konfirmasi Password', 'trim|required|matches[password]', [
                'required' => '%s wajib diisi.',
                'matches' => '%s tidak sama.',
            ]);                                    

            if (!$this->form_validation->run()) {
                $this->session->set_flashdata('feedback_danger', validation_errors());                
            } else {
                $data = [
                    'email' => $post['email'],
                    'password' => md5($post['password']),
                    'name' => $post['name'],
                    'role_id' => $post['role_id'],
                    'register_at' => date('Y-m-d H:i:s'),
                ];

                $message = '<strong>Maaf,</strong> terjadi kesalahan silahkan ulangi lagi.';

                if ($this->users->insert($data)) {
                    $message = '<strong>Halo,</strong> ' . $data['name'] . '. Selamat datang di Sevima E-Learning.';

                    $auth = $this->users->findOne([
                        'email' => $data['email'],
                        'password' => $data['password'],
                    ]);
                    
                    $redirectTo = Lib::getRedirectTo($auth->role_id);
                    $this->session->set_userdata('sevima-elearning', $auth);                    
                }

            }

            $this->session->set_flashdata('feedback_success', $message);                            
            redirect($redirectTo);                            
        }
    }
}
