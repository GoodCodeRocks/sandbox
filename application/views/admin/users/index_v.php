<div class="right-panel" style="float: left; width: 80%; padding: 5px; margin: 5px;">
	<div class="container">
	<?php
	
	 echo anchor('admin/users/form','Add New user');
	
	?>
	
	<table class="table">
		<thead>
			<tr>
				
				<th>Username</th>
				<th>First</th>
				<th>Last</th>
				<th>Created At</th>
				<th>Last Modified </th>
				<th>Action</th>
			
			</tr>
		</thead>
		<tbody>
				<?php foreach ($Users as $user) { ?>
					<tr> 
						<td><?=$user['username']?> </td>
						<td><?=$user['first_name']?> </td>
						<td><?=$user['last_name']?> </td>
						<td><?=$user['created_at']?> </td>
						<td><?=$user['last_modified']?> </td>
						<td>
							<?=anchor('admin/users/form/'.$user['id'],'<button>Edit</button>') ?> 
							<?=anchor('admin/users/delete/'.$user['id'],'<button>Delete</button>') ?> 
						</td>
					</tr>
				<?php }?>
		</tbody>
	</table>
	
	</div>
</div>