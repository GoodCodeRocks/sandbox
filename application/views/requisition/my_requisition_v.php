<div class="right-panel" style="float: left; width: 80%; padding: 5px; margin: 5px;">
	<div class="container-fluid">
		<div class="panel panel-default" id="form">
			<div class="panel-heading">
				<div class="row">
					<div class="col-lg-1"><img alt="" src="<?=base_url('/assets/img/usc_logo.png')?>" style="width:300%;"></div>
					<div class="col-lg-8 col-lg-offset-1"><h3>University of the Southern Caribbean<br><small>Requisition Form</small></h3></div>
					<div class="col-lg-3" style="float:right;"><label>No:</label> ...............................</div>
				</div>
			</div>
			<div class="panel-body">
				<div class="form-group col-md-4" style="float:left;">
					<label>Supplier:</label>
					<input class="form-control" type="text" value="Niall Edwards">
				</div>
				<div class="form-group col-md-4" style="float:right;">
					<label>Date:</label>
					<input class="form-control" type="text" value="September 13, 2017">
				</div>
				<div class="form-group col-md-12" style="float:right;">
					<label>Payee:</label>
					<input class="form-control" type="text" value="Niall Edwards">
				</div>
				<table class="table-striped table-hover table-bordered" style="Width:100%; height: 100%;">
					<thead>
						<tr>
							<th style="width:5%;">Qty</th>
							<th style="width:80%;">Details</th>
							<th style="width:5%;">Unit Price</th>
							<th style="width:10%;">Cost</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>1</td>
							<td>Victor Flemming</td>
							<td>1939</td>
							<td>
								45.00
		            		</td>
						</tr>
						<tr>
							<td>2</td>
							<td>Carol Reed</td>
							<td>1949</td>
							<td>
								45.00
		            		</td>
						</tr>
						<tr>
							<td>3</td>
							<td>Orson Welles</td>
							<td>1941</td>
							<td>
								45.00
		            		</td>
						</tr>
						<tr>
							<td>4</td>
							<td>Orson Welles</td>
							<td>1941</td>
							<td>
								45.00
		            		</td>
						</tr>
					</tbody>
				</table>
				<hr>
				<div>
					<div style="width:60%; float:left;">
						<label>Department:</label>
						<input class="form-control" type="text" value="Information Technology">
					</div>
					<div style="width:40%; float:left;">
						<label>Purchase Order Required:</label>
						<input type="checkbox">
					</div>
					<div style="width:60%; float:left;">
						<label>Signature:</label>
						<input class="form-control" type="text" value="David Baynes">
					</div>
					<div style="width:40%; float:left;">
						<label>Special Request:</label>
						<input class="form-control" type="text" value="Information Technology">
					</div>
				</div>
				
				<div>
					<div style="width:60%; float:left;">
						<label>Finance Approval:</label>
						<input class="form-control" type="text" value="Information Technology">
					</div>
					<div style="width:40%; float:left;">
						<label>Bank Account:</label>
						<input class="form-control" type="text" value="Information Technology">
					</div>
					<div style="width:100%; float:left;">
						<label>Charge Account:</label>
						<input class="form-control" type="text" value="David Baynes">
					</div>
				</div>
			</div>
		</div>
		<div id="editor"></div>
		<button id="print">Print</button>
	</div>
</div>
