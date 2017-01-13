<div id="page-wrapper" >
     <div id="page-inner">
	 <div class="row">
                    <div class="col-lg-10">
                     <h2>Clients List</h2>   
                    </div>
					<div class="col-lg-2">
                     <a href="<?php echo site_url('admin/addcompany'); ?>" class="btn btn-success">Add Company</a>
					   
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
	 Email
	 </th>
	 	 <th>
	 Address
	 </th>
	 	 <th>
	 Phone Number
	 </th>
	 	 <th>
	ABN
	 </th>
	 	 	 <th>
	ACN
	 </th>
	 <th>
	 Description
	 </th>
	 <th>
	 Action
	 </th>
	 </thead>
	 <tbody>
	<?php
	foreach($company as $row)
	{
	
echo "<tr><td>{$row->name}</td><td>{$row->email}</td><td>{$row->address}</td><td>{$row->phone_number}</td><td>{$row->ab_number}</td><td>{$row->ac_number}</td><td>{$row->description}</td><td><a class='btn btn-success' href=".site_url('admin/companyedit/'.$row->id.'').">Edit</a>&nbsp;<a href=".site_url('admin/deletedata/'.$row->id.'/company')." class='btn btn-danger deleteit'>Delete</a></td></tr>";
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