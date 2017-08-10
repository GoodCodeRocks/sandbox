<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Requisition_ extends CI_Controller
{
    //put your code here
    public function __construct() {
        parent::__construct();
        $this->load->model('Requisition_Model','rm');
        $this->load->model('Sandox','Sandox');
        
        $this->load->helper(array('form','url','html','download'));
        $this->load->library('upload');
        //$this->output->enable_profiler(TRUE);
        /* Checks whether session is empty */
       /*  if(empty( $_SESSION['user'])) {
        	redirect('login');
        } */
        
    }
    
    public function index() {
        $this->listall();       
    }

    public function form() {
    	
    	$user = 67; //$_SESSION['id'];
    	
    	/* Returns the Requisition Types */
    	$data['type'] = $this->rm->getType();
    	
    	/* Returns the Payee Information */
    	$data['payee'] = $this->rm->getPayee();
    	
    	
    	/* Returns all departments user is assigned */
    	$data['Department'] = $this->rm->getDepartments($user);
    	
    	/* Returns all payment methods */
    	$data['payment'] = $this->rm->getPaymentMethod();
    	
    	$data['content'] = 'requisition/requisition_form';
        $this->load->view('main_template',$data);
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
    	$data['create'] = $this->rm->getUserRequisitions();
    	
    	/* Get all requisitions submitted by user and not yet approved */
    	$data['view'] =  $this->rm->getRequisitions();
    	
    	/* Get all processed requisitions submitted by user */
    	$data['processed'] = $this->rm->userApprovedRequisition();
    	
    	/* Get all approved requisitions submitted by user */
    	$data['approved'] = $this->rm->getapprovedReqs();
    	
    	//$requisiton = $data['approved'][0]->RequisitionNo;
    	
    	$data['content'] = 'requisition/my_requisition_v';
        $this->load->view('main_template',$data);
    }

    public function detail() {
    	/*
			1. Details of Specific Requisition is edited  
    	*/
    	
    	/* Returns the data for aspcified Requisition */
    	$data['detail'] =  $this->rm->getspecified_Req();
    	
    	/* Returns the Requisition Categories */
    	$data['category'] = $this->rm->getCategory();
    	
    	/* Returns running total of Requisition */
    	$data['total'] =$this->rm->requisition_Running_Total();
    	
    	/* Return Next Person to Approve */
    	$data['next'] = $this->rm-> getNextApproval();
    	
    	/* Return the number of items in requisition */
    	$data['Item_Count'] = $this->rm->count_Items();
    	
    	/* echo "<br><br><br><br>";
    	var_dump($_POST); */
    	$data['content'] = 'requisition/requisition_detail';
        $this->load->view('main_template',$data);
    }
    
    public function processedRequisitions() {
    	/*
    	 1. Details of Specific Requisition is edited
    	 */
    	
    	/* Returns the data for aspcified Requisition */
    	$data['process'] =  $this->rm->approvedRequisitions();
    	   	    	
    	/* echo "<br><br><br><br>";
    	 var_dump($_POST); */
    	$data['content'] = 'requisition/requisitions_processed';
    	$this->load->view('main_template',$data);
    }
    
    public function process() {
    	/* Send Email to requisiting person identifying that requisition has been processed and awaiting payment collection */
    	$info = $this->rm->isprocessed();
    	

    		
    		//$clean = $this->security->xss_clean($email);
    		
    		//$url = base_url() . 'index.php/main/reset_password/';
    		//$link = '<a href="' . $url . '">' . $url . '</a>';
    		
    		$message = "";
    		$message .= "Dear Mr/Mrs/Ms ".$info[0]['LastName']."\n\n";
    		$message .= 'Your Requisition has been approved and is ready for collection at the Finance Office'."\n";
    		$message .= 'Your Requisition Number: ' .$info[0]['RequisitionNo']."\n";
    		$message .= "\n\n\n".'Regards,'."\n" .'Finance Office';
    		echo 'A message has been sent to ' .$info[0]['Email']  ."\n";
    		
    		require_once 'C:\xampp\htdocs\swiftmailer\lib\swift_required.php';
    		$transport = Swift_SmtpTransport::newInstance('smtp.gmail.com', 465,'ssl')
    		->setUsername('edwardsn@usc.edu.tt')
    		->setPassword('D1amonds4u');
    		
    		$mailer = $this->mailer = Swift_Mailer::newInstance($transport);
    		$mess = Swift_Message::newInstance('Requisition '.$info[0]['RequisitionNo'].' Processed')
    		->setFrom(array('edwardsn@usc.edu.tt'=>'Niall Edwards'))
    		->setTo(array($info->Email => $info->Email))
    		//->setTo(array('edwardsn@usc.edu.tt' => 'Niall Edwards'))
    		->setBody($message);
    		
    		$result = $mailer->send($mess);
    		//redirect(base_url().'index.php/main/index');

    	$this->processedRequisitions();
    }

    public function save() {

    	/* 1. 	When a requisition is saved redirect to the list of requisitions 
                ie filtered by user_id and where required by department_id )
	   2. 	
    	*/
    	
        if ($this->form_validation->run('requisition') == FALSE) {
            
            $this->form();
           
        } else {
            
            /* Generates Requisition Number for new requisition */
            $data['req_num'] = $this->req_num();
            $data['id'] = $_SESSION['id'];
            $data['stage'] = $_SESSION['aID'];
            $clean = $this->security->xss_clean($this->input->post(NULL, TRUE));
            $this->rm->create_req($clean, $data);
            $req_number = $data['req_num'];
            $success_message = "<div class='alert alert-success'> <strong>Success!</strong> A new requisition was created with ID $req_number </div>";
            
            $this->session->set_flashdata('new_record_added', $success_message);
            $this->listall();
            
        }

    
    }
    
    /* Add New Item to Requisition */
    public function add_Item() {
    	
    	$clean = $this->security->xss_clean($this->input->post(NULL, TRUE));
    	$this->rm->add_Item($clean);
    	
    	/* Returns the data for aspcified Requisition */
    	$data['detail'] =  $this->rm->getspecified_Req();
    	
    	/* Returns the Requisition Categories */
    	$data['category'] = $this->rm->getCategory();
    	
    	/* Returns running total of Requisition */
    	$data['total'] =$this->rm->requisition_Running_Total();
    	
    	/* Return Next Person to Approve */
    	$data['next'] = $this->rm-> getNextApproval();
    	
    	$this->detail();
    	//$data['content'] = 'requisition/requisition_detail';
    	//$this->load->view('main_template',$data);
    
    }
    
    /* Remove New Item to Requisition */
    public function remove_Item() {
    	
    	//$clean = $this->security->xss_clean($this->input->post(NULL, TRUE));
    	$this->rm->remove_Item();
    	
    	/* Returns the data for aspcified Requisition */
    	$data['detail'] =  $this->rm->getspecified_Req();
    	
    	/* Returns the Requisition Categories */
    	$data['category'] = $this->rm->getCategory();
    	
    	/* Returns running total of Requisition */
    	$data['total'] =$this->rm->requisition_Running_Total();
    	
    	/* Return Next Person to Approve */
    	$data['next'] = $this->rm-> getNextApproval();
    	
    	$this->detail();
    	//$data['content'] = 'requisition/requisition_detail';
    	//$this->load->view('main_template',$data);
    	
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
    		//$this->detail();
    		//echo $error;
    		//var_dump($purord);
    	}
    	else
    	{
    		$clean = $this->security->xss_clean($this->input->post(NULL, TRUE));
    		$pOrder = $this->upload->data();
    		$this->rm->insert_Invoice($pOrder);
    		$this->detail();
    	}
    }
    
    public function page() {
    	$data['content'] = 'requisition/page';
    	$this->load->view('main_template',$data);
    }
    
    public function history() {
    	$data['history'] = $this->rm->getReqHistory();
    	
    	$data['content'] = 'requisition/requisition_history';
    	$this->load->view('main_template',$data);
    }
    
    /* Method Generates random requisition number for each new Requisition */
    private function req_num() {
    	
    	$pool = array_merge(range(0,9), range('a', 'z'),range('A', 'Z'));
    	$length = 6;
    	$key = "";
    	date_default_timezone_set ( "America/La_Paz" );
    	
    	for($i=0; $i < $length; $i++) {
    		$key .= $pool[mt_rand(0, count($pool) - 1)];
    	}
    	$date = date('Ymd-his');
    	$req_num = $date."-".$key;
    	return $req_num;
    }
    
    /* Process rrequisition */
    public function processRequisition() {
    	
    	$req = $this->uri->segment(3);
    	$approval = $this->uri->segment(4);
    	/* If value returned from requision is 1 then ensure user has rights to process requisition 
    	 * Check if any items has been added to requisition in question
    	 * approve requisition and sent to next stage.
    	 * 
    	 *  If value returned from requisition is 0 return requisition to Sender identifying reason for Denying requisition.*
    	 */
    	$clean = $this->security->xss_clean($this->input->post(NULL, TRUE));
    	$data['approvedBy'] = $_SESSION['user'];
    	$data['RequisitionNo'] = $clean['RequisitionNo'];
    	$data['accessId'] = $_SESSION['aID'];
    	$data['ID'] = $_SESSION['id'];
    	$number = $this->rm->get_requisition_stage($data);
    	$number = $number['0']['Stage'];
    	$NoItems = $this->rm->count_Items($data['RequisitionNo']);
    	
    	if($data['accessId'] >= $number && $NoItems[0]['NoItems'] > 0){
	    	if ($clean['process'] == 'approve') {
	    		
	    		$this->rm->approve($data);
	    	}
	    	
	    	if($clean['process'] =='deny') {
	    		$this->rm->deny($data);
	    	}
	    	
	    	if($clean['process'] =='return') {
	    		$this->rm->returnReq($data);
	    	}
    	} else 
    		{
	    		if ($NoItems[0]['NoItems'] == 0){
	    			echo "<h5>You cannot process a requisition without items</h5>";
	    		}else{
	    				echo "<h5>You are not authorized to carry out this function " . $_SESSION['user']."</h5>";
	    			}
    	}
    	$this->listall();
    	   
    }
    
    //File Download
    function download(){
    	
    	$id = $this->uri->segment(3);
    	
    	$data = $this->rm->getrows($id);
    	
    	
    	$path = base_url().'assets/uploads/'.$data[0]->FileName;
    	$contents = file_get_contents($path);
    	$name = $data[0]->FileName;
    	
    	force_download($path, $contents);
    	
    }
    
    
}
