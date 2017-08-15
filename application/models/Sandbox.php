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
      public function genRequisition($user_id = null) {
            // determine department_id the user is associated with
            // whether its academic/ non-academic
            $department_id = 3;
            $user_id = 67;
            $sql = "select * from
                    user_role a
                    join role b on b.id = a.role_id
                    join department c on c.id = a.department_id
                    where a.user_id = $user_id and a.department_id = $department_id ";
            $result = $this->db->query($sql)->row_array();
            // department type
            $department_type = $result['is_academic'];
            //echo $department_type;

            // generate requisition
            $sql = " insert into requisition (requisition_no, user_id, department_id, requisition_status )
                     values ('20170705-1123-XmtsrE',$user_id,$department_id, null ) " ;
            $result = $this->db->query($sql);

            // grab the reqquisition_id once it has been created
            $requisition_id = $this->db->insert_id();
            //echo $requisition_id;

            // get number of steps
            $sql = " select *
                    from user_role a
                    join role b on b.id = a.role_id
                    where department_id = $department_id ";

            $result = $this->db->query($sql)->result_array();
            echo $sql;
            // generate the steps based on the number of steps for department type
            foreach ($result as $row ) {
                $step_id = $row['step_id'];
                $role_id = $row['role_id'];
                $department_id = $row['department_id'];
                $sql = " insert into requisition_steps (requisition_id, step_id, role_id, department_id,user_id, approval_status_id,approved_at )
	                     values ($requisition_id, $step_id, $role_id, $department_id, null, null, null ) ; ";
                $this->db->query($sql);
            }

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
                  // generate requisition
                  $sql = " insert into requisition (requisition_no, user_id, department_id, requisition_status )
                  values ('20170705-1123-XmtsrE',$user_id,$department_id, null ) " ;
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
        // echo $sql;
        $result = $this->db->query($sql)->result_array();
        return $result;
      }

      function getProcessedRequisitions($user_id, $view = null) {
        
                $user_departments = $this->getUserDepartmentsIds($user_id);
                $user_roles = $this->getUserRoles($user_id);
                $user_steps = $this->getUserSteps($user_id);
        
               /* 
                $sql = " select a.id, a.requisition_no, a.created_at, b.step, c.name as department_name, a.department_id
                        , ( 
                                select distinct count(aa.step)
                                from 
                                steps aa 
                                join department b on b.is_academic = aa.is_academic
                                where b.id = a.department_id
                                group by b.id 
                          ) as total_steps
                          , case when (d.is_finance = 1 and b.user_id is not null ) 
                            then 'Finance Approved being processed' else 'Not yet approved' end as finance_approved
                           from requisition a 
                           join requisition_steps b on b.requisition_id = a.id and b.id = a.requisition_step_id
                           join department c on c.id = a.department_id 
                           join steps d on d.id = b.step_id
                           where a.department_id in ($user_departments) and b.step in ($user_steps) 
                           and  d.step > ( $user_steps )
                           
                           ";
                */

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

  }

 ?>
