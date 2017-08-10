<?php

//var_dump($Steps);

echo anchor('admin/steps/form','Add New Step');

?>

<table class="table">
	<thead>
		<tr>
			<th>Step</th>
			<th>Name</th>
			<th>Academic</th>
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
					<td><?=($step['is_enabled']) ? "Yes":"No"?> </td>
					<td>
						<?=anchor('admin/steps/form/'.$step['id'],'<button>Edit</button>') ?> 
						<?=anchor('admin/steps/delete/'.$step['id'],'<button>Delete</button>') ?> 
					</td>
				</tr>
			<?php }?>
	</tbody>
</table>