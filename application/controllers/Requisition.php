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
		
		$data['pending'] = $this->Sandbox->countRequisitions($data['User'], true );
		$data['processed'] = $this->Sandbox->countProcessedRequisitions($data['User'], true );
		$data['approved'] = $this->Sandbox->countapprovedRequisitions($data['User'], true );
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
		
		$data['pending'] = $this->Sandbox->countRequisitions($data['User'], true );
		$data['processed'] = $this->Sandbox->countProcessedRequisitions($data['User'], true );
		$data['approved'] = $this->Sandbox->countapprovedRequisitions($data['User'], true );
		
		$data['UserRoles']= $this->Sandbox->getUserRoles($data['User']);
		$data['Requisitions'] = $this->Sandbox->getRequisitions($data['User']);
		$data['content'] = 'requisition/pending_requisitions_v';
		$this->load->view('template/main_template',$data);
	}
	
	public function processed() {
		//$this->load->view('users/my_requisition_v');
		$data['User'] = $this->user_id;
		
		$data['pending'] = $this->Sandbox->countRequisitions($data['User'], true );
		$data['processed'] = $this->Sandbox->countProcessedRequisitions($data['User'], true );
		$data['approved'] = $this->Sandbox->countapprovedRequisitions($data['User'], true );
		
		$data['Requisitions'] = $this->Sandbox->getProcessedRequisitions($data['User'], true );
		$data['content'] = 'requisition/processed_requisitions_v';
		$this->load->view('template/main_template',$data);
	}

	public function approve() {
		
		$data['User'] = $this->user_id;
		
		$data['pending'] = $this->Sandbox->countRequisitions($data['User'], true );
		$data['processed'] = $this->Sandbox->countProcessedRequisitions($data['User'], true );
		$data['approved'] = $this->Sandbox->countapprovedRequisitions($data['User'], true );
		$requisition_id = $_POST['req_id'];
		$this->Sandbox->approveRequisition($data['User'], $requisition_id);
		$this->detail($requisition_id);
		
	}
	
	public function approved() {

		//$this->load->view('users/my_requisition_v');
		$data['User'] = $this->user_id;
		
		$data['pending'] = $this->Sandbox->countRequisitions($data['User'], true );
		$data['processed'] = $this->Sandbox->countProcessedRequisitions($data['User'], true );
		$data['approved'] = $this->Sandbox->countapprovedRequisitions($data['User'], true );
		$data['Requisitions'] = $this->Sandbox->getProcessedRequisitions($data['User'], true );
		$data['content'] = 'requisition/approved_requisitions_v';
		$this->load->view('template/main_template',$data);
	}
	
	public function listall() {
		
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
		$data['User'] = $this->user_id;
		
		$data['pending'] = $this->Sandbox->countRequisitions($data['User'], true );
		$data['processed'] = $this->Sandbox->countProcessedRequisitions($data['User'], true );
		$data['approved'] = $this->Sandbox->countapprovedRequisitions($data['User'], true );
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
		
		$path = $data[0]['file_path'];
		$contents = file_get_contents($path);
		$name = $data[0]['file_name'];
		
		force_download($name, $contents);
		
	}
	
	//finance Module
	function finance(){
		//$this->load->view('users/my_requisition_v');
		$data['User'] = $this->user_id;
		
		$data['pending'] = $this->Sandbox->countRequisitions($data['User'], true );
		$data['processed'] = $this->Sandbox->countProcessedRequisitions($data['User'], true );
		$data['approved'] = $this->Sandbox->countapprovedRequisitions($data['User'], true );
		$data['UserRoles']= $this->Sandbox->getUserRoles($data['User']);
		$data['Requisitions'] = $this->Sandbox->getProcessedRequisitions($data['User']);
		$data['content'] = 'requisition/finance_pending_requisitions_v';
		$this->load->view('template/main_template',$data);
	}
	
	function finance_detail($requisitionid = Null) {
		
		if($this->uri->segment(3) == NULL)
		{
			$data['info'] = $requisitionid;
		}
		else {
			$data['info'] = $this->uri->segment(3);
		}
		$data['content'] = 'requisition/finance_v';
		
		$data['User'] = $this->user_id;
		
		$data['pending'] = $this->Sandbox->countRequisitions($data['User'], true );
		$data['processed'] = $this->Sandbox->countProcessedRequisitions($data['User'], true );
		$data['approved'] = $this->Sandbox->countapprovedRequisitions($data['User'], true );
		
		/* Returns requisition info related to specified requisition */
		$data['details'] = $this->Sandbox->getRequisitionDetails($data['info']);
		$data['toProcess'] = $this->Sandbox->getrequisitionprocessingdetails($data['info']);
		$data['processedBy'] = $this->Sandbox->getrequisitionprocessdetails($data['info']);
		$data['approvedBy'] = $this->Sandbox->getrequisitionapprovaldetails($data['info']);
		$data['Items'] = $this->Sandbox->getrequisitionitems($data['info']);
		$data['Category'] = $this->Sandbox->getcategory();
		$this->load->view('template/main_template',$data);
	}
	
	function print() {
		$data['User'] = 79;
		
		$data['pending'] = $this->Sandbox->countRequisitions($data['User'], true );
		$data['processed'] = $this->Sandbox->countProcessedRequisitions($data['User'], true );
		$data['approved'] = $this->Sandbox->countapprovedRequisitions($data['User'], true );
		$data['content'] = 'requisition/my_requisition_v';
		
		$this->load->view('template/main_template',$data);
	}
	
/* 	public function reqnumber(){
		
		$req_num = $this->req_num();
		$date = strtok($req_num, '-');
		$break = explode("-", $req_num, 3);
		echo $break[0]."/".$break[1]."/".$break[2];
	} */
}