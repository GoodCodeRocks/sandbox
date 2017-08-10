

<div class="right-panel" style="float: left; width: 80%; padding: 5px; margin: 5px;">
	<div class="container">
	<?php
	
	//var_dump($roles);
	
	echo anchor('admin/roles/form','Add New role');
	
	?>
	
	<table class="table">
		<thead>
			<tr>
				<th>Assigned Step</th>
				<th>Role  </th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
				<?php foreach ($Roles as $role) { ?>
					<tr> 
						<td><?=$role['step_name']?> Users </td>
						<td><?=$role['role_name']?> </td>
						
						<td>
							<?=anchor('admin/roles/form/'.$role['id'],'<button>Edit</button>') ?> 
							<?=anchor('admin/roles/delete/'.$role['id'],'<button>Delete</button>') ?> 
						</td>
					</tr>
				<?php }?>
		</tbody>
	</table>
	
	</div>
</div>