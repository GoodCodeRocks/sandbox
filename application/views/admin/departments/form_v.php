
<?php

if (validation_errors ()) {
	echo validation_errors ();
	
}

?>
<div class="right-panel" style="float: left; width: 80%; padding: 5px; margin: 5px;">
	<div class="container">
	
	
	<?= form_open("admin/departments/save")?>
	
	<div class="panel panel-default row">
				<div class="panel-heading">
					<h3>Manage Departments</h3>
				</div>
				<div class="panel-body">
					<div class="col-lg-12">
						<div class="col-md-6">
							<div class="form-group">
								 <div class="col-md-12">
									<label for="">Department Name</label> 
									<input type="text" name="name" value="<?= $name ?>" class="form-control" />
									<input type="hidden" value="<?=$department_id ?>" name="did" />
								    
								    <label for="">Division</label> 
									<select name="division" id=""  class="form-control">
										<option value="">Division 1</option>
										<option value="">Division 2</option>
						
									</select>
								    
									<label for="">Is Academic</label> 
									<br/>
									<span> <input type="radio" name="academic" value="1" <?=($is_academic == 1) ? "checked":""?> >Academic </span> 
									<span><input type="radio" name="academic" value="0" <?=($is_academic == 0) ? "checked":""?>> Non-Academic <br></span>
									
								</div>
								
							</div>
	
							<div class="col-lg-4 col-lg-offset-8">
								<br>
								<button type="submit" name="save" class="btn-sm btn-success">Save</button>
								<button type="submit" name="cancel" class="btn-sm btn-danger">Cancel</button>
							</div>
							
							
						</div>
						
						
					</div>
					<div class="col-lg-12"></div>
				</div>
			</div>
	<?=form_close() ?>
	
	</div>
</div>