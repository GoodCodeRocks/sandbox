<h3>Application Steps</h3>

<?php 
	if (validation_errors()) {
		echo validation_errors();
	}

?>

<?= form_open("admin/steps/save")?>
	<div>
		<label for="">Step Number</label>
		
		<select name="step" id="step">
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
		<input type="text" name="name" value="<?= $name ?>"/>
	</div>
	
	<div>
		<label for="">Is Academic</label>
		<span><input type="radio" name="academic" value="1" <?=($is_academic == 1) ? "checked":""?> > Academic <br></span>
		<span><input type="radio" name="academic" value="0" <?=($is_academic == 0) ? "checked":""?> > Non-Academic <br></span>
		
	</div>
	
	<div>
		<label for="">Enabled</label>
		<input type="checkbox" name="enabled" value="1" <?=($enabled == 1) ? "checked":""?> />
	</div>

	
	<input type="submit" value="Save" />	

<?=form_close() ?>