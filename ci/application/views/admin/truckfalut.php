<div id="page-wrapper" >
     <div id="page-inner">
	 <div class="row">
                    <div class="col-lg-10">
                     <h2>Support Issues</h2>   
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
<div class="row">
<div class="col-lg-12">
					
	 <table class="table">
	 <thead>
	 <th>
	 User Name
	 </th>
	 <th>
	 Store Number
	 </th>
	 <th>
     Run Name
	 </th>
	 <th>
	 Issue
	 </th>
	 <th>
	 Image
	 </th>
	 <th>
	 Action
	 </th>
	 </thead>
	 <tbody>
	<?php
	foreach($truckinfo as $row)
	{
    $imginfo= explode('.',$row->image_name);
	$imagename=$imginfo[0].'_thumb.'.$imginfo[1];
echo "<tr><td>{$row->name}</td><td>{$row->store_number}</td><td>{$row->run_name}</td><td>{$row->problem}</td><td><div class='img1'><a href='#myModal' data-toggle='modal' onclick='dispalyimagepopup(\"truckimg\",{$row->id})'><img style='width:50px; height:50px;' src=".site_url('assets/uploadimage/email/thumb/'.$imagename.'')." width='100px' height='100px'/></a></div></td><td><a  href=".site_url('admin/deletedata/'.$row->id.'/truck_fault')." class='btn btn-danger deleteit'>Delete</a></td></tr>";
	}
	?>
	
	 </tbody>
	 </table>
	 </div>
	 </div>
	 <div class="row">
	 <div class="col-lg-4">
	 <input type="hidden" value="<?php echo base_url();?>" name="baseurl" id="baseurl"/>
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