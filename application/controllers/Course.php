<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Course extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();        
        $this->load->model(['M_courses' => 'courses', 'M_comments' => 'comments']);        
    }

    public function detail($id = null) {
        if (!$id) {
            redirect('home');
        }

        $course = $this->courses->getSingleWithUser($id);

        if (!$course) {
            redirect('home');            
        } else {
            $data['header'] = 'header';
            $data['content'] = 'courses/index';
            $data['course'] = $course;
            $data['comments'] = $this->comments->getByCourse($course->id);                                    
            $data['footer'] = 'footer';


            $this->load->view('template', $data);
        }

    }

    public function getAll($page=null, $lim=null, $keyword=null) 
    {
        $keyword = str_replace('%20', ' ', $keyword);
        
        $total_rows = count($this->courses->findCustom(null, null, null, $keyword));
        
        $paging = Lib::pagingData($page, $total_rows, $lim);

        $data = $this->courses->findCustom($lim, $paging['offset'], null, $keyword);

        $output = [
            'nomer_start'   => $paging['offset'],
            'page'          => $paging['page'],
            'tot_page'      => $paging['tot_page'],
            'total_rows'    => $total_rows,            
            'data'          => $data,
        ];

        echo json_encode($output);
    }

    public function download($filename)
    {
        $this->load->helper('download');
        $file = file_get_contents('assets/attachment/'.$filename);
        force_download($fileName, $file);
    }

}
