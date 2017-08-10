
<div class="right-panel" style="float: left; width: 80%; padding: 5px; margin: 5px;">
	<div class="container">


<?php 
	if (validation_errors()) {
		echo validation_errors();
	}
	
?>

<?= form_open("admin/roles/save")?>
	
		<div class="col-lg-12">
			<div class="col-md-6">
				
				<div class="form-group">
					<div class="col-md-12">
						<label for="">Choose a step</label>
		
						<select name="step" id="step" class="form-control">
							<?php 
								foreach ($Steps as $step ) { ?>
									
									<option value="<?=$step['id'] ?>" > 
									
										<?php echo $step['step']," ". $step['name'], " ". $step['is_academic'] == 1 ? " Academic ":" Non-Academic " ?> 
									
									</option>
									
								<?php }
							?>
						</select>
						<input type="hidden" value="<?=$rid ?>" name="rid"/>
						
						<label for="">Name</label>
						<input type="text" name="name" value="<?= $name ?>" class="form-control"/>

					</div>

				</div>

				<div class="col-lg-4 col-lg-offset-8">
					<br>
					<button type="submit" name="save" class="btn-sm btn-success">Save</button>
					<button type="submit" name="cancel" class="btn-sm btn-danger">Cancel</button>
				</div>


			</div>


		</div>
		<?=form_close() ?>

	</div>
</div>


            	