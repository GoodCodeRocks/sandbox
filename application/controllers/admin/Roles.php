<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Roles extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->model('admin/Steps_Model','Steps');
		$this->load->model('admin/Roles_Model','Roles');
		$this->output->enable_profiler(TRUE);
	}
	
	function index() {
		
		$this->list();
	}
	
	function list() {
		
		$data['Roles'] =$this->Roles->listAll();
		
		$data['content'] = 'admin/roles/index_v';
		
		$this->load->view('template/main_template', $data );
	}
	
	function form() {
		
		$role_id = 0;
		
		//echo $this->uri->segment(4);
		
		$data['step_id'] = "";
		$data['name'] = "";
		$data['rid'] = "";
		
		if ( $this->uri->segment(4) ) {
			
			$role_id = $this->uri->segment(4) ;
			
			// get row that matches the role to be edited
			
			$row = $this->Roles->getOne($role_id);
			
			$data['rid'] = $row[0]['id'];
			$data['name'] = $row[0]['name'];
			$data['step_id'] = $row[0]['step_id'];
						
		}
		
		$data['Steps'] = $this->Steps->listAll();
		
		$data['content'] = 'admin/roles/form_v';
				
		$this->load->view('template/main_template', $data );
		
	}
	
	function save() {
		
		if ($this->form_validation->run('roles') == FALSE) {
			
			$this->form();
			
		} else {
			
			$data = $_POST;
			
			if( $_POST['rid'] ) {
				
				$this->Roles->save($data, $_POST['rid']);
				
			}
			else {
				
				$this->Roles->save($data);
				
			}
			
			redirect('admin/roles','location');
			
		}
		
	}
	
	
	function delete() {
		
		$this->Roles->delete(  $this->uri->segment(4));
		
		redirect('admin/roles','location');
	}
	
	
}