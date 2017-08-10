<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Requisition
 *
 * @author Niall Edwards
 */

 class Requisition_Model extends CI_Model {
 	
 	/**
 	 * Returns list of item categories for purchase ...
 	 */
 	
 	//return list of Suppliers
 	function getusers(){
 			
 		$sql = "";
 		$sql .="select ID, UserName from users";
 			
 		return $this->db->query($sql)->result();
 	}
 	
 	//return requisition categories
 	function getCategory() {
 		
 		$sql = "";
 		$sql .="select * from category";
 		
 		return $this->db->query($sql)->result();

 	}
 	
 	//return list of Suppliers
 	function getSupplier(){
 		
 		$sql = "";
 		$sql .="select * from supplier";
 		
 		return $this->db->query($sql)->result();
 	}
 	
 	//return list of Departments
 	function getDepartments($user){
 		
 		//$user = $_SESSION['id'];	
 		$sql = "";
 		$sql .="select distinct dept.*
					from departments dept
						join users_departments ud on ud.departments_ID = dept.ID
					where ud.departments_ID = dept.ID and ud.users_ID = '".$user."' ";
 			
 		return $this->db->query($sql)->result_array();
 	}
 	
 	//return list of Payees
 	function getPayee(){
 			
 		$sql = "";
 		$sql .="select * from payee";
 			
 		return $this->db->query($sql)->result();
 	}
 	
 	//return list of payment methods
 	function getPaymentMethod(){
 		
 		$sql = "";
 		$sql .="select * from payment_method";
 		
 		return $this->db->query($sql)->result();
 	}
 	
 	//return all requisition Types
 	function getType(){
 	
 		$sql = "";
 		$sql .="select * from requisition_type";
 	
 		return $this->db->query($sql)->result();
 	}
 	
 	//return all requisition Items for specified Requisition
 	function get_Requisition_Items($requisitionNo){
 		//requisitionIDD = $ID->ID;
 		$sql = "";
 		$sql .="select ri.*, c.CategoryName
				from requisition_items ri
				join category c on c.ID = ri.category_ID
				where RequisitionNo ='".$requisitionNo."'";
 		
 		return $this->db->query($sql)->result();
 	}
 	
 	//return all pending requisitions
 	function getRequisitions(){
 		//$dept = $_SESSION['department'];
 		$user = $_SESSION['id'];
 		$access = $_SESSION['aID'];
 		$sql ="";
 		$sql .="select r.Create_time, r.RequisitionNo, r.Payee, r.DeptApprovedBy
 				, r.FinanceApprovalBy, r.departments_ID, d.DepartmentName, r.users_ID
 				, r.Requisition_Types_ID, rt.TypeName, urs.ReqStat_ID, u.FirstName, u.LastName
				, pm.payment_method, num.numItems, tot.RequisitionValue
 				from requisition r
 				join users u on u.ID = r.users_ID
 				join users_requisition_status urs on urs.Requisition_ID = r.ID
				join departments d on d.ID = r.departments_ID
				join requisition_types rt on rt.ID = r.Requisition_Types_ID
				join requisition_payment_method rpm on rpm.requisition_ID = r.ID
				join payment_method pm on pm.payment_method_ID = rpm.payment_method_ID
				left join (
					select r.ID, r.RequisitionNo, sum(ri.Total_Cost) as RequisitionValue
					from requisition_items ri
					join requisition r on r.ID = ri.Requisition_ID
					group by r.RequisitionNo
				) tot on tot.RequisitionNo = r.RequisitionNo
				left join (
					select r.ID, r.RequisitionNo, count(r.RequisitionNo) as numItems
			        from requisition_items ri
			        join requisition r on r.ID = ri.Requisition_ID
			        group by r.RequisitionNo
				) num on num.RequisitionNo = r.RequisitionNo
 				where (urs.ReqStat_ID = '2' or urs.ReqStat_ID = '5')";
 		if($access == 1)
 		{
 			$sql .="  and r.users_ID = '".$user."' and r.Stage = 1";
 		}
 		if($access > 1 && $access < 4)
 		{
 			$sql .="  and r.Stage = ".$access."-1";
 		} 
 		return $this->db->query($sql)->result();
 	}
 	
 	/* Return Requisition approved by user */
 	function userApprovedRequisition(){
 		$user = $_SESSION['user'];
 		$access = $_SESSION['aID'];
 		$sql ="";
 		$sql .="select r.Create_time, r.RequisitionNo, r.Payee, r.DeptApprovedBy, r.Stage
		 		, r.FinanceApprovalBy, r.departments_ID, d.DepartmentName, r.users_ID
		 		, r.Requisition_Types_ID, rt.TypeName, urs.ReqStat_ID, u.FirstName, u.LastName
		 		, pm.payment_method, num.numItems, tot.RequisitionValue, rs.StatusName
		 		from requisition r
		 		join users u on u.ID = r.users_ID
		 		join users_requisition_status urs on urs.Requisition_ID = r.ID
				join requisition_status rs on rs.ID = urs.ReqStat_ID
		 		join departments d on d.ID = r.departments_ID
		 		join requisition_types rt on rt.ID = r.Requisition_Types_ID
		 		join requisition_payment_method rpm on rpm.requisition_ID = r.ID
		 		join payment_method pm on pm.payment_method_ID = rpm.payment_method_ID
		 		left join (
		 				select r.ID, r.RequisitionNo, sum(ri.Total_Cost) as RequisitionValue
		 				from requisition_items ri
		 				join requisition r on r.ID = ri.Requisition_ID
		 				group by r.RequisitionNo
 				) tot on tot.RequisitionNo = r.RequisitionNo
 				left join (
 						select r.ID, r.RequisitionNo, count(r.RequisitionNo) as numItems
 						from requisition_items ri
 						join requisition r on r.ID = ri.Requisition_ID
 						group by r.RequisitionNo
 						) num on num.RequisitionNo = r.RequisitionNo
		 		where (urs.ReqStat_ID ='2' or urs.ReqStat_ID = '3')";
 		if($access == 1)
 		{
 			$sql .=" and r.Stage > ".$access."";
 		} else {

 		$sql .=" and r.Stage > '".$access."' and r.ChairApprovedBy = '".$user."' or r.DeptApprovedBy = '".$user."' or r.VPApproval = '".$user."' or r.FinanceApprovalBy = '".$user."'";
 		}
 		return $this->db->query($sql)->result();
 								
 	}
 	
 /* Count requisitions awaiting approval */
 	function requisition_count(){
 		//$dept = $_SESSION['department'];
 		$user = $_SESSION['id'];
 		$access = $_SESSION['aID'];
 		$sql ="";
 		$sql .="select count(r.RequisitionNo) as requisitions_waiting
 				from requisition r
 				join users u on u.ID = r.users_ID
 				join users_requisition_status urs on urs.Requisition_ID = r.ID
				join departments d on d.ID = r.departments_ID
				join requisition_types rt on rt.ID = r.Requisition_Types_ID
				join requisition_payment_method rpm on rpm.requisition_ID = r.ID
				join payment_method pm on pm.payment_method_ID = rpm.payment_method_ID
				left join (
					select r.ID, r.RequisitionNo, sum(ri.Total_Cost) as RequisitionValue
					from requisition_items ri
					join requisition r on r.ID = ri.Requisition_ID
					group by r.RequisitionNo
				) tot on tot.RequisitionNo = r.RequisitionNo
				left join (
					select r.ID, r.RequisitionNo, count(r.RequisitionNo) as numItems
			        from requisition_items ri
			        join requisition r on r.ID = ri.Requisition_ID
			        group by r.RequisitionNo
				) num on num.RequisitionNo = r.RequisitionNo
 				where urs.ReqStat_ID = '2' and r.Stage <> '0'";
 		/* 	if($user = 5)
 		 {
 		 $sql .=" and r.Stage = '".$access."'";
 		 }  */
 		if($access < 4)
 		{
 			$sql .="  and r.users_ID = '".$user."' and r.Stage = '".$access."'";
 		}
 		return $this->db->query($sql)->result();
 	}
 	
 	/* Count requisitions approved by user */
 	function requisition_approval_count(){
 		$user = $_SESSION['user'];
 		
 		$sql ="";
 		$sql .="select count(r.RequisitionNo) as Requisitions_Approved
 				from requisition r
 				join users u on u.ID = r.users_ID
 				join users_requisition_status urs on urs.Requisition_ID = r.ID
				join departments d on d.ID = r.departments_ID
				join requisition_types rt on rt.ID = r.Requisition_Types_ID
				join requisition_payment_method rpm on rpm.requisition_ID = r.ID
				join payment_method pm on pm.payment_method_ID = rpm.payment_method_ID
				left join (
					select r.ID, r.RequisitionNo, sum(ri.Total_Cost) as RequisitionValue
					from requisition_items ri
					join requisition r on r.ID = ri.Requisition_ID
					group by r.RequisitionNo
				) tot on tot.RequisitionNo = r.RequisitionNo
				left join (
					select r.ID, r.RequisitionNo, count(r.RequisitionNo) as numItems
			        from requisition_items ri
			        join requisition r on r.ID = ri.Requisition_ID
			        group by r.RequisitionNo
				) num on num.RequisitionNo = r.RequisitionNo
 				where r.ChairApprovedBy = '".$user."' or r.DeptApprovedBy = '".$user."'
				 or r.VPApproval = '".$user."' or r.FinanceApprovalBy = '".$user."'";
 		return $this->db->query($sql)->result();
 	}
 	
 /* return all pending requisitions that has not yet been submitted */
 	function getUserRequisitions($user = null){
 		//$dept = $_SESSION['department'];
 		//$user = $_SESSION['id'];
 		//$access = $_SESSION['aID'];
 		$sql ="";
 		$sql .="select r.Create_time, r.RequisitionNo, r.Payee, r.DeptApprovedBy
 				, r.FinanceApprovalBy, r.departments_ID, d.DepartmentName, r.users_ID
 				, r.Requisition_Types_ID, rt.TypeName, urs.ReqStat_ID, u.FirstName, u.LastName
				, pm.payment_method, num.numItems, tot.RequisitionValue
 				from requisition r
 				join users u on u.ID = r.users_ID
 				join users_requisition_status urs on urs.Requisition_ID = r.ID
				join departments d on d.ID = r.departments_ID
				join requisition_types rt on rt.ID = r.Requisition_Types_ID
				join requisition_payment_method rpm on rpm.requisition_ID = r.ID
				join payment_method pm on pm.payment_method_ID = rpm.payment_method_ID
				left join (
					select r.ID, r.RequisitionNo, sum(ri.Total_Cost) as RequisitionValue
					from requisition_items ri
					join requisition r on r.ID = ri.Requisition_ID
					group by r.RequisitionNo
				) tot on tot.RequisitionNo = r.RequisitionNo
				left join (
					select r.ID, r.RequisitionNo, count(r.RequisitionNo) as numItems
			        from requisition_items ri
			        join requisition r on r.ID = ri.Requisition_ID
			        group by r.RequisitionNo
				) num on num.RequisitionNo = r.RequisitionNo
 				where (urs.ReqStat_ID = '2' or urs.ReqStat_ID = '5') and r.Stage = '0' and r.users_ID = '".$user."'";

 		/* if($user < 4)
 		{
 			$sql .="  and r.users_ID = '".$user."' or r.Stage = '".$access."'";
 		} */
 		return $this->db->query($sql)->result();
 	}
 	
 	
 	//return all pending requisitions
 	function getReqs(){
 		$user = $_SESSION['id'];
 		$sql ="";
 		$sql .="select r.Create_time, r.RequisitionNo, r.Payee, r.DeptApprovedBy
 				, r.FinanceApprovalBy, r.departments_ID, r.users_ID
 				, r.Requisition_Types_ID, urs.ReqStat_ID, u.FirstName, u.LastName
 				from requisition r
 				join users u on u.ID = r.users_ID
 				join users_requisition_status urs on urs.Requisition_ID = r.ID
 				where urs.ReqStat_ID = '2' and r.users_ID = '".$user." ' ";
 		return $this->db->query($sql)->result();
 	}
 	
 	
 	//return history of Requisitions by Departments
 	function getReqHistory(){
 		$user = $_SESSION['id'];
 		$department = $_SESSION['department'];
 		$sql ="";
 		$sql .="select r.Create_time, r.RequisitionNo, r.Payee, r.DeptApprovedBy
 				, r.FinanceApprovalBy, r.departments_ID, r.users_ID
 				, r.Requisition_Types_ID, urs.ReqStat_ID, u.FirstName, u.LastName
				, d.DepartmentName, rt.TypeName, num.numItems, tot.RequisitionValue
				, pm.payment_method, rs.StatusName
 				from requisition r
 				join users u on u.ID = r.users_ID
 				join users_requisition_status urs on urs.Requisition_ID = r.ID
				join requisition_status rs on rs.ID = urs.ReqStat_ID
				join departments d on d.ID = r.departments_ID
				join requisition_types rt on rt.ID = r.Requisition_Types_ID
				left join (
					select r.ID, r.RequisitionNo, count(r.RequisitionNo) as numItems
			        from requisition_items ri
			        join requisition r on r.ID = ri.Requisition_ID
			        group by r.RequisitionNo
				) num on num.RequisitionNo = r.RequisitionNo
				left join (
					select r.ID, r.RequisitionNo, sum(ri.Total_Cost) as RequisitionValue
					from requisition_items ri
					join requisition r on r.ID = ri.Requisition_ID
					group by r.RequisitionNo
				) tot on tot.RequisitionNo = r.RequisitionNo
				join requisition_payment_method rpm on rpm.requisition_ID = r.ID
				join payment_method pm on pm.payment_method_ID = rpm.payment_method_ID
 				where r.departments_ID = '".$department."' ";
 		return $this->db->query($sql)->result();
 	}
 	
 	//return all pending requisitions for approval
 	function getpendingReqs(){
 		//$user = $_SESSION['id'];
 		$aID = $_SESSION['aID'];
 		$sql ="";
 		$sql .="select r.ID, r.Create_time, r.RequisitionNo, r.Payee, r.DeptApprovedBy
 				, r.FinanceApprovalBy, r.departments_ID, r.users_ID 
 				, r.Requisition_Types_ID, urs.ReqStat_ID, u.FirstName, u.LastName, tot.RequisitionValue
 				from requisition r
 				join users u on u.ID = r.users_ID
 				join users_requisition_status urs on urs.Requisition_ID = r.ID
				join (
					select r.ID, r.RequisitionNo, sum(ri.Total_Cost) as RequisitionValue
					from requisition_items ri
					join requisition r on r.ID = ri.Requisition_ID
					group by r.RequisitionNo
				) tot on tot.RequisitionNo = r.RequisitionNo
 				where urs.ReqStat_ID = '2' and r.stage = '".$aID."' ";
 		return $this->db->query($sql)->result();
 	}
 	
 	//return all processing requisitions
 	function getapprovedReqs(){
 		$dept = $_SESSION['department'];
 		$user = $_SESSION['id'];
 		$sql ="";
 		$sql .="select r.RequisitionNo, r.Create_time, r.Stage, sum(tot.Total_Cost) as RequisitionValue
					, count(r.RequisitionNo) as numItems, u.FirstName, u.LastName
					, d.DepartmentName, rs.StatusName, rt.TypeName, urs.isProcessed
					from requisition r
					left join users u on u.ID = r.users_ID
					left join users_requisition_status urs on urs.Requisition_ID = r.ID
					left join departments d on d.ID = r.departments_ID
					left join requisition_types rt on rt.ID = r.Requisition_Types_ID
					left join requisition_status rs on rs.ID = urs.ReqStat_ID
					join (select ri.Total_Cost, ri.Requisition_ID
						from requisition_items ri
						join requisition r on r.ID = ri.Requisition_ID
				        )tot on tot.Requisition_ID = r.ID
				where r.users_ID = '".$user."' and urs.ReqStat_ID = '1'
				group by r.RequisitionNo";
 		return $this->db->query($sql)->result();
 		
 	}
 	
 	/* Return the total sum of all the requisitions */
 	function returnTotal(){
 		$sql ="";
 		$sql .="select r.ID, r.RequisitionNo, sum(ri.Total_Cost) as Final
        from requisition_items ri
        join requisition r on r.ID = ri.Requisition_ID
        group by r.RequisitionNo";
 	}
 	
 	
 	function getdeniedReqs(){
 		//$dept = $_SESSION['department'];
 		$user = $_SESSION['id'];
 		$sql ="";
 		$sql .="select *
 				from requisition r
 				join users u on u.ID = r.users_ID
 				join users_requisition_status urs on urs.Requisition_ID = r.ID
 				where urs.ReqStat_ID = '3' and r.users_ID = '".$user." '
 				LIMIT 2";
 		return $this->db->query($sql)->result();
 	}
 	
 	//Get Specified Requisition Information 
 	function getspecified_Req(){
 		$reqNo = $this->uri->segment(3);
 		//echo $reqNo;
 		$clean = $this->security->xss_clean($reqNo);
 		//$sr = $clean;
 		//$requisition_id = $this->get_requisition_id($clean);
 		$sql ="";
 		$sql .="SELECT r.*
					, d.DepartmentName, rt.TypeName, u.FirstName, u.LastName, p.Payeecol, d.DepartmentName
					, po.FileName, po.ID as poid, po.FilePath
				FROM requisition r
				left join requisition_types rt on rt.ID = r.Requisition_Types_ID
				left join departments d on d.ID = r.departments_ID				
				left join users u on u.ID = r.users_ID
				left join payee p on p.ID = r.Payee
				left join requisition_purchase_order rpo on rpo.Requisition_ID = r.ID
				left join purchase_order po on po.ID = rpo.Purchase_Order_ID
				WHERE r.RequisitionNo ='".$clean."' limit 1";
 		return $this->db->query($sql)->result_array();
 	}
 	
 	/* Get next person waiting to Approve Requisition */
 	function getNextApproval(){
 		
 		// using the reqsuisitionNo and current stage we derive the following
 		// department name associated with requisition
 		$req = $this->uri->segment(3);
 		$user = $_SESSION['id'];
 		
 		// get department name associated with requisition
 		$dept = $this->getDepartments($user);
 		$department = $dept[0]['DepartmentName'];
 		
 		// get current stage of requisition
 		$stage = $this->get_stage($req);
 		
 		// set the next stage for current requisition ( current stage + 1 ) 
 		$access = $stage[0]['Stage']+1;
 		
 		// get user that's assigned to approve requisition at the next stage
 		$sql ="";
 		$sql .="select u.*, d.DepartmentName
					from users u
					left join users_access ua on ua.users_ID = u.ID
					left join users_departments ud on ud.users_ID = u.ID
					left join departments d on d.ID = ud.departments_ID
					where u.Status ='1' and ua.access_ID ='".$access."' ";
 		if($access < 4) {
 			// limit requisitions based on department if stage is less than 4
			$sql .= "and d.DepartmentName ='".$department."' ";
 		}
 		$sql .=" limit 1";
 		
 		return $this->db->query($sql)->result_array();
 		
 	}
 	
 	//get ID linked to requisition Number
 	private function get_requisition_id($num){
 		$sql ="";
 		$sql .="select ID from requisition where RequisitionNo ='".$num."'";
 		return $this->db->query($sql)->result();
 	}
 	
 	// get stage of requisition
 	private function get_stage($num){
 		// get current stage of requisition
 		$stage="select r.Stage
					from requisition r
					left join departments d on d.ID = r.departments_ID
					where r.RequisitionNo ='".$num."'";
 		return $this->db->query($stage)->result_array();
 	}
 	
 	//get File name row from server
 	function getrows($id){
 		$sql ="";
 		$sql .="Select * 
 				from purchase_order
 				where ID ='".$id." '";
 		return $this->db->query($sql)->result();
 	}
 	
 	
 	//create new requisition
 	
 	function create_req($clean, $data){
 		
 		$dept = $clean['department'];
 		$sql ="";
 		$sql .="select Department_Type_ID
			 		from departments
					where ID = '".$dept."' ";
 		$department_type = $this->db->query($sql)->result();
 		$stage = 0;
 		$auto_approve = "";
 		
 		$date = date('y-m-d G:i:s');
 		
 		// Insert initial requisition data into requisition table
 		$req = array(
 				'RequisitionNo' => $data['req_num'],
 				'Create_time' => $date,
 				'Payee'=>$clean['payee'],
 				'Stage'=>$stage,
 				'ChairApprovedBy'=>$auto_approve,
 				'departments_ID'=>$clean['department'],
 				'users_ID'=>$data['id'],
 				
 				'Requisition_Types_ID'=>$clean['requisition_type']
 				);
 		
 		$q = $this->db->insert_string('requisition',$req);
 		$this->db->query($q);
 		$req_ID = $this->db->insert_id(); //return inserted Requisition Table row id
 		
 		//Insert data link into users_requisition_status Table
 		$userreqStat =array(
 				'Modified_Time'=> $date,
 				'ReqStat_ID'=>'2',
 				'Requisition_ID'=>$req_ID,
 				'RequisitionNo'=> $data['req_num'],
 				'ModifiedBy'=>$data['id']
 					
 					
 		);
 		
 		$urs = $this->db->insert_string('users_requisition_status',$userreqStat);
 		$this->db->query($urs);
 		
 		/* Insert link to payment methods  */
 		$reqpaymethod = array(
 				'payment_method_ID'=>$clean['payment'],
 				'requisition_ID'=>$req_ID,
 				'insert_time'=> $date
 		);
 		
 		$rpm = $this->db->insert_string('requisition_payment_method',$reqpaymethod);
 		$this->db->query($rpm);
 		
 	}
 	
 	/* Add Item to Requisition */
 	
 	function add_Item($clean)
 	{
 		//Insert list of requisition items into Items Table
 		$date = date('y-m-d G:i:s');
 		$req_item =array(
 				'Description'=>$clean['Description'],
 				'Create_time'=> $date,
 				'UnitCost'=>$clean['Unit_Cost'],
 				'Quantity'=>$clean['Quantity'],
 				'Total_Cost'=>$clean['Total_Cost'],
 				'category_ID'=>$clean['Category'],
 				'Requisition_ID'=>$clean['id'],
 				'RequisitionNo'=>$clean['RequisitionNo'],
 				/* 'Supplier_ID'=>$clean['supplier'], */
 		);
 		$r = $this->db->insert_string('requisition_items',$req_item);
 		$this->db->query($r);
 		
 	}
 	
 	
 	/* Count the number of items in Requisition */
 	function count_Items()
 	{
 		$requisitionNo = $this->uri->segment(3);
 		$sql = "";
 		$sql .="select count(ri.ID) as NoItems
				from requisition_items ri
				where RequisitionNo ='".$requisitionNo."'";
 		
 		return $this->db->query($sql)->result_array();
 	}
 	
 	/* Remove item from Requisition */
 	
 	function remove_Item()
 	{
 		//Remove Item from requisition Items Table
 		
 		$this->db->delete('requisition_items',array(
 				'ID'=>$this->uri->segment(4),
 				'RequisitionNo'=>$this->uri->segment(3)
 		));
 		
 	}
 	
 	function requisition_Running_Total()
 	{
 		$reqNo = $this->uri->segment(3);
 		$sql ="";
 		$sql .="select sum(ri.Total_Cost) as Total
				from requisition_items ri
				where ri.RequisitionNo = '".$reqNo."'
				group by ri.RequisitionNo";
 		
 		return $this->db->query($sql)->result();
 	}
 	
 	function insert_Invoice($invoice)
 	{
 		$date = date('y-m-d G:i:s');
 		//Insert filepath into purchase_order Table
 		$purOrd =array(
 				'FilePath'=>$invoice['file_path'],
 				'FileName'=>$invoice['file_name'],
 				'Create_time'=> $date
 		);
 		
 		$s = $this->db->insert_string('purchase_order',$purOrd);
 		$this->db->query($s);
 		$purID = $this->db->insert_id();
 		
 		//Retrieve Requisition ID from requisition Table
 		$req = $this->uri->segment(3);
 		$sql ="";
 		$sql .="select ID
				from requisition
				where RequisitionNo ='".$req."'";
 		$reqID = $this->db->query($sql)->result();
 		
 		//Create link between uploaded purchase orders and Requisitions
 		$reqPurOrd =array( 		
 				'Purchase_Order_ID'=>$purID,
 				'Requisition_ID'=>$reqID['0']->ID,
 				'Create_time'=> $date
 		);
 		$r = $this->db->insert_string('requisition_purchase_order',$reqPurOrd);
 		$this->db->query($r); 
 	}
 	
 	
 	
 	//Approve Submitted Requisition
 	
 	public function approve($data)
 	{
 		//Assign Values coming from Controller
 		$date = date('y-m-d G:i:s');
 		$requisitionNo = $data['RequisitionNo'];
 		$user = $data['approvedBy'];
 		$aID = $data['accessId'];
 		$ID = $data['ID'];
 		
 		//Retrieve the Stage of the requisition in question from the requisition table
 		$sql ="";
 		$sql .="select r.Stage, d.Department_Type_ID
					from requisition r
					join departments d on d.ID = r.departments_ID
					where r.RequisitionNo ='".$requisitionNo."' and r.departments_ID = d.ID ";
 		$stage = $this->db->query($sql)->result_array();
 		
 		//Assign stage of requisition and new stage to be assigned
 		$stage = $stage['0']['Stage'];
 		$Stage = $stage + 1;
 		//$departmentType = $stage['0']['Department_Type_ID'];
 		
 		//Assign Auto approval if Department is non Accademic
 		/* if($departmentType = 2)
 		{
 			$Stage = 2;
 			$user = "Auto Approval";
 		} */
 		
 		//Update requisition stage
 		$sql ="";
 		/*if ($stage == '4'){
 			$sql .="UPDATE requisition r
 					set r.Stage=".$Stage."";
 		}else {*/
 			$sql .="UPDATE requisition r
	 				SET r.Stage=".$Stage."";
 		//	}
 	/* 	if($stage == '0')
 		{
 			$sql .="UPDATE requisition r
	 				SET r.Stage='".$Stage."'";
 		} */
 			
 		if($stage == '1')
 		{
 			$sql .=", r.ChairApprovedBy='".$user."', r.Chair_Approval_Date ='".$date."' " ;
 		}
 		
 		if($stage == '2')
 		{
 			$sql .=", r.DeptApprovedBy='".$user."', r.Dept_Dir_Approval_Date ='".$date."' " ;
 		}
 		if($stage == '3')
 		{
 			$sql .=", r.VPApproval='".$user."', r.VP_Approval_Date ='".$date."' " ;
 		}
 		if($stage == '4')
 		{
 			$sql .=" r.FinanceApprovalBy='".$user."', r.Finance_Approval_Date ='".$date."' " ;
 		}
		
		$sql .=" WHERE r.RequisitionNo = '".$requisitionNo."' ";
		
		if($aID == $Stage){
			$this->db->query($sql);
		}
		//var_dump($sql);

		If($stage == '4')
		{
			$sql ="UPDATE users_requisition_status urs
					set urs.ReqStat_ID ='1', ModifiedBy ='".$ID."'
							where urs.RequisitionNo ='".$requisitionNo."' ";	
		}
		$this->db->query($sql);
 	}
 	
 	public function get_requisition_stage($data)
 	{
 		$requisitionNo = $data['RequisitionNo'];
 		$sql ="";
 		$sql .="select Stage
					from requisition
					where RequisitionNO ='".$requisitionNo."' ";
 		return $this->db->query($sql)->result_array();
 	}
 	
 	
 	/* Deny Submitted Requisition */
 	public function deny($data)
 	{
 		$date = date('y-m-d G:i:s');
 		$requisitionNo = $data['RequisitionNo'];
 		$user = $data['approvedBy'];
 		$aID = $data['accessId'];
 		$ID = $data['ID'];
 		
 		$stage = "select ID from requisition_status where statusName='Denied'";
 		$stat = $this->db->query($stage)->result_array();
 		$stat = $stat[0]['ID'];
 		
 		$sql ="";
 		$sql .="UPDATE users_requisition_status urs
			SET urs.ReqStat_ID='".$stat." '
			WHERE urs.RequisitionNo ='".$requisitionNo."'";
 		$this->db->query($sql);
 	}
 	
 	/* Deny Submitted Requisition */
 	public function returnReq($data)
 	{
 		$date = date('y-m-d G:i:s');
 		$requisitionNo = $data['RequisitionNo'];
 		//$user = $data['approvedBy'];
 		$aID = $data['accessId'];
 		$ID = $data['ID'];
 		
 		$stage = "select ID from requisition_status where statusName='Returned'";
 		$stat = $this->db->query($stage)->result_array();
 		$stat = $stat[0]['ID'];
 		
 		$sql ="";
 		$sql .="UPDATE users_requisition_status urs
			SET urs.ReqStat_ID='".$stat." '
			WHERE urs.RequisitionNo ='".$requisitionNo."'";
 		$this->db->query($sql);
 		
 		$rsql ="";
 		$rsql .="UPDATE requisition r
			SET r.Stage='0'
			WHERE r.RequisitionNo ='".$requisitionNo."'";
 		$this->db->query($rsql);
 	}
 	
 	/* Return all requisitions that have been approved */
 	public function approvedRequisitions() {
 		
 		$sql ="";
 		$sql .="select r.*, d.DepartmentName, rt.TypeName, u.FirstName, u.LastName
				, p.Payeecol, urs.isProcessed
				from requisition r
				join users_requisition_status urs on urs.Requisition_ID = r.ID
				join departments d on d.ID = r.departments_ID
				join requisition_types rt on rt.ID = r.Requisition_Types_ID
				join users u on u.Id = r.users_ID
				join payee p on p.ID = r.Payee
				where urs.ReqStat_ID = 1";
 		
 		return $this->db->query($sql)->result_array();
 	}
 	
 	public function isprocessed() {
 		$requisition = $this->uri->segment(3);
 		
 		$sql ="";
 		$sql .="update users_requisition_status urs
					set urs.isProcessed = 1
					where urs.Requisition_ID ='".$requisition."'";
 		$this->db->query($sql);
 		
 		$rsql ="";
 		$rsql .="select u.*, r.RequisitionNo
					from users u 
					join requisition r on r.users_ID = u.ID
					join users_requisition_status urs on urs.Requisition_ID = r.ID
					where urs.Requisition_ID = '".$requisition."'";
 		return $this->db->query($rsql)->result_array();
 		
 	}
 	
 	/* Cancel Submitted Requisition */ 	
 	public function cancel($c)
 	{
 		
 		$sql ="";
 		$sql .="UPDATE users_requisition_status urs
			SET urs.ReqStat_ID='4'
			WHERE urs.RequisitionNo = '".$c['reqId']." '";
 		return $this->db->query($sql);
 	}
 	
 	
 	
 	/* dump data from Aeorion SQL Databes into Requisition MYSQL Database */
 	// Insert List of Departments from Azar SQL Database into MYSQL Database
 	public function enter_dept($d)
 	{
 		/* echo '<pre>';
 		print_r($d);
 		echo '</pre>'; */
 		$deps = array();
 		foreach($d as $key => $value ) {
 			$deps[] =$value['DepartmentName'];
 			
 			
 		}
 		echo sizeof($deps);
 		$i =0;
 		var_dump($deps[26]);
 		
 		
 		for($i = 0; $i < sizeof($deps); $i++ ) {
 			echo $deps[$i];
 			
 			$string = array(
 					'DepartmentName'=>$deps[$i],
 					'Department_Type_ID'=>'1',
 					'Purchasing_Dept'=>'0'
 			);
 			
 			$p=$this->db->insert_string('departments',$string);
 			$this->db->query($p);
 		}
 		
 	}
 	
 	
 	public function enter_user($d)
 	{
 		$date = date('y-m-d G:i:s');
 		$user = array();
 		$fname = array();
 		$lname = array();
 		
 		foreach($d as $key => $value ) {
 			$user[] =$value['UserName'];
 			$fname[] = $value['StaffFacFirstName'];
 			$lname[] = $value['StaffFacLastName'];
 		}


 		for($i=0; $i < sizeof($d); $i++)
 		{
 			$string = array(
 			 		'UserName'=>$user[$i],
 					'FirstName'=>$fname[$i],
 					'LastName'=>$lname[$i],
 					'Create_time'=>$date,
 					'Modify_time'=>$date,
 					'departments_ID'=>'2'
 			);
 			
 			$p=$this->db->insert_string('users',$string);
 			$this->db->query($p);
 		}
 		
 	}
 	
 	 	
 	
 }