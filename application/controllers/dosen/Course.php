<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Course extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();        
        $this->load->library(['form_validation']);
        $this->load->model(['M_courses' => 'courses']);
        $this->auth();        
    }

    public function auth()
    {
        $auth = $this->session->userdata('sevima-elearning');

        if (!$auth || $auth->role_id != 2) {
            redirect('home');
        }
    }

    public function index()
    {
        $data['header'] = 'header';
        $data['content'] = 'dosen/courses/index';
        $data['footer'] = 'footer';

        $this->load->view('template', $data);
    }

    public function getall($page=null, $lim=null, $keyword=null) 
    {
        
        $keyword = str_replace('%20', ' ', $keyword);

        $auth = $this->session->userdata('sevima-elearning');
        
        $filter = [];
        array_push($filter, 'courses.user_id = "' . $auth->id .'"');
    
        $total_rows = count($this->courses->findCustom(null, null, $filter, $keyword));
        
        $paging = Lib::pagingData($page, $total_rows, $lim);

        $data = $this->courses->findCustom($lim, $paging['offset'], $filter, $keyword);        

        $output = [
            'nomer_start'   => $paging['offset'],
            'page'          => $paging['page'],
            'tot_page'      => $paging['tot_page'],
            'total_rows'    => $total_rows,            
            'data'          => $data,
        ];

        echo json_encode($output);

    }

    public function create()
    {
        $data['header'] = 'header';
        $data['content'] = 'dosen/courses/course_form';
        $data['form_title'] = 'Tambah Materi';
        $data['form_action'] = 'dosen/course/create';        
        $data['is_edit'] = false;        
        $data['footer'] = 'footer';

        if (empty($_POST)) {
            $this->load->view('template', $data);
        } else {
            $post = $this->input->post();
            $type = 'feedback_danger';
            $message = '';
            $redirectTo = 'dosen/courses/create';
            $errorFlag = 0;
            $uploadFlag = 0;            

//          Form validation rules and error messages
            $this->form_validation->set_rules('title', 'Nama', 'trim|required|max_length[100]', [
                'required' => '%s wajib diisi.',
                'max_length' => '%s tidak boleh melebihi 100 karakter.',
            ]);

            $this->form_validation->set_rules('duration', 'Durasi', 'trim|required|greater_than_equal_to[1]', [
                'required' => '%s wajib diisi.',
                'greater_than_equal_to' => '%s minimal harus 1 jam.',
            ]);

            $this->form_validation->set_rules('description', 'Deskripsi Singkat', 'trim|required', [
                'required' => '%s wajib diisi.',
            ]);

            $this->form_validation->set_rules('content', 'Konten', 'trim|required', [
                'required' => '%s wajib diisi.',
            ]);
            
            if (!$this->form_validation->run()) {
                $errorFlag = 1;
                $message = validation_errors();
            } else {
                if (!empty($_FILES['attachment']['name'])) {
                    $uploadFlag = 1;

                    $config['upload_path']          = './assets/attachment/';
                    $config['allowed_types']        = 'docx|pdf|xlsx|pptx|jpg|jpeg|png|mp4';
                    $config['file_name']            = 'Lampiran ' . $post['title'];
                    $config['max_size']             = 50000; //50 MB
                    $config['file_ext_tolower']		= FALSE;
                    $this->load->library('upload', $config);
                    
                    if (!$this->upload->do_upload('attachment')) {
                        $errorFlag = 1;
                        $message = '<strong>Maaf,</strong> terjadi kesalahan saat mengunggah lampiran silahkan ulangi lagi.';
                    }
                }
            }

//          insert process
            if ($errorFlag == 0) {

                $auth = $this->session->userdata('sevima-elearning');
                
                $data = [
                    'user_id' => $auth->id,
                    'title' => $post['title'],
                    'duration' => $post['duration'],
                    'description' => $post['description'],
                    'content' => $post['content'],
                    'attachment' => $uploadFlag == 0 ? NULL : $this->upload->data('file_name'),
                    'created_at' => date('Y-m-d H:i:s'),
                ];

                $type = 'feedback_danger';
                $message = '<strong>Maaf,</strong> terjadi kesalahan silahkan ulangi lagi.';
                
                if ($this->courses->insert($data)) {
                    $redirectTo = 'dosen/courses';
                    $type = 'feedback_success';
                    $message = '<strong>Berhasil,</strong> materi telah ditambahkan.';
                }              
            }

            $this->session->set_flashdata($type, $message);                            
            redirect($redirectTo); 
        }
    }

    public function update($id = null)
    {
        $auth = $this->session->userdata('sevima-elearning');        
        $course = $this->courses->findOne(['id' => $id, 'user_id' => $auth->id]);

        if (!$course) {
            redirect('dosen/courses');
        } else {
            $data['header'] = 'header';
            $data['content'] = 'dosen/courses/course_form';
            $data['form_title'] = 'Ubah Materi';
            $data['form_action'] = 'dosen/course/update/' . $course->id;
            $data['is_edit'] = true;
            $data['course'] = $course;                            
            $data['footer'] = 'footer';

            if (empty($_POST)) {
                $this->load->view('template', $data);                
            } else {
                $post = $this->input->post();
                $type = 'feedback_danger';
                $message = '';
                $redirectTo = $data['form_action'];
                $errorFlag = 0;
                $uploadFlag = 0;            
    
    //          Form validation rules and error messages
                $this->form_validation->set_rules('title', 'Nama', 'trim|required|max_length[100]', [
                    'required' => '%s wajib diisi.',
                    'max_length' => '%s tidak boleh melebihi 100 karakter.',
                ]);
    
                $this->form_validation->set_rules('duration', 'Durasi', 'trim|required|greater_than_equal_to[1]', [
                    'required' => '%s wajib diisi.',
                    'greater_than_equal_to' => '%s minimal harus 1 jam.',
                ]);
    
                $this->form_validation->set_rules('description', 'Deskripsi Singkat', 'trim|required', [
                    'required' => '%s wajib diisi.',
                ]);
    
                $this->form_validation->set_rules('content', 'Konten', 'trim|required', [
                    'required' => '%s wajib diisi.',
                ]);
                
                if (!$this->form_validation->run()) {
                    $errorFlag = 1;
                    $message = validation_errors();
                } else {
                    if (!empty($_FILES['attachment']['name'])) {
                        $uploadFlag = 1;
    
                        $config['upload_path']          = './assets/attachment/';
                        $config['file_name']            = 'Lampiran ' . $post['title'];                        
                        $config['allowed_types']        = 'docx|pdf|xlsx|pptx|jpg|jpeg|png|mp4';
                        $config['max_size']             = 50000; //50 MB
                        $config['file_ext_tolower']		= FALSE;
                        $this->load->library('upload', $config);
                        
                        if (!$this->upload->do_upload('attachment')) {
                            $errorFlag = 1;
                            $message = '<strong>Maaf,</strong> terjadi kesalahan saat mengunggah lampiran silahkan ulangi lagi.';
                        }
                    }
                }
    
    //          insert process
                if ($errorFlag == 0) {
                        
                    $data = [
                        'title' => $post['title'],
                        'duration' => $post['duration'],
                        'description' => $post['description'],
                        'content' => $post['content'],
                        'attachment' => $uploadFlag == 0 ? $course->attachment : $this->upload->data('file_name'),
                    ];
    
                    $type = 'feedback_danger';
                    $message = '<strong>Maaf,</strong> terjadi kesalahan silahkan ulangi lagi.';
                    
                    if ($this->courses->update($data, ['id' => $course->id])) {
//                      delete old files
                        if ($uploadFlag == 1) {
                            unlink('./assets/attachment/' . $course->attachment);
                        }

                        $redirectTo = 'dosen/courses';
                        $type = 'feedback_success';
                        $message = '<strong>Berhasil,</strong> materi telah diubah.';
                    }              
                }
    
                $this->session->set_flashdata($type, $message);                            
                redirect($redirectTo); 
            }

        }

    }

    public function detail($id = null) 
    {
        if (!$id) {
            redirect('home');
        }
        
        redirect('courses/detail/' . $id);
    }

    public function delete($id = null) {
        if (!$id) {
            redirect('home');
        }

        $type = 'feedback_danger';
        $message = '<strong>Maaf,</strong> terjadi kesalahan saat mengunggah lampiran silahkan ulangi lagi.';

        if ($this->courses->delete(['id' => $id])) {
            $type = 'feedback_success';
            $message = '<strong>Berhasil,</strong> materi telah terhapus.';
        }

        $this->session->set_flashdata($type, $message);                            
        redirect('dosen/courses');
        
    }
}
