<div class="right-panel" style="float: left; width: 80%; padding: 5px; margin: 5px;">
	<div class="container">

<?php 
	if (validation_errors()) {
		echo validation_errors();
	}

?>
	
   <div class="panel panel-default row">
		<div class="panel-heading"><h3>Manage Users</h3></div>
				<div class="panel-body">
				
			<?= form_open("admin/users/save",array('class'=>'container-fluid'))?>		
					
						<div class="row">
			            	<div class="form-group">
				            	<div class="col-md-6">
				            		<label for="firstname">First Name</label>
				            		<input type="text" name="fname" value="<?= $first_name?>"  class="form-control"/>
				            	</div>
				            	<div class="col-md-6">
				            		<label for="lastname">Last Name</label>
				            		<input type="text" name="lname" value="<?= $last_name ?>"  class="form-control"/>
				            	</div>
			            	</div>
			            	<div class="form-group">
				            	<div class="col-md-12">
				            		<label for="username">UserName</label>
				            		<input type="text" name="uname" value="<?=$username ?>"  class="form-control"/>
			
									<input type="hidden" value="<?php echo $uid ?>" name="uid"/>
									<input type="hidden" name="reference" value="<?= $reference_no ?>"/>
				            	</div>
			            	</div>
			            	<div class="form-group">
				            	<div class="col-md-12">
				            		<label for="password">Password</label>
				            		<input type="text" class="form-control">
				            	</div>
			            	</div>
			            	<div class="form-group">
				            	<div class="col-md-12">
				            		<label for="Department">Department</label>
				            		<select name="departments[]" id="" multiple  class="form-control selectpicker">
									<?php 
									
									foreach ($Departments as $department ) { ?>
										
										<option value="<?=$department['id']?>" 
										
											<?php  
												
												if(isset($UserDepartments)) {
													for($i=0; $i < sizeof($UserDepartments) ; $i++) {
														if ( $department['id'] == $UserDepartments[$i]['department_id'] ) {
															echo " selected ";
														}
													}
												} 
											
											 ?> 
										>
										
										<?=$department['id']?> <?=$department['name']?>
									    
									    </option>
									
									<?php 
										
										}
									?>
								</select>
				            	</div>
			            	</div>
			            	<div class="form-group">
				            	<div class="col-md-12">
				            		<label for="role">Role</label> 
				            		<select name="roles[]" id=""  multiple  class="form-control selectpicker" >
										<?php 
										
										
											foreach ($Roles as $role ) {  ?>
										
											<option value="<?=$role['id']?>"
											
													<?php  
														 if(isset($UserRoles)) {
															 for($i=0; $i < sizeof($UserRoles) ; $i++) {
															 	if ( $role['id'] == $UserRoles[$i]['role_id'] ) {
															 		echo " selected ";
															 	}
														     }
														} 
													 ?> 
											
											 >
													<?=$role['id']?>
													<?=$role['step_name']?> 
													<?=$role['acad_category']?> 
													<?=$role['name']?> 
											</option>
										
										<?php
											
											}
										?>
									</select>
				            	</div>
			            	</div>
		            		<div class="col-lg-4 col-lg-offset-10">
				            	<br>
				            	<button type="submit" class="btn btn-success">Save</button>
				            	<button type="submit" class="btn btn-danger">Cancel</button>
		            		</div>
					</div>
					<?=form_close() ?>
			</div>
		</div>
	
	
	
	</div>
</div>