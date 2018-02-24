<?php

include_once 'M_records.php';

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class M_comments extends M_records
{
    protected $table = 'comments';

    public function __construct()
    {
        $this->setTableName($this->table);
        parent::__construct();
    }

    public function getByCourse($course_id)
    {
        $this->db->select('comments.*, users.id AS user_id, users.name');
        $this->db->join('users', 'users.id = comments.user_id');
        $this->db->where('comments.course_id', $course_id);
        return $this->db->get($this->table)->result();
    }
}
