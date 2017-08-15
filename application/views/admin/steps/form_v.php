<div class="right-panel" style="float: left; width: 80%; padding: 5px; margin: 5px;">
			<div class="container">
		<h3>Application Steps</h3>
		<?=anchor('admin/steps','<< Back to List of Steps')?>
		<?php 
			if (validation_errors()) {
				echo validation_errors();
			}

		?>

		<?= form_open("admin/steps/save")?>
			<div>
				<label for="">Step Number</label>
				
				<select name="step" id="step" class="form-control">
					<?php 
						for($i=1; $i <=11; $i++) {
							?> <option value="<?=$i?>" <?=($i == $step)? "selected":""?> > <?=$i ?> </option> <?php 
						}
					?>
				</select>
				<input type="hidden" value="<?=$sid ?>" name="sid"/>
			</div>
			
			<div>
				<label for="">Name</label>
				<input type="text" name="name" value="<?= $name ?>" class="form-control" />
			</div>
			
			<div>
				<label for="">Is Academic</label> 
				<br/>
				<span> <input type="radio" name="academic" value="1" <?=($is_academic == 1) ? "checked":""?> >Academic </span> 
				<span> <input type="radio" name="academic" value="0" <?=($is_academic == 0) ? "checked":""?>> Non-Academic <br></span>
			</div>
			
			<div>
				<label for="">Is Finance </label>
				<input type="checkbox" name="finance" value="1" <?=($is_finance == 1) ? "checked":""?> />
			</div>

			<div>
				<label for="">Enabled</label>
				<input type="checkbox" name="enabled" value="1" <?=($enabled == 1) ? "checked":""?> />
			</div>
			<!--<input type="submit" value="Save" class=""/> -->
			<button type="submit" name="save" class="btn-sm btn-success">Save</button>

		<?=form_close() ?>

			</div>
		</div>