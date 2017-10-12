<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function __construct() {
			parent::__construct();
			$this->load->model('Sandbox','Sandbox');
			
	}

	public function index()
	{
		$data['User'] = 79;
				
		$data['pending'] = $this->Sandbox->countRequisitions($data['User'], true );
		$data['processed'] = $this->Sandbox->countProcessedRequisitions($data['User'], true );
		$data['approved'] = $this->Sandbox->countapprovedRequisitions($data['User'], true );
		$data['content'] = 'blank';
		$this->load->view('template/main_template',$data);
	}

	public function process() {
		
	}
	
	public function myRequisition() {
		//$this->load->view('users/my_requisition_v');
		$data['content'] = 'users/my_requisition_v';
		$this->load->view('template/main_template',$data);
	}
	public function pendingRequisition() {
		//$this->load->view('users/my_requisition_v');
		$data['content'] = 'users/pending_requisitions_v';
		$this->load->view('template/main_template',$data);
	}
	public function approvedRequisition() {
		//$this->load->view('users/my_requisition_v');
		$data['content'] = 'users/approved_requisitions_v';
		$this->load->view('template/main_template',$data);
	}
	public function processedRequisition() {
		//$this->load->view('users/my_requisition_v');
		$data['content'] = 'users/processed_requisitions_v';
		$this->load->view('template/main_template',$data);
	}
	
	public function newRequisition() {
		//$this->load->view('users/new_requisition_v');
		$data['content'] = 'users/new_requisition_v';
		$this->load->view('template/main_template',$data);
	}
	
	public function manageUsers(){
		$data['content'] = 'admin/manage_users_v';
		$this->load->view('template/main_template',$data);
	}
	
	public function manageDepartments(){
		$data['content'] = 'admin/manage_departments_v';
		$this->load->view('template/main_template',$data);
	}
	
	public function managePayees(){
		$data['User'] = 79;
		
		$data['pending'] = $this->Sandbox->countRequisitions($data['User'], true );
		$data['processed'] = $this->Sandbox->countProcessedRequisitions($data['User'], true );
		$data['approved'] = $this->Sandbox->countapprovedRequisitions($data['User'], true );
		$data['content'] = 'admin/manage_payees_v';
		$this->load->view('template/main_template',$data);
	}
	
	public function manageProcesses(){
		$data['User'] = 79;
		
		$data['pending'] = $this->Sandbox->countRequisitions($data['User'], true );
		$data['processed'] = $this->Sandbox->countProcessedRequisitions($data['User'], true );
		$data['approved'] = $this->Sandbox->countapprovedRequisitions($data['User'], true );
		$data['content'] = 'admin/manage_processes_v';
		$this->load->view('template/main_template',$data);
	}
	
	public function updateProcess(){
		$data['content'] = 'admin/update_process_v';
		$this->load->view('template/main_template',$data);
	}
	
	public function manageRoles(){
		$data['content'] = 'admin/manage_roles_v';
		$this->load->view('template/main_template',$data);
	}
	
	public function history(){
		$data['User'] = 79;
		
		$data['pending'] = $this->Sandbox->countRequisitions($data['User'], true );
		$data['processed'] = $this->Sandbox->countProcessedRequisitions($data['User'], true );
		$data['approved'] = $this->Sandbox->countapprovedRequisitions($data['User'], true );
		$data['content'] = 'users/history_v';
		$this->load->view('template/main_template',$data);
	}
	
	public function details(){
		$data['content'] = 'users/requisition_details_v';
		$this->load->view('template/main_template',$data);
	}
}
