<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Departments extends CI_Controller {
	
	
	public function __construct() {
		
		parent::__construct();
		
		$this->load->model('admin/Roles_Model','Roles');
		$this->load->model('admin/Departments_Model','Departments');
		$this->output->enable_profiler(TRUE);
		
	}
	
	function index() {
		$this->list();
	}
	
	function list() {
		
		$data['Departments'] =$this->Departments->listAll();
		
		$data['content'] = 'admin/departments/index_v';
		
		$this->load->view('template/main_template',$data);
	}
	
	function form() {
		
		$step_id = 0;
				
		$data['name'] = "";
		$data['is_academic'] = "";
		$data['department_id'] = "";
		$data['division_id'] = "";
		
		if( $this->uri->segment(4) ) {
			
			$step_id = $this->uri->segment(4) ;
			
			$row = $this->Departments->getOne($step_id);
			$data['department_id'] =  $row[0]['id'];
			$data['division_id'] = $row[0]['division_id'];
			$data['name'] = $row[0]['name'];
			$data['is_academic'] = $row[0]['is_academic'];
			
			
		}
		
		$data['content'] = 'admin/departments/form_v';
		
		$this->load->view('template/main_template',$data);
		
	}
	
	function save() {
		
		if ($this->form_validation->run('department') == FALSE) {
			
			$this->form();
			
		} else {
			
			$data = $_POST;
			
			if(  $_POST['did'] ) {
				
				$this->Departments->save($data, $_POST['did'] );
				
			}
			else {
				
				$this->Departments->save($data);
				
			}
			
			redirect('admin/departments','location'); 
			
		}
		
		
	}
	
	function delete() {
		
		$this->Departments->delete(  $this->uri->segment(4));
		
		redirect('admin/departments','location');
	}
	
	

	
}