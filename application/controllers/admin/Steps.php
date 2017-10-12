<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Steps extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->model('admin/Steps_Model','Steps');
		$this->load->model('Sandbox','Sandbox');
		$this->output->enable_profiler(TRUE);
	}
	
	function index() {
		$this->list();
	}
	
	function list() {
		$data['User'] = 79;
		
		$data['pending'] = $this->Sandbox->countRequisitions($data['User'], true );
		$data['processed'] = $this->Sandbox->countProcessedRequisitions($data['User'], true );
		$data['approved'] = $this->Sandbox->countapprovedRequisitions($data['User'], true );
		$data['Steps'] =$this->Steps->listAll();
		
		$data['content'] = 'admin/steps/index_v';
		
		$this->load->view('template/main_template',$data);
	}
	
	function form() {
		
		$step_id = 0;
		//echo $this->uri->segment(4);
		$data['step'] = "";
		$data['name'] = "";
		$data['is_academic'] = "";
		$data['is_finance'] = "";
		$data['enabled'] = "";
		$data['sid'] = ""; 
		
		if( $this->uri->segment(4) ) {
			
			$step_id = $this->uri->segment(4) ;
			
			$row = $this->Steps->getOne($step_id);
			
			$data['sid'] = $row[0]['id'];
			$data['step'] = $row[0]['step'];
			$data['name'] = $row[0]['name'];
			$data['is_academic'] = $row[0]['is_academic'];
			$data['is_finance'] = $row[0]['is_finance'];
			$data['enabled'] = $row[0]['is_enabled']; 
			
		}
		
		$data['content'] = 'admin/steps/form_v';
		
		$this->load->view('template/main_template',$data);
		
	}
	
	function save() {
		
		if ($this->form_validation->run('steps') == FALSE) {
			
			$this->form();
			
		} else {
			
			$data = $_POST;
			
			if( $this->input->post($this->uri->segment(4)) ) {
				
				$this->Steps->save($data, $_POST['sid']);
				
			}
			else {
				
				$this->Steps->save($data);
				
			} 
			
			redirect('admin/steps','location');
			
		}
		
		
	}
	
	
	
	function delete() {
		
		$this->Steps->delete(  $this->uri->segment(4) );
		
		redirect('admin/steps','location');
	}
	
	
	
}