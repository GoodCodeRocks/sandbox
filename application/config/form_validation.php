<?php
$config = array(
		
		
		
		'requisition' => array(
				array(
						'field' => 'department',
						'label' => 'Department',
						'rules' => 'required'
				),
				array(
						'field' => 'requisition_type',
						'label' => 'Requisition',
						'rules' => 'required'
				),
				array(
						'field' => 'payee',
						'label' => 'Payee',
						'rules' => ''
				),
		),
		
		
		/* 
		  Validation for steps form */
		
		'steps' => array(
			array(
					'field' => 'step',
					'label' => 'Step',
					'rules' => 'required',
			),	
			array(
					'field' => 'name',
					'label' => 'Name',
					'rules' => 'required',
			),
			array(
					'field' => 'academic',
					'label' => 'Is Academic ',
					'rules' => 'required',
			),
			array(
					'field' => 'enabled',
					'label' => 'Enabled ',
					'rules' => '',
			),
		),
		
		/*
		 Validation for roles form */
		
		'roles' => array(
				array(
						'field' => 'step',
						'label' => 'Step',
						'rules' => 'required',
				),
				array(
						'field' => 'name',
						'label' => 'Name',
						'rules' => 'required',
				),
				
		),
		
		/*
		 Validation for department form */
		
		'department' => array(
				array(
						'field' => 'name',
						'label' => 'Department',
						'rules' => 'required',
				),
				array(
						'field' => 'academic',
						'label' => 'Academic',
						'rules' => 'required',
				),
				
		),
		
		'users' => array(
				array(
						'field' => 'uname',
						'label' => 'Username',
						'rules' => 'required',
				),
				array(
						'field' => 'lname',
						'label' => 'Last Name',
						'rules' => 'required',
				),
				array(
						'field' => 'fname',
						'label' => 'First Name',
						'rules' => 'required',
				),
				array(
						'field' => 'reference',
						'label' => 'Reference No',
						'rules' => '',
				),
				
		),
);
