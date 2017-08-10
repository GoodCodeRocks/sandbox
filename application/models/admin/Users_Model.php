<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users_Model extends CI_Model {
	
	private $user_id;
	
	private $new_record;
	
	public function __construct() {
		parent::__construct();
	}
	
	// saves new and updated records
	public function save($data, $user_id = null) {
		
		$this->new_record = false;
		
		$username = $data['uname'];
		$first_name= $data['fname'];
		$last_name= $data['lname'];
		$reference_no = $data['reference']; // to link user to aeorion account
		
		if($user_id == null || $user_id == "") {
			
			$sql = " insert into users (username, first_name, last_name ) 
					 values ('".$username."', '".$first_name."', '".$last_name."') ";
			
			$this->new_record = true;
			
		} else {
			
			$sql = " update users set username = '".$username."' 
					
							, first_name= '".$first_name."'
							, last_name = '".$last_name."' 
							, reference_no = '".$reference_no."'
						
				     where id = $user_id ";
			
		}
		
		// save data
		$this->db->query($sql);
		
		// if new user created, create new roles
		if($this->new_record ) {
			
			$this->user_id = $this->db->insert_id();
			
			$this->saveUserRoles($data, $this->user_id);
			$this->saveUserDepartments( $data, $this->user_id);
		}
		
		// if updating user, update roles
		if(!$this->new_record) {
			
			//delete old
			$this->deleteUserDepartments($user_id);
			$this->deleteUserRoles($user_id);
			
			// save new
			$this->saveUserRoles($data, $user_id);
			$this->saveUserDepartments( $data, $user_id);
			
		}
		
		
	}
	
	// get single row
	public function getOne($user_id) {
		
		$sql = " select * from users where id = $user_id ";
		
		return $this->db->query($sql)->result_array();
	}
	
	// list all userss
	public function listAll() {
		
		$sql = " select a.*  from users a  ";
		
		return $this->db->query($sql)->result_array();
	}
	
	
	public function delete( $user_id ) {
		
		$sql = " delete from users where id = $user_id ";
		
		return $this->db->query($sql);
	}
	
	
	// can be placed in another file
	
	public function saveUserRoles($data, $user_id ) {
		
		var_dump($data['roles']);
		echo "user ".$user_id;
		if ( isset($data['roles'] ) ) {
			
			foreach ($data['roles'] as $role_id) {
			
				$sql = " insert into user_role (user_id, role_id) values ( $user_id, $role_id ) ";
				$this->db->query($sql);
			
			} 
		} 
		
	}
	
	public function getUserRoles($user_id) {
		
		$sql = " select a.id, a.user_id, a.role_id
				 	from 
					user_role a
					join role c on c.id = a.role_id
					where 
					a.user_id = $user_id ";
		
		return $this->db->query($sql)->result_array();
	}
	
	
	public function saveUserDepartments( $data, $user_id ) {
		
		if ( isset($data['departments'] ) ) {
			
			foreach ($data['departments'] as $department_id) {
				
				$sql = " insert into users_department (users_id, department_id, assigned_at ) values ( $user_id, $department_id, current_date() ) ";
				
				$this->db->query($sql);
				
			}
		} 
		
	}
	
	function deleteUserRoles($user_id) {
		$sql = "delete from user_role where user_id = $user_id ";
		$this->db->query($sql);
	}
	
	function deleteUserDepartments($user_id) {
		$sql = "delete from users_department where users_id = $user_id ";
		$this->db->query($sql);
	}
	
	public function getUserDepartments($user_id) {
		
		$sql = " select a.id, b.department_id, b.users_id
				from
				users a
				join users_department b on b.users_id = a.id
				where b.users_id = $user_id ";
		
		return $this->db->query($sql)->result_array();
		
	}
	
	
}
