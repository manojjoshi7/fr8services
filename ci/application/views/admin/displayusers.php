<div id="page-wrapper" >
     <div id="page-inner">
	 <div class="row">
                    <div class="col-lg-10">
                     <h2>Emplyoyee List</h2> 
					   
                    </div><div class="col-lg-2">
                     <a href="<?php echo site_url('admin/adduser'); ?>" class="btn btn-success">Add New Employee</a>
					   
                    </div>
                </div>
				<hr />
	<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog" style="width:70%!important;">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
       
      </div>
      <div class="modal-body">
        
		<p id="modaltime" style="text-align:center;"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>			
    <!-- Modal HTML -->
<div class="row">
<div class="col-lg-12">
	<div class="table-responsive">
	 <table class="table table-striped">
	 <thead>
	 <th>
	 Name
	 </th>
	 <th>
	 License_Number
	 </th>
	 <th>
	 Mobile
	 </th>
	 <th>
	 Account number
	 </th>
     <th>
	 Email
	 </th>
	 <th>
	 Occuption
	 </th>
	 <th>
	 Lincense_Image
	 </th>
     <th>
	 Action
	 </th>
	 </thead>
	 <tbody>
	<?php
	foreach($users as $row)
	{

	$img=$row->license_number."_thumb.jpg";
	
	$imgpath=empty($row->imagename)?'':"<img src=".site_url('assets/uploadimage/thumb/'.$img.'')." width='100px' height='100px'/>";
echo "<tr><td style='text-transform:capitalize'>{$row->name}</td><td>{$row->license_number}</td><td>{$row->mobile}</td><td>{$row->bsb},
{$row->acc}</td><td style='text-transform:lowercase'>{$row->email}</td><td style='text-transform:capitalize'>{$row->occupation}</td><td class='img1'><a href='#myModal' data-toggle='modal' 
onclick='dispalyimagepopup(\"users\",{$row->license_number})'>".$imgpath."</a></td><td><a class='btn btn-success' href=".site_url('admin/edituser/'.$row->user_id.'')." >Edit</a>&nbsp;<a href=".site_url('admin/deletedata/'.$row->user_id.'/user')." class='btn btn-danger deleteit'>Delete</a></td></tr>";
	}
	?>
	
	 </tbody>
	 </table>
	 </div>
	 </div>
	 
	 </div>
	 
	 <div class="row">
	 <div class="col-lg-4">
&nbsp;
	 </div>
	 <div class="col-lg-4">
	 <input type="hidden" value="<?php echo base_url();?>" name="baseurl" id="baseurl"/>
	 <?php 
	 
	 echo $links; 
	 ?>
	 </div>
	 <div class="col-lg-4">
	 &nbsp;
	 </div>
	 </div>
	</div>
</div>
