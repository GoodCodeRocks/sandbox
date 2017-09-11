<?php
    defined('BASEPATH') or exit('No direct script access allowed');

  /*
      This class is designed for the primary purpose of testing the possibility
      of building dynamic queries using the result field names and data rows
   */
  class Sandbox extends CI_Model
  {
      private $user_id;

      public function __construct() {
          parent::__construct();
      }

      // generate requsition  and requsition steps based on a user_id

      public function save($data) {

                  // determine department_id the user is associated with
                  // whether its academic/ non-academic
                  $department_id = $data['department'];
                  $user_id = $data['user'];
                  $requisition_type_id = $data['requisition_type'];
                  $sql = " select * from department where id = $department_id ";
                $result = $this->db->query($sql)->row_array();
                  // department type
                  $department_type = $result['is_academic'];
                  //Requisition Number
                  $req_no = $this->req_num();
                  // generate requisition
                  $sql = " insert into requisition (requisition_no, user_id, department_id, requisition_status )
                  values ('.$req_no.',$user_id,$department_id, null ) " ;
                  $result = $this->db->query($sql);
                  // grab the reqquisition_id once it has been created
                  $requisition_id = $this->db->insert_id();
                  echo $requisition_id;
                  // get number of steps
                  $sql = " select
                        a.id as department_id, a.name, b.id as step_id, b.step, c.id as role_id, c.name as role_name
                        from department a
                        join steps b on b.is_academic = a.is_academic
                        join role c on c.step_id = b.id
                        where a.id =  $department_id ";
                  $result = $this->db->query($sql)->result_array();
                  echo $sql;
                  // generate the steps based on the number of steps for department type
                      foreach ($result as $row ) {
                      $step_id = $row['step_id'];
                      $role_id = $row['role_id'];
                      $step = $row['step'];
                      $department_id = $row['department_id'];
                      $sql = " insert into requisition_steps (requisition_id, step_id, step, role_id, department_id,user_id, approval_status_id,approved_at )
                      values ($requisition_id, $step_id,$step, $role_id, $department_id, null, null, null ) ; ";
                      $this->db->query($sql);
                      } 
                     // set initial step
                $sql = " select id from requisition_steps where step = 1 and requisition_id = $requisition_id ";
                $result = $this->db->query($sql)->result_array();
                $requisition_step_id = $result[0]['id'];
                // update requisition, set the requisition_step_id
                $sql = " update requisition set requisition_step_id =  $requisition_step_id where id = $requisition_id ";
                $this->db->query($sql); 
      }

      function getRequisitions($user_id, $view = null) {
      	

	      	$user_departments = $this->getUserDepartmentsIds($user_id);
	      	$user_roles = $this->getUserRoles($user_id);
	      	$user_steps = $this->getUserSteps($user_id);
	      	
	      	$sql = " select a.id, a.requisition_no, a.created_at, b.step, c.name as department_name, a.department_id
	      	, (
		      	select distinct count(aa.step)
		      	from
		      	steps aa
		      	join department b on b.is_academic = aa.is_academic
		      	where b.id = a.department_id
		      	group by b.id
	      	) as total_steps
	      	, b.requisition_id
	      	from requisition a
	      	join requisition_steps b on b.requisition_id = a.id and b.id = a.requisition_step_id
	      	join department c on c.id = a.department_id
	      	where a.department_id in ($user_departments) and b.step in ($user_steps) ";
	      	
	      	$result = $this->db->query($sql)->result_array();
	      	
      		return $result;

        $this->db->query($sql); 
      	

      }
      
      function getProcessedRequisitions($user_id, $view = null) {
      	
      	$user_departments = $this->getUserDepartmentsIds($user_id);
      	$user_roles = $this->getUserRoles($user_id);
      	$user_steps = $this->getUserSteps($user_id);
      	
      	
      	$sql = " select a.id, a.requisition_no, a.created_at, b.step, c.name as department_name
	      	, (
			      	select distinct count(aa.step)
			      	from
			      	steps aa
			      	join department b on b.is_academic = aa.is_academic
			      	
			      	where b.id = a.department_id
			      	group by b.id
			      	) as total_steps
			      	, d.is_finance
			      	, b.user_id
			      	, case when (b.step > fin_step.finance_ ) then 'Finance Approved being processed' else 'Not yet approved' end as finance_approved
			      	, case when (b.step > fin_step.finance_ ) then 1 else 0 end as approval_status
			      	, fin_step.finance_
			      	, fin_step.id
			      	, b.requisition_id
			      	from requisition a
			      	join requisition_steps b on b.requisition_id = a.id and b.id = a.requisition_step_id
			      	join department c on c.id = a.department_id
			      	join steps d on d.id = b.step_id
			      	join (
					      	-- get the step at which finance approves requisitions
					      	-- if the requisition step is higher than this step, then it can be marked as approved
					      	select distinct min(step) as finance_, a.id, a.department_id
					      	
					      	from (
						      	-- get the step at which the vp approves requisition
						      	select distinct a.department_id, b.id as dep_id, b.is_academic, c.step, c.is_finance, a.id
						      	from requisition a
						      	join requisition_steps bb on bb.requisition_id = a.id and bb.id = a.requisition_step_id
						      	join department b on b.id = a.department_id
						      	join steps c on c.is_academic = b.is_academic
						      	where c.is_finance = 1
					      	
					      	) a
			      	
			      	) fin_step
			      	where a.department_id in ($user_departments) and d.step > ( select $user_steps ) ";
			      	
			      	$result = $this->db->query($sql)->result_array();
      		return $result;
      }
      
      public function approveRequisition($user_id, $requisition_id) {
      	 // update requisition set the next step
      	 $sql = "select distinct a.id, a.department_id, bb.step, a.requisition_step_id,
				(
							      	select distinct count(aa.step)
							      	from
							      	steps aa
							      	join department b on b.is_academic = aa.is_academic
							      	
							      	where b.id = a.department_id
							      	group by b.id
				) as total_steps
				from requisition a
				join requisition_steps bb on bb.requisition_id = a.id and bb.id = a.requisition_step_id
				where a.id = $requisition_id ";
      	 $result = $this->db->query($sql)->result_array();
      	 
      	 $requisition_step_id = $result[0]['requisition_step_id'];
      	 $requisition_id = $result[0]['id'];
      	 $current_step = $result[0]['step'];
      	 
      	 $sql = " update requisition_steps set user_id = $user_id, approved_at = current_timestamp() where id = $requisition_step_id ";
      	 $this->db->query($sql);
      	 
      	 
      	 $sql = " select * from (select a.id, a.requisition_id, a.user_id, a.step
					, (
							select distinct count(aa.step)
							from
							steps aa
							join department b on b.is_academic = aa.is_academic
							
							where b.id = a.department_id
							group by b.id
					) as total_steps
					from requisition_steps a 
				) a
					where a.requisition_id = $requisition_id and a.step = ( $current_step + 1 ) 
					and ( a.total_steps >= ( $current_step + 1 ) ) ";
      	 
      	 $result = $this->db->query($sql)->result_array();
      	 
      	 try {
      	 
      	     @$id = $result[0]['id'];
      	 
	      	 if(isset($id)) {
	      	    	$sql = " update requisition set requisition_step_id = $id where id = $requisition_id ";
		      	$this->db->query($sql);
	          }
      	 } catch(Exception $e) {
      	 	  echo "Asdf";
      	 }
      }
              
      // return user department ids so that it can be used in other 
      // places in the application
      function getUserDepartmentsIds($user_id) {
            $user_departments = $this->getUserDepartments($user_id);
            foreach ($user_departments as $user_department) {
                $department[]= $user_department['department_id'];
            }
            $departments = implode(",",$department);
            return $departments;
        }
              // return list of Departments
        function getUserDepartments($user_id){
            $sql = "select distinct dept.*,ud.department_id
                    from department dept
                    join users_department ud on ud.department_id = dept.id
                    where ud.department_id = dept.id and ud.users_id = '".$user_id."' ";
            return  $this->db->query($sql)->result_array();
        }
        function getUserRoles($user_id) {
             $sql = " select a.id, a.role_id, a.user_id, c.step
                     from user_role a 
                     join role b on b.id = a.role_id
                     join steps c on c.id = b.step_id
                     where a.user_id = $user_id ";
            $user_roles = $this->db->query($sql)->result_array();
            foreach ($user_roles as $user_role) {
                $roles[]= $user_role['role_id'];
            }
            $roles = implode(",",$roles);
            return $roles;
        }

        function getUserSteps($user_id) {
            $sql = " select a.id, a.role_id, a.user_id, c.step
            from user_role a 
            join role b on b.id = a.role_id
            join steps c on c.id = b.step_id
            where a.user_id = $user_id ";
            $user_steps = $this->db->query($sql)->result_array();

            foreach ($user_steps as $user_step) {
                $steps[]= $user_step['step'];
            }
            $step = implode(",",$steps);
            return $step;
        }

      //return all requisition Types
      function getType(){

      	$sql = " select * from requisition_type";

      	return $this->db->query($sql)->result_array();
      }
      
      //return all data on specific requisition
      function getRequisitionDetails($info){
      	$sql = "select a.id, a.requisition_no, b.name as Department, d.name, e.file_name, e.file_path
      	from requisition a
      	join department b on b.id = a.department_id
      	join requisition_steps c on c.id = a.requisition_step_id
      	join steps d on d.id = c.step_id
		left join purchase_order e on e.requisition_id = a.id
      	where a.id = $info";
      	
      	return $this->db->query($sql)->result_array();
      }
      
      //return information on next person to process requisition
      function getrequisitionprocessingdetails($info){
      	//try {
	      	$sql ="select concat(e.last_name,', ', e.first_name ) as user, b.name as department, c.name as position				
					from requisition_steps a
					join department b on b.id = a.department_id
					join role c on c.id = a.role_id
					join user_role d on d.role_id = c.id
					join users e on e.id = d.user_id
					where a.id = (select @requisition_step_id:=requisition_step_id as requisition_step_id
							from requisition
							where id = $info) and c.step_id = a.step_id";
	    
	      	return $this->db->query($sql)->result_array();
      //	} catch (Exception $e){
      //		return $e;
      	//}
      }
      //return information on next person to process requisition
      function getrequisitionprocessdetails($info){
      	//try {
      	$sql ="select * from requisition_steps_view
      	where requisition_id = $info";
      	
      	return $this->db->query($sql)->result_array();
      	//	} catch (Exception $e){
      	//		return $e;
      	//}
      }
      
      
      //return information on last person to process requisition
      function getrequisitionprocessedbydetails($info){
      	$sql ="select concat(e.first_name,' ',e.last_name) as user, c.name as position, b.name as step
				,  g.name as department, h.status, a.approved_at
				from requisition_steps a
				join steps b on b.id = a.step_id
				join role c on c.step_id = b.id
				join user_role d on d.role_id = c.id
				join users e on e.id = d.user_id
				join users_department f on f.users_id = e.id
				join department g on g.id = f.department_id
				join approval_status h on h.id = a.approval_status_id
				where a.id = (select requisition_step_id 
				from requisition
				where id = $info) - 1 and a.department_id=f.department_id;";
      	return $this->db->query($sql)->result_array();
      }
      
      //return all requisition Types
      function getcategory(){
      	
      	$sql = " select * from category";
      	
      	return $this->db->query($sql)->result_array();
      }
      
      /* Add Item to Requisition */
      function add_Item($clean)
      {
      	//Insert list of requisition items into Items Table
      	$date = date('y-m-d G:i:s');
      	$req_item =array(
      			'description'=>$clean['itemname'],
      			'create_time'=> $date,
      			'unit_cost'=>$clean['unitcost'],
      			'quantity'=>$clean['quantity'],
      			'cumulative_cost'=>$clean['cumulativecost'],
      			'category_id'=>$clean['itemcategory'],
      			'requisition_id'=>$clean['requisitionid'],
      	);
      	$r = $this->db->insert_string('requisition_items',$req_item);
      	$this->db->query($r);
      	
      }
      
      //return all items attached to specific requisition
      function getrequisitionitems($info){
      	$sql ="select a.description, a.quantity, a.unit_cost, a.cumulative_cost, b.category_name
				from requisition_items a 
				join category b on b.id = a.category_id
				where a.requisition_id = $info";
      	
      	return $this->db->query($sql)->result_array();
      }
      
      //Insert Requisition information 
      function insert_Invoice($invoice)
      {
      	
      	$data = $invoice['file'];
      	//var_dump($data, $invoice['requisitionid']);
      	$date = date('y-m-d G:i:s');
      	//Insert filepath into purchase_order Table
      	$purOrd =array(
      			
      			'file_path'=>$data['full_path'],
      			'file_name'=>$data['file_name'],
      			'requisition_id' =>$invoice['requisitionid'],
      			'Create_time'=> $date
      	);
      	
      	$s = $this->db->insert_string('purchase_order',$purOrd);
      	$this->db->query($s);
      	
      }
      
      //get purchaseorder details
      function getPurchaseOrder($id){
      	$sql ="";
      	$sql .="Select *
 				from purchase_order
 				where requisition_id =$id";
      	return $this->db->query($sql)->result_array();
      }
      
      /* Method Generates random requisition number for each new Requisition */
      private function req_num() {
      	
      	$pool = array_merge(range(0,9), range('a', 'z'),range('A', 'Z'));
      	$length = 4;
      	$key ="";
      	date_default_timezone_set ( "America/La_Paz" );
      	
      	for($i=0; $i < $length; $i++) {
      		$key .= $pool[mt_rand(0, count($pool) - 1)];
      	}
      	
      	$date = date('Ymd-his');
      	$req_num = $date."-".$key;
      	return $req_num;
      }
      

  }

 ?>
