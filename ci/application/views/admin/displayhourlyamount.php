<div id="page-wrapper" >
     <div id="page-inner">
	 <div class="row">
                    <div class="col-lg-10">
                     <h2>Hourly Amount</h2>   
                    </div>
					
                </div>
				<hr />
<div class="row">
<div class="col-lg-12">
					
	 <table class="table">
	 <thead>
	 <th>
	User Type
	 </th>
	 <th>
	 Hourly Amount
	 </th>
	 <th>
	 Edit
	 </th>
	 <th>
	 Delete
	 </th>
	 
	 </thead>
	 <tbody>
	<?php
	foreach($hourlyamount as $row)
	{
echo "<tr><td>{$row->user_type}</td><td>{$row->prices}</td><td><a class='btn btn-success' href='javascript:void(0);'>Edit</a></td><td><a  href=".site_url('admin/deletedata/'.$row->id.'/hourly_prices')." class='btn btn-danger deleteit'>Delete</a></td></tr>";
	}
	?>
	
	 </tbody>
	 </table>
	 </div>
	 </div>
	 
	</div>
</div>