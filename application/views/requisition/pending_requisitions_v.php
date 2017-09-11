<div class="container-fluid">
	<div class="panel panel-default">
		<div class="panel-heading"><h3>Requisitions <?php echo $User; ?></h3></div>
		<div class="panel-body">
	       	<table class=" table table-striped table-hover table-bordered">
				<tr>
					<th>Requisition No</th>
					<th>Department Origin</th>
					<th>Date Created</th>
					<th>Step</th>
					<th>Action</th>
				</tr>
				<?php foreach ($Requisitions as $requisition) { ?>				
				<tr>
					<td> <?=$requisition['requisition_id'] ?> <?=$requisition['requisition_no'] ?> </td>
					<td> <?=$requisition['department_name'] ?> </td>
					<td> <?=$requisition['created_at'] ?> </td>
					<td> <?=$requisition['step'] ?> / <?=$requisition['total_steps'] ?> </td>
					<td>
						<?=anchor('requisition/detail/'.$requisition['requisition_id'],'<button type="submit" class="btn-xs btn-success">View</button>')?>
					</td>
				</tr>
				<?php } ?>
			</table>
		</div>
	</div>
</div>
	
		