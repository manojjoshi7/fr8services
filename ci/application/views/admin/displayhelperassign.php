<div id="page-wrapper" >
     <div id="page-inner">
	 <div class="row">
                    <div class="col-lg-10">
                     <h2>Jobs for Helpers/Offsiders</h2>   
                    </div>
					<div class="col-lg-2">
                     <a href="<?php echo site_url('admin/helperassign'); ?>" class="btn btn-success">Assign Job</a>
					   
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
	 Role
	 </th>
	 <th>
	 Date
	 </th>
	 <th>
	 Action
	 </th>
	 
	 </thead>
	 <tbody>
	<?php
	foreach($assign as $row)
	{
echo "<tr><td>{$row->username}</td><td>{$row->rolename}</td><td>{$row->assigndate}</td><td><a href=".site_url('admin/edithelpertask/'.$row->id.'')." class='btn btn-success'>Edit</a>&nbsp;<a href=".site_url('admin/deletedata/'.$row->id.'/helperassign')." class='btn btn-danger deleteit'>Delete</a></td></tr>";
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