<div id="page-wrapper" >
     <div id="page-inner">
	 <div class="row">
                    <div class="col-lg-10">
                     <h2>Fleet/Truck List</h2>   
                    </div>
					<div class="col-lg-2">
                     <a href="<?php echo site_url('admin/addtruck'); ?>" class="btn btn-success">Add New Fleet/Truck</a>
					   
                    </div>
                </div>
				<hr />
<div class="row">
<div class="col-lg-12">
				
	 <table class="table">
	 <thead>
	 <th>
     FR8 No
	 </th>
	 <th>
	 GVM
	 </th>
	 <th>
	 Tweight
	 </th>
	 <th>
	 Pallets
	 </th>
	 <th>
	 Rego Expire
	 </th>
	 <th>
	 Days Remains
	 </th>
	 <th>
	 Fleet No.
	 </th>
	 <th>
	 License
	 </th>
	 <th>
	 Action
	 </th>
	 </thead>
	 <tbody>
	<?php
	$hold_truckinfo=array();
	foreach($truckinfo as $row)
	{
	    $daysremains=($row->day<=0?'expired':$row->day." Days");	
echo "<tr><td>{$row->feed_no}</td><td>{$row->gvm}</td><td>{$row->tweight}</td><td>{$row->pallets}</td><td>{$row->rego_expire}</td><td>{$daysremains}</td><td>{$row->fr8_no}</td><td>{$row->license}</td><td><a class='btn btn-success' href=".site_url('admin/truckedit/'.$row->id.'').">Edit</a>&nbsp;<a href=".site_url('admin/deletedata/'.$row->id.'/truck_info')." class='btn btn-danger deleteit'>Delete</a></td></tr>";
	}
	?>
	
	 </tbody>
	 </table>
	 </div>
	 </div>
	 <div class="row">
	 <div class="col-lg-4">
	 	 &nbsp;
	 </div>
	 <div class="col-lg-4">
	 <?php echo $links; ?>
	 </div>
	 <div class="col-lg-4">
	 &nbsp;
	 </div>
	 </div>
	</div>
</div>