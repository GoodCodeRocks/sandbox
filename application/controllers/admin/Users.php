<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {
	
	function __construct() {
		
		parent::__construct();
		$this->load->model('admin/Users_Model','Users');
		$this->load->model('admin/Roles_Model','Roles');
		$this->load->model('admin/Departments_Model','Departments');
		$this->output->enable_profiler(TRUE);
	}
	
	function index() {
		
		$this->list();
	}
	
	function list() {
		
		$data['Users'] =$this->Users->listAll();
		
		$data['content'] = 'admin/users/index_v';
		
		$this->load->view('template/main_template', $data );
	}
	
	function form() {
		
		$user_id = 0;
		
		$data['uid'] = "";
		$data['username'] = "";
		$data['last_name'] = "";
		$data['first_name'] = "";
		$data['reference_no'] = "";
		
		if ( $this->uri->segment(4) ) {
			
			$user_id = $this->uri->segment(4) ;
			
			// get row that matches the role to be edited
			
			$row = $this->Users->getOne($user_id);
			
			$data['uid'] = $row[0]['id'];
			$data['username'] = $row[0]['username'];
			$data['first_name'] = $row[0]['first_name'];
			$data['last_name'] = $row[0]['last_name'];
			$data['reference_no'] = $row[0]['reference_no'];
			$data['UserRoles'] = $this->Users->getUserRoles($user_id);
			$data['UserDepartments'] = $this->Users->getUserDepartments($user_id);
			
		}
		
		$data['Roles'] = $this->Roles->listAll();
		$data['Departments'] = $this->Departments->listAll();
		
		
		$data['content'] = 'admin/users/form_v';
		
		$this->load->view('template/main_template', $data );
		
	}
	
	function save() {
		
		if ($this->form_validation->run('users') == FALSE) {
			
			$this->form();
			
		} else {
			
			$data = $_POST;
			
			if( isset($_POST['uid']) ) {
				
				$this->Users->save($data, $_POST['uid']);
				
			}
			else {
				
				$this->Users->save($data);
				
			}
			
			redirect('admin/users','location');
			
		}
		
	}
	
	
	function delete() {
		
		$this->Users->delete(  $this->uri->segment(4));
		
		redirect('admin/users','location');
	}
	
	public function getDepartments() {
		var_dump($_POST);
	}
}