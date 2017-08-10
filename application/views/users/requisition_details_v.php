		<div class="right-panel" style="float: left; width: 80%; padding: 5px; margin: 5px;">
			<div class="container">
				<div class="panel panel-default row">
					<div class="panel-heading"><h3>My Requisitions</h3></div>
					<div class="panel-body">
            			<div class="row">
            			<?php //foreach ($Details as $detail) { ?>
            				<div class="col-md-4">
            					<label for="requisitionnumber">Requisition Number:</label>
				            		<input type="text" class="form-control" value="<?=$Details['requisition_no'] ?>">
            				</div>
            				<div class="col-md-4">
            					<label for="department">Department</label>
				            		<input type="text" class="form-control" value="<?=$Details['Department'] ?>">
            				</div>
            				<div class="col-md-4">
            					<label for="step">Step:</label>
				            		<input type="text" class="form-control" value="<?=$Details['name'] ?>">
            				</div>
            			<?php //}?>
						</div>
						<hr>
						<div class="row" id="tabs">
							<div class=" col-md-2 col-md-offset-10">
								<button type="submit" class="btn-xs btn-success">Save</button>
			            		<button type="submit" class="btn-xs btn-danger">Cancel</button>
			            	</div>
							<ul>
								<li><a href="#tabs-status">Status</a></li>
								<li><a href="#tabs-items">Items</a></li>
							    <li><a href="#tabs-invoice">Invoice</a></li>
							</ul>
							<div class="row"  id="tabs-status">
								<div class="col-md-6">
	            					<label for="approvedby">Approved By:</label>
					            		<input type="text" class="form-control" value="Jeneema Beharry">
				            		<label for="position">Position:</label>
				            			<input type="text" class="form-control" value="Administrative Assistant">
				            		<label for="department">Department:</label>
					            		<input type="text" class="form-control" value="IT">
				            		<label for="date">Created By:</label>
					            		<input type="text" class="form-control" value="07/08/2017">
	            				</div>
	            				<div class="col-md-6">
	            					<label for="awaitingapprovalfrom">Awaiting Approval from:</label>
					            		<input type="text" class="form-control" value="David Baynes">
				            		<label for="position2">Position:</label>
				            			<input type="text" class="form-control" value="Director">
				            		<label for="department2">Department:</label>
					            		<input type="text" class="form-control" value="IT">
	            				</div>
							</div>
							<div id="tabs-items">
							    <div class="col-md-6">
	            					<label for="itemname">Item Name:</label>
					            		<input type="text" class="form-control" value="Office Desk">
				            	</div>
				            	<div class="col-md-6">
	            					<label for="itemcategory">Category:</label>
		            					<input type="text" class="form-control" value="Office Furniture">
				            	</div>
				            	<div class="col-md-6">
		            				<label for="quantity">Quantity:</label>
				            		<input type="text" class="form-control" value="4">
					            </div>
					            <div class="col-md-6">
		            				<label for="unitcost">Unit Cost:</label>
				            		<input type="text" class="form-control" value="$0.00">
					            </div>
				            	<div class="col-md-6 col-md-offset-3">
		            				<label for="cumulativecost">CumulativeCost:</label>
				            		<input type="text" class="form-control" value="$0.00">
					            </div>
					            <hr>
					            <div class=" col-md-2 col-md-offset-10">
									<button type="submit" class="btn-xs btn-success">Save</button>
				            		<button type="submit" class="btn-xs btn-danger">Cancel</button>
			            		</div>
					            
							</div>
						  	<div id="tabs-invoice">
						  	<?php echo form_open_multipart('requisition/purchaseOrder_upload/'.$this->uri->segment(3))?>
								<div class="row">
									<div class="col-md-4">
									<label for="cumulativecost">Select Upload File:</label>
									    	<input type="file" class="validate btn btn-default btn-file" name="purord" id="purord" >
									</div>
								</div>
								
								<br/>
								<div class="row">
									<div class="col-md-4 col-md-offset-11">
										<label class="btn btn-default btn-file">
									    	Upload <input type="submit" class="hidden">
										</label>
									</div>
								</div>
								<?php echo form_close();?>
						  	</div>
						</div>
						
						<hr>
						<div class="row">
	            			<table class="table-striped table-hover table-bordered " style="Width:100%; height: 100%;">
								<tr>
									<th>Item Description</th>
									<th>Category</th>
									<th>Quantity</th>
									<th>Unit Cost</th>
									<th>Cumulative Cost</th>
								</tr>
								<tr>
									<td>The Wizard of Oz</td>
									<td>Victor Flemming</td>
									<td>2</td>
									<td>$34.50</td>
									<td>$67.00</td>
								</tr>
								<tr>
									<td>The Third Man</td>
									<td>Carol Reed</td>
									<td>2</td>
									<td>$34.50</td>
									<td>$67.00</td>
								</tr>
								<tr>
									<td>Citizen Kane</td>
									<td>Orson Welles</td>
									<td>2</td>
									<td>$34.50</td>
									<td>$67.00</td>
								</tr>
								<tr>
									<td>Citizen Kane</td>
									<td>Orson Welles</td>
									<td>2</td>
									<td>$34.50</td>
									<td>$67.00</td>
								</tr>
							</table>
						</div>
						
	            	</div>
            	</div>
			</div>
		</div>
		