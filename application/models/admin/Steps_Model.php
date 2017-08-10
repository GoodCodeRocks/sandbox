<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Steps_Model extends CI_Model {
	
	//private $db;
	
	public function __construct() {
		parent::__construct();
		//$this->db =  $this->load->database('db', true);
		
		
	}
	
	
	public function save($data, $step_id = null) {
		
		$step = $data['step'];
		$name = $data['name'];
		$is_academic = $data['academic'];
		$is_enabeled = $data['enabled'] ? $data['enabled'] : 0 ;
		
		
		if($step_id == null || $step_id == "") {
		
			$sql = " insert into steps (step, name, is_academic, is_enabled ) values ($step,'".$name."',$is_academic, $is_enabeled ) ";
				
		} else {
			
			$sql = " update steps set step = $step, name = '".$name."', is_academic = $is_academic, is_enabled = $is_enabeled where id = $step_id ";
			
		}
		
		$this->db->query($sql); 
		
		
	}
	
	public function getOne($step_id) {
		
		$sql = " select * from steps where id = $step_id ";
		
		return $this->db->query($sql)->result_array();
	}
	
	public function listAll() {
		
		$sql = " select * from steps order by is_academic, name ";
		
		return $this->db->query($sql)->result_array();
	}
	
	public function delete( $step_id ) {
		
		$sql = " delete from steps where id = $step_id ";
		
		return $this->db->query($sql);
	}
	
}
