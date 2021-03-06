<div class="container-fluid ">
	<div class="panel panel-default row">
		<div class="panel-heading"><h3>Processed Requisitions</h3></div>
		<div class="panel-body">
			<table class=" table table-striped table-hover table-bordered" style="Width:100%; height: 100%;">
				<tr>
					<th>Requisition No</th>
					<th>Department Origin</th>
					<th>Date Created</th>
					<th>Current Step</th>
					<th> </th>
				</tr>
					<?php foreach ($Requisitions as $requisition) { ?>
						<?php if($requisition['approval_status'] == 1) { ?>
						<tr>
							<td> <?=$requisition['requisition_no'] ?> </td>
							<td> <?=$requisition['department_name'] ?> </td>
							<td> <?=$requisition['created_at'] ?> </td>
							<td> <?=$requisition['step'] ?> of <?=$requisition['total_steps'] ?> 
								<?=$requisition['finance_approved'] ?> 
							</td>
							<td>
								<?=anchor('requisition/detail/'.$requisition['id'],'<button type="submit" class="btn-xs btn-success">View</button>')?>
							
							</td>
						</tr>
					<?php } ?>
				<?php } ?>
			</table>
		</div>
	</div>
</div>