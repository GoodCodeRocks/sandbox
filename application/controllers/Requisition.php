<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Requisition extends CI_Controller
{
	private $user_id =79;
	//put your code here
	public function __construct() {
		parent::__construct();
		$this->load->model('Requisition_Model','rm');
		$this->load->model('Sandbox','Sandbox');
		$this->output->enable_profiler(TRUE);
		
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
			//redirect('requisition/pending','location');
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
		
		$data['Requisitions'] = $this->Sandbox->getProcessedRequisitions($data['User'], true );
		$data['content'] = 'requisition/processed_requisitions_v';
		$this->load->view('template/main_template',$data);
	}

	public function approved() {

		//$this->load->view('users/my_requisition_v');
		$data['User'] = $this->user_id;
		
		$data['Requisitions'] = $this->Sandbox->getProcessedRequisitions($data['User'], true );
		$data['content'] = 'requisition/approved_requisitions_v';
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
	
	
	function detail($requisitionid = Null) {
		
		if($this->uri->segment(3) == NULL)
		{
			$data['info'] = $requisitionid;
		}
		else {
			$data['info'] = $this->uri->segment(3);
		}
		$data['content'] = 'requisition/requisition_details_v';
		
		/* Returns requisition info related to specified requisition */
		$data['details'] = $this->Sandbox->getRequisitionDetails($data['info']);
		$data['toProcess'] = $this->Sandbox->getrequisitionprocessingdetails($data['info']);
		$data['processedBy'] = $this->Sandbox->getrequisitionprocessdetails($data['info']);
		$data['Items'] = $this->Sandbox->getrequisitionitems($data['info']);
		$data['Category'] = $this->Sandbox->getcategory();
		$this->load->view('template/main_template',$data);
	}
	
	/* Add New Item to Requisition */
	public function add_Item() {
		
		$clean = $this->security->xss_clean($this->input->post(NULL, TRUE));
		$this->Sandbox->add_Item($clean);

		$this->detail($clean['requisitionid']);
		
	}
	
	/* Upload and assign Invoice to requisition */
	public function purchaseOrder_upload() {
		$path = base_url().'assets/uploads/';
		is_dir($path);
		is_writable($path);
		$config['upload_path'] = './assets/uploads/';
		$config['allowed_types'] = 'gif|jpg|png|pdf';
		
		
		$this->upload->initialize($config);
		if ( !$this->upload->do_upload('purord'))
		{
			$error = array('error' => $this->upload->display_errors());
		}
		else
		{
			$clean = $this->security->xss_clean($this->input->post(NULL, TRUE));
			$pOrder['file'] = $this->upload->data();
			$pOrder['requisitionid'] = $clean['requisitionid'];
			$this->Sandbox->insert_Invoice($pOrder);
			$this->detail();
		}
	}
	
	//File Download
	function download(){
		
		$id = $this->uri->segment(3);
		
		$data = $this->Sandbox->getPurchaseOrder($id);
		
		//var_dump($data);
		$path = $data[0]['file_path'];
		$contents = file_get_contents($path);
		$name = $data[0]['file_name'];
		
		force_download($path, $contents);
		
	}
	
}