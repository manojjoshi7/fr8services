<div id="page-wrapper">
     <div id="page-inner">
	  <div class="row">
                    <div class="col-lg-12">
                     <h2>Assign Task For Helper</h2>   
                    </div>
                </div>
				<hr />
	<div class="row">
	
	<?php
	
	echo isset($assignerror)?$assignerror:'';
	?>
	<div class="col-lg-12">
	 <?php 
     $attributes = array('class' => '', 'id' => 'driverform','name'=>'driveform');
     echo form_open('admin/edithelpertask',$attributes);
    ?>
	<div class="form-group">
    <label><?php echo form_label('Helper Name', 'name');?></label>
	<br />
	 <?php
	 $selectoption =isset($assigntask[0]->user_id)?$assigntask[0]->user_id:set_value('helpername');
$helper=array();
foreach($userinfo as $user)
{
$helper[$user->user_id]=$user->name;
}
echo form_dropdown('driverorhelpername', $helper,$selectoption);
?>
	 
	</div>
	<br/>
	<div class="form-group">
    <label><?php echo form_label('Helper Roles', 'role');?></label>
	<br />
	 <?php
	 $selectoption =isset($assigntask[0]->role_id)?$assigntask[0]->role_id:set_value('roleinfo');
$roles=array();
foreach($roleinfo as $role)
{
$roles[$role->role_id]=$role->name;
}
echo form_dropdown('roleinfo', $roles,$selectoption);
?>
	 
	</div>
	<br/>
	
	
	<div class="form-group">
    <label><?php echo form_label('Assign Date', 'date');?></label>
	<?php echo form_error('assigndate','<div class="alert alert-danger">','</div>'); ?>

<div class="input-group date" data-provide="datepicker" data-date-multidate="true" data-date-format="mm-dd-yyyy" data-date-start-date="<?php echo date("m-d-Y"); ?>">
     <?php
$selectdate=isset($assigntask[0]->assign_date)?$assigntask[0]->assign_date:set_value('assigndate');
$data = array(
              'name'        => 'assigndate',
			  'type'        => 'text',
              'id'          => 'assigndate',
              'value'       => $selectdate,
              'maxlength'   => '60',
              'size'        => '25',
			   'class'        => 'form-control',  
             
			  'required'=> 'required'
            );

echo form_input($data);
?>
    <div class="input-group-addon">
        <span class="glyphicon glyphicon-th"></span>
    </div>
</div>
	 
	</div>
	<?php 
	$data = array(
              'name'        => 'assigntaskid',
			  'type'        => 'hidden',
              'id'          => 'assigntaskid',
              'value'       =>$taskid,              
			  
            );

echo form_input($data);
	
	echo form_submit('submitbut', 'Edit Assign Role');?> <?php echo form_reset('reset1', 'reset');?> <?php echo form_close();?>					
	</div>
	</div>			
</div>
</div>