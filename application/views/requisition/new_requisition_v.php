<div class="container-fluid">
	<div class="panel panel-default">
		<div class="panel-heading"><h3>Generate Requisitions</h3></div>
		<div class="panel-body">
		<?=form_open("requisition/save")?>
            <div>
            	<div class="form-group">
            		<input type="hidden" name="user" value="<?= $User?>" />
            	   	<label for="requisitioningDepartment">Requisition Department</label>
	            	<select name="department" class="form-control">
	            			<?php foreach ($Departments as $department ) { ?>
						<option value="<?=$department['id']?>" >
							<?=$department['name']?>
						</option>
				   			<?php }?>
            		</select>
            		<?php echo form_error('department'); ?>
            	</div>
            	<div class="form-group">
            		<label for="requisitionType">Requisition Type</label>
            		<select name="requisition_type" class="form-control">
            				<?php foreach ($RequisitionTypes as $requisition_type) { ?>
            				<option value="<?=$requisition_type['id']?>" > 
								<?=$requisition_type['name']?>
							</option>
						<?php }?>
            		</select>
            		<?php echo form_error('requisition_type'); ?>
				</div>
	            <div class="col-lg-4 col-lg-offset-10">
            	 	<button type="submit" class="btn btn-success">Generate</button>
            	 	<button type="submit" class="btn btn-danger">Cancel</button>
            	</div>
			</div>
			<br><hr>
            <pre>System will generate requisition and assign it to the department</pre>
           <?=form_close()?>
		</div>
	</div>
</div>

