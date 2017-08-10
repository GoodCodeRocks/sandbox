
<div class="right-panel" style="float: left; width: 80%; padding: 5px; margin: 5px;">
	<div class="container">
		<?php echo anchor('admin/departments/form','Add New department'); ?>
		<table class="table">
			<thead>
				<tr>

					<th>Name</th>
					<th>Academic</th>
					<th>Division</th>
					<th>Action</th>

				</tr>
			</thead>
			<tbody>
			<?php foreach ($Departments as $department) { ?>
				<tr>

					<td><?=$department['name']?> </td>
					<td><?=($department['is_academic'] ) ? "Yes":"No"?> </td>
					<td><?=$department['division_id'] ?> </td>
					<td>
						<?=anchor('admin/departments/form/'.$department['id'],'<button>Edit</button>') ?> 
						<?=anchor('admin/departments/delete/'.$department['id'],'<button>Delete</button>') ?> 
					</td>
				</tr>
			<?php }?>
	</tbody>
		</table>

	</div>
</div>