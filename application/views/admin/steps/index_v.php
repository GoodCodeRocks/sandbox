<div class="right-panel" style="float: left; width: 80%; padding: 5px; margin: 5px;">
	<div class="container">
	<?php
	echo anchor('admin/steps/form','Add New Step');
	?>

		<table class="table">
			<thead>
				<tr>
					<th>Step</th>
					<th>Name</th>
					<th>Is Academic</th>
					<th>Is Finance </th>
					<th>Enabled</th>
					<th>Action</th>
				
				</tr>
			</thead>
			<tbody>
					<?php foreach ($Steps as $step) { ?>
						<tr> 
							<td><?=$step['step']?></td>
							<td><?=$step['name']?> </td>
							<td><?=($step['is_academic'] ) ? "Yes":"No"?> </td>
							<td><?=($step['is_finance']) ? "Yes":"No"?> </td>
							<td><?=($step['is_enabled']) ? "Yes":"No"?> </td>
							<td>
								<?=anchor('admin/steps/form/'.$step['id'],'<button type="submit" class="btn-xs btn-success">Edit</button>') ?> 
								<?=anchor('admin/steps/delete/'.$step['id'],'<button type="submit" class="btn-xs btn-danger">Delete</button>') ?> 
							</td>
						</tr>
					<?php }?>
			</tbody>
		</table>

	</div>
</div>