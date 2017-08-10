<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Roles_Model extends CI_Model {
	
	
	public function __construct() {
		parent::__construct();
	}
	
	// saves new and updated records 
	public function save($data, $role_id = null) {
		
		$step_id = $data['step'];
		$name = $data['name'];
		
		if($role_id == null || $role_id == "") {
		
			$sql = " insert into role (step_id, name ) values ($step_id,'".$name."') ";
				
		} else {
			
			$sql = " update role set step_id = $step_id, name = '".$name."' where id = $role_id ";
			
		}
		
		$this->db->query($sql); 
		
	}
	
	// get single row 
	public function getOne($role_id) {
		
		$sql = " select * from role where id = $role_id ";
		
		return $this->db->query($sql)->result_array();
	}
	
	// list all roles
	public function listAll() {
		
		$sql = " select a.*, a.name as role_name , b.name as step_name
				, case when is_academic = 1 then 'Academic'
					when is_academic = 0 then 'Non Academic' end as acad_category 
				from role a join steps b on b.id = a.step_id ";
		
		return $this->db->query($sql)->result_array();
	}
	
    
	public function delete( $role_id ) {
		
		$sql = " delete from role where id = $role_id ";
		
		return $this->db->query($sql);
	}
	
}
