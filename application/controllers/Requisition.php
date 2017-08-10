<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Requisition extends CI_Controller
{
	private $user_id = 79;
	//put your code here
	public function __construct() {
		parent::__construct();
		$this->load->model('Requisition_Model','rm');
		$this->load->model('Sandbox','Sandbox');
		
	}
	
	
	public function index() {
		$this->listall();
		
	}
	
	public function form() {
		
		
		$data['User'] = $this->user_id;
		$data['content'] = 'requisition/new_requisition_v';
		
		$data['RequisitionTypes'] = $this->Sandbox->getType();
		
		
		/* Returns all departments user is assigned */
		$data['Departments'] = $this->Sandbox->getUserDepartments($data['User']);
		
		$this->load->view('template/main_template',$data);
	}
	
	
	public function save() {
		
		if ($this->form_validation->run('requisition') == FALSE) {
			
			$this->form();
			
		} else {
			
			$data = $_POST;
			
			$this->Sandbox->save($data);
			
			redirect('requisition/pending','location');
			
		}
		
	}
	
	public function pending() {
		//$this->load->view('users/my_requisition_v');
		$data['User'] = $this->user_id;
		
		$data['UserRoles']= $this->Sandbox->getUserRoles($data['User']);
		$data['Requisitions'] = $this->Sandbox->getRequisitions($data['User']);
		$data['content'] = 'requisition/pending_requisitions_v';
		$this->load->view('template/main_template',$data);
	}
	
	public function processed() {
		//$this->load->view('users/my_requisition_v');
		$data['User'] = $this->user_id;
		
		$data['Requisitions'] = $this->Sandbox->getRequisitions($data['User'], true );
		$data['content'] = 'requisition/processed_requisitions_v';
		$this->load->view('template/main_template',$data);
	}
	
	function detail() {
		$data['content'] = 'requisition/requisition_details_v';
		$this->load->view('template/main_template',$data);
	}
	
	public function listall() {
		
		/*
		
		WHEN A REQUISITION IS CREATED IT HAS A STATUS OF 0 AND CAN BE VIEWED BY THE CREATOR - USER
		WHEN A REQUISITION IS SUBMITTED FOR APPROVAL ITS STATUS IS UPDATED TO 1 THUS ALLOWING USERS AT STAGE 2 TO VIEW
		WHEN IT IS APPROVED, IT WOULD THEN HAVE ITS STATUS UPATED TO 2 THUS ALLOWING USERS AT STAGE 2 TO VIEW THE PENDING REQUISITIONS -
		WHEN APPROVED AT STAGE 2 THE STATUS IS UPDATED TO 3 THUS ALLOWING USERS AT STAGE 3 ACCESS TO REQUISITION
		WHEN APPROVED AT STAGE 3 THE STATUS IS UPDATED TO 4
		WHEN APPROVED AT STAGE
		
		
		1. Listed requisitions are printed in two categories ( Unprocessed, Processed )
		2. Unprocessed requistions are those which have not yet been sent to the next step for vetting
		and approval
		3. Requisitions listed at each step is based on
		a ) The current step at which the requisition is pending
		b ) The user assigned to perform approvals
		c ) The creator of requisition and Finance are the only two places where requisitions
		that span multiple steps can be viewed
		Finance would be able to see all requisitions pending and approved
		
		*/
		
		/* Get all requisitions created by user and not yet submitted */
		//$data['create'] = $this->rm->getUserRequisitions();
		
		/* Get all requisitions submitted by user and not yet approved */
		//$data['view'] =  $this->rm->getRequisitions();
		
		/* Get all processed requisitions submitted by user */
		//$data['processed'] = $this->rm->userApprovedRequisition();
		
		/* Get all approved requisitions submitted by user */
		//$data['approved'] = $this->rm->getapprovedReqs();
		
		//$requisiton = $data['approved'][0]->RequisitionNo;
		
		
		
		$data['content'] = 'requisition/my_requisition_v';
		$this->load->view('template/main_template',$data);
	}
	
	
	
}