<?php

include_once 'M_records.php';

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class M_courses extends M_records
{
    protected $table = 'courses';
    protected $users = 'users';

    protected $listColumn = [];
	protected $listLike = [];

    public function __construct()
    {
        $this->setTableName($this->table);

        $this->setRelations($this->users, $this->users . '.id = ' . $this->table . '.user_id');

        array_push($this->listColumn, $this->table . '.id');
        array_push($this->listColumn, $this->table . '.user_id');
        array_push($this->listColumn, $this->table . '.title');
        array_push($this->listColumn, $this->table . '.duration');
        array_push($this->listColumn, $this->table . '.description');
        array_push($this->listColumn, $this->table . '.created_at');
        
        array_push($this->listColumn, $this->users . '.name');        
        
        $this->setListColumn($this->listColumn);
        
        $this->setOrderBy($this->table . '.id');

        parent::__construct();
    }

    public function getSingleWithUser($id)
    {
        $this->db->select('courses.*, users.name');
        $this->db->join('users', 'users.id = courses.user_id');
        $this->db->where('courses.id', $id);
		return $this->db->get($this->table)->row();
    }
}
