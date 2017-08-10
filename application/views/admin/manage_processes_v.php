<div class="right-panel" style="float: left; width: 80%; padding: 5px; margin: 5px;">
	<div class="container">
		<div class="panel panel-default row">
			<div class="panel-heading"><h3>Manage Processes</h3></div>
			<div class="panel-body">
				<form class="container-fluid">
						<div class="row">
			            	<div class="form-group">
				            	<div class="col-md-12">
				            		<label for="processname">Process Name</label>
				            		<input type="text" class="form-control">
			            		</div>
			            		<div class="col-md-6">
				            		<input type="checkbox">
				            		<label for="academic">Academic</label>
				            		<input type="checkbox">
				            		<label for="nonacademic">Non-Academic</label>
				            	</div>
			            	</div>
			            	<div class="col-lg-4 col-lg-offset-10">
			            	<br>
			            		<button type="submit" class="btn-sm btn-success">Save</button>
			            		<button type="submit" class="btn-sm btn-danger">Cancel</button>
			            	</div>
			            </div> 
	            </form>
	            <hr>
	            <div class="container-fluid table-responsive">
					<div class="row">
		            	<table class="table-striped table-hover table-bordered col-md-12">
		            		<thead>
		            			<tr>
		            				<th>Process</th>
		            				<th>Action</th>
		            			</tr>
		            		</thead>
		            		<tbody>
		            			<tr>
		            				<td class="col-md-10">Main Academic</td>
		            				<td class="col-md-2"><a href="<?= base_url('index.php/welcome/updateprocess'); ?>">
		            				<button type="submit" class="btn-xs btn-success">Add/Edit</button></a>
		            				<button type="submit" class="btn-xs btn-danger">Delete</button></td>
		            			</tr>
		            			<tr>
		            				<td class="col-md-9">Main Non-Academic</td>
		            				<td class="col-md-3"><a href="<?= base_url('index.php/welcome/updateprocess'); ?>">
		            				<button type="submit" class="btn-xs btn-success">Add/Edit</button></a>
		            				<button type="submit" class="btn-xs btn-danger">Delete</button></td>
		            			</tr>
		            			<tr>
		            				<td class="col-md-9">Business Academic</td>
		            				<td class="col-md-3"><a href="<?= base_url('index.php/welcome/updateprocess'); ?>">
		            				<button type="submit" class="btn-xs btn-success">Add/Edit</button></a>
		            				<button type="submit" class="btn-xs btn-danger">Delete</button></td>
		            			</tr>
		            			<tr>
		            				<td class="col-md-9">It Non-Academic</td>
		            				<td class="col-md-3"><a href="<?= base_url('index.php/welcome/updateprocess'); ?>">
		            				<button type="submit" class="btn-xs btn-success">Add/Edit</button></a>
		            				<button type="submit" class="btn-xs btn-danger">Delete</button></td>
		            			</tr>
		            		</tbody>
		            	</table>
		            </div> 
	            </div>
            </div> 
		</div>
	</div>
</div>

	     

