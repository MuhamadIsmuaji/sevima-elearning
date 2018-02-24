<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Comment extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();        
        $this->load->model(['M_comments' => 'comments']);
        $this->load->library(['form_validation']);        
        $this->auth();        
    }

    public function auth()
    {
        $auth = $this->session->userdata('sevima-elearning');

        if (!$auth) {
            redirect('home');
        }
    }

    public function create()
    {
        if (empty($_POST)) {
            redirect('home');
        } else {
            $post = $this->input->post();
            $auth = $this->session->userdata('sevima-elearning');
            $course_id = $post['course_id'];
            $type = 'feedback_danger';
            $message = '<strong>Maaf,</strong> terjadi kesalahan saat mengunggah lampiran silahkan ulangi lagi.';
            $redirectTo = 'courses/detail/' . $course_id;

            $this->form_validation->set_rules('comment_content', 'Komentar', 'trim|required', [
                'required' => 'Komentar tidak boleh kosong.',
            ]);

            if (!$this->form_validation->run()) {
                $message = validation_errors();
            } else {
                $data = [
                    'user_id' => $auth->id,
                    'course_id' => $course_id,
                    'comment_content' => $post['comment_content'],
                    'created_at' => date('Y-m-d H:i:s'),
                ];

                if ($this->comments->insert($data)) {
                    $type = 'feedback_success';
                    $message = '<strong>Berhasil,</strong> komentar telah ditambahkan.';
                }
            }

            $this->session->set_flashdata($type, $message);                            
            redirect($redirectTo);
        }
        
    }
    

}
