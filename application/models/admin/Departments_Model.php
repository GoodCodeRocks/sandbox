<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Departments_Model extends CI_Model {
	
	
	public function __construct() {
		parent::__construct();
	}
	
	// saves new and updated records
	public function save($data, $department_id = null) {
		
		
		$name = $data['name'];
		$is_academic = $data['academic'];
		$division_id= 0;
		
		if( $department_id == null || $department_id == "" ) {
			
			$sql = " insert into department (name, is_academic, division_id) values ('".$name."', $is_academic, $division_id ) ";
			
		} else {
			
			$sql = " update department set name = '".$name."' , is_academic= $is_academic , division_id = $division_id where id = $department_id ";
			
		}
		
		$this->db->query($sql);
		
	}
	
	// get single row
	public function getOne($department_id) {
		
		$sql = " select * from department where id = $department_id ";
		
		return $this->db->query($sql)->result_array();
	}
	
	// list all departments
	public function listAll() {
		
		$sql = " select a.*, a.name as department_name from department a order by name  ";
		
		return $this->db->query($sql)->result_array();
	}
	
	
	public function delete( $department_id ) {
		
		$sql = " delete from department where id = $department_id ";
		
		return $this->db->query($sql);
	}
	
}
