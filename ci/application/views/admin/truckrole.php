<div id="page-wrapper">
     <div id="page-inner">
	 <br/>
	  <div class="row">
                    <div class="col-lg-12">
                     <h2>Truck Roles</h2>   
                    </div>
                </div>
				<hr />
				<div class="row">
                    <div class="col-lg-12">
				<?php echo $this->session->flashdata('message');?>
				</div>
				</div>
	
	<div class="row">
	 <?php 
     $attributes = array('class' => '', 'id' => 'truckrole','name'=>'truckrole');
     echo form_open('admin/truckrole',$attributes);
    ?>
	<div class="col-lg-4">Role Name</div><div class="col-lg-4">
	<?php echo form_error('truckrole','<div class="alert alert-danger">','</div>'); ?>
	<?php

$data = array(
              'name'        => 'truckrole',
			  'type'        => 'text',
              'id'          => 'truckrole',
              'value'       => isset($rolenameinfo[0]->role_name)?$rolenameinfo[0]->role_name:set_value('truckrole'),
              'maxlength'   => '1000',
              'size'        => '25',
              'class'        => 'form-control',  
             
			  'required'=> 'required'
            );

echo form_input($data);
?></div><div class="col-lg-4"><?php echo(isset($truckroleid) && !empty($truckroleid)?form_submit('submitbut', 'Edit Role'):form_submit('submitbut', 'Add Role'));?> <?php echo form_reset('reset1', 'reset');?></div>
	<?php 

	if(isset($truckroleid))
	{
	
	     $data = array(
              'name'        => 'truckroleid',
			  'type'        => 'hidden',
              'id'          => 'truckroleid',
              'value'       =>$truckroleid,              
			  
            );

         echo form_input($data);
	}

	echo form_close();?>
	</div>
<div class="col-rg-3">
&nbsp;
	 </div>
<div class="row">
<div class="col-lg-3">&nbsp;</div>
<div class="col-lg-6">
				
	 <table class="table">
	 <thead>
	 <th>
	 Role Name
	 </th>
	 <th>
	 Action
	 </th>
	 </thead>
	 <tbody>
	<?php
	foreach($trackrole as $row)
	{
	
echo "<tr><td>{$row->role_name}</td><td><a class='btn btn-success' href=".site_url('admin/truckrole/'.$row->id.'/edit').">Edit</a>&nbsp;<a href=".site_url('admin/deletedata/'.$row->id.'/truckrole')." class='btn btn-danger deleteit'>Delete</a></td></tr>";
	}
	?>
	
	 </tbody>
	 </table>
	 </div>
	 <div class="col-rg-3">&nbsp;</div>
	 </div>
	 <div class="row">
	 <div class="col-lg-3">
	 	 &nbsp;
	 </div>
	 <div class="col-lg-6">
	 <?php echo $links; ?>
	 </div>
	 <div class="col-lg-3">
	 &nbsp;
	 </div>
	 </div>
	</div>			
</div>
</div>