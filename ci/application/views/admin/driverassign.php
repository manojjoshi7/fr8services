<div id="page-wrapper">
  <div id="page-inner">
    <div class="row">
      <div class="col-lg-12">
        <h2>Jobs for Drivers</h2>
      </div>
    </div>
    <hr />
    <div class="row">
      <?php
	  echo($this->session->flashdata('message_name')?$this->session->flashdata('message_name'):'');
	  ?>
	  <?php
	   echo isset($assignerror)?$assignerror:'';
	  ?>
      <div class="col-lg-12">
        <?php 
     $attributes = array('class' => '', 'id' => 'driverform','name'=>'driveform');
     echo form_open('admin/driverassign',$attributes);
    ?>
        <div class="form-group">
          <label><?php echo form_label('Driver Name', 'name');?></label>
          <br />
          <?php
$driver=array();
foreach($userinfo as $user)
{

$driver[$user->user_id]=$user->name;
}
echo form_dropdown('drivername', $driver);
?>
        </div>
        <br/>
        <div class="form-group">
          <label><?php echo form_label('Runs', 'role');?></label>
          <br />
          <?php
$roles=array();
foreach($roleinfo as $role)
{
$roles[$role->role_id]=$role->name;
}
echo form_dropdown('roleinfo', $roles);
?>
        </div>
        <br/>
        <div class="form-group">
          <label><?php echo form_label('Assign Date', 'date');?></label>
          <?php echo form_error('assigndate','<div class="alert alert-danger">','</div>'); ?>
          <div class="input-group date" data-provide="datepicker" style="width:460px;" data-date-multidate="true" data-date-format="mm-dd-yyyy" data-date-start-date="<?php echo date("m-d-Y"); ?>" >
            <?php

$data = array(
              'name'        => 'assigndate',
			  'type'        => 'text',
              'id'          => 'assigndate',
              'value'       => set_value('assigndate'),
              'maxlength'   => '60',
              'size'        => '25',
			   'class'        => 'form-control', 
			  'required'=> 'required'
            );

echo form_input($data);
?>
            <div class="input-group-addon"> <span class="glyphicon glyphicon-th"></span> </div>
          </div>
        </div>
        <?php echo form_submit('submitbut', 'Assign Run');?> <?php echo form_reset('reset1', 'reset');?> <?php echo form_close();?> </div>
    </div>
  </div>
</div>
