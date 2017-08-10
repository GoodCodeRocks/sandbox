<?php
    defined('BASEPATH') or exit('No direct script access allowed');

  /*
      This class is designed for the primary purpose of testing the possibility
      of building dynamic queries using the result field names and data rows
   */
  class Sandbox_ extends CI_Model
  {
      private $db2;
      public function __construct() {
          parent::__construct();
          $this->db2 =  $this->load->database('db2', true);
      }

      public function getStudents() {
          $sql = "select top 100 Student_ID as StudentID
              , LastName as 'Last Name'
              , FirstName as 'First Name'
               from students " ;
          $query  = $this->db->query($sql)->list_fields();
          foreach ($query as $key => $value) {
            echo $key. " ". $value ;
          }
          return $this->db->query($sql)->result_array();
      }

      // generate requsition  and requsition steps based on a user_id
      public function genRequisition() {
            // determine department_id the user is associated with
            // whether its academic/ non-academic
            $department_id = 3;
			$requisition_status = 1;
            $user_id = 6;
            $sql = "select * from
                    user_role a
                    join role b on b.id = a.role_id
                    join department c on c.id = a.department_id
                    where a.user_id = $user_id and a.department_id = $department_id ";
            $result = $this->db2->query($sql)->row_array();
            // department type
            $department_type = $result['is_academic'];
            //echo $department_type;

            // generate requisition
            $sql = " insert into requisition (requisition_no, user_id, department_id, requisition_status )
                     values ('20170705-1123-XmtsrE',$user_id,$department_id,$requisition_status) " ;
            $result = $this->db2->query($sql);

            // grab the reqquisition_id once it has been created
            $requisition_id = $this->db2->insert_id();
            //echo $requisition_id;

            // get number of steps
            $sql = " select *
                    from user_role a
                    join role b on b.id = a.role_id
                    where department_id = $department_id ";

            $result = $this->db2->query($sql)->result_array();
            echo $sql;
            // generate the steps based on the number of steps for department type
            foreach ($result as $row ) {
                $step_id = $row['step_id'];
                $role_id = $row['role_id'];
                $department_id = $row['department_id'];
                $sql = " insert into requisition_steps (requisition_id, step_id, role_id, department_id,user_id, approval_status_id,approved_at )
	                     values ($requisition_id, $step_id, $role_id, $department_id, null, null, null ) ; ";
                $this->db2->query($sql);
            }

      }

      // get all requisitions

  }

 ?>
