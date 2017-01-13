<div id="page-wrapper" >
     <div id="page-inner">
	 <div class="row">
                    <div class="col-lg-10">
                     <h2>7-Eleven Run List</h2>   
                    </div>
					<div class="col-lg-2">
                     <a href="<?php echo site_url('admin/addrole'); ?>" class="btn btn-success">Add New 7-Eleven Run</a>
					   
                    </div>
                </div>
				<hr />
<div class="row">
<div class="col-lg-12">
					
	 <table class="table">
	 <thead>
	 <th>
	 Name
	 </th>
	 <th>
	 Shift Time
	 </th>
	 <th>
	 Occuption
	 </th>
	 <th>
	 Role Amount
	 </th>
	 <th>
	 Action
	 </th>
	 </thead>
	 <tbody>
	<?php
	foreach($roles as $row)
	{
echo "<tr><td>{$row->name}</td><td>{$row->shift_time}</td><td>{$row->occupation}</td><td>{$row->amount}</td><td><a class='btn btn-success' href=".site_url('admin/editrole/'.$row->role_id.'')." >Edit</a>&nbsp;<a  href=".site_url('admin/deletedata/'.$row->role_id.'/role')." class='btn btn-danger deleteit'>Delete</a></td></tr>";
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