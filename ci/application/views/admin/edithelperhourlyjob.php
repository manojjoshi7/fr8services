<div id="page-wrapper">
     <div id="page-inner">
	  <div class="row">
                    <div class="col-lg-12">
                     <h2>Assign Hourly Jobs (Day Work)</h2>   
                    </div>
                </div>
				<hr />
	<div class="row">
	
	<?php
	echo isset($assignerror)?$assignerror:'';
	?>
	<div class="col-lg-12">
	 <?php 
     $attributes = array('class' => '', 'id' => 'hourlyjobassign','name'=>'hourlyjobassign');
     echo form_open('admin/edithelperhourlyjob',$attributes);
    ?>
	<div class="form-group">
    <label><?php echo form_label('Helper', 'Helper');?></label>
	<br />
	<?php echo form_error('helpername','<div class="alert alert-danger">','</div>'); ?>
	  <?php
        $driver=array();
		foreach($drivers as $user)
		{
		$driver[$user->user_id]=$user->name;
		}
		$selectvalue=isset($data["hourlyjob"][0]->id)?$data["hourlyjob"][0]->id:set_value('drivername');	
		echo form_dropdown('helpername', $driver,$selectvalue);
        ?>
	 
	</div>
	<div class="form-group">
    <label><?php echo form_label('FR8 No', 'FR8 No');?></label>
	<br />
	<?php echo form_error('fr8_no','<div class="alert alert-danger">','</div>'); ?>
	  <?php
        $truckfr8_no=array();
		foreach($fr8_no as $getno)
		{
		$truckfr8_no[$getno->fr8_no]=$getno->fr8_no;
		}
	    $selectvalue=isset($data["hourlyjob"][0]->fr8no)?$data["hourlyjob"][0]->fr8no:set_value('fr8_no');	
		echo form_dropdown('fr8_no', $truckfr8_no,$selectvalue);
        ?>
</div>
	<div class="form-group">
    <label><?php echo form_label('Expected Time', 'Expected Time');?></label>
	<br />
<?php echo form_error('timepicker-one','<div class="alert alert-danger">','</div>'); ?>	
<?php

$data = array(
              'name'        => 'timepicker-one',
			  'type'        => 'text',
              'id'          => 'timepicker-one',
              'value'       =>isset($hourlyjob[0]->expectedtime)?$hourlyjob[0]->expectedtime:set_value('timepicker-one'),
              'maxlength'   => '100',
              'size'        => '25',
			   'class'        => 'form-control timepicker',  
             
			  'required'=> 'required'
            );

echo form_input($data);
?>

	 
	</div>
	<div class="form-group">
    <label><?php echo form_label('Start Form', 'Start Form');?></label>
	<br />
<?php echo form_error('startform','<div class="alert alert-danger">','</div>'); ?>		
<?php

$data = array(
              'name'        => 'startform',
			  'id'          => 'startform',
              'value'       =>isset($hourlyjob[0]->start_form)?$hourlyjob[0]->start_form:set_value('startform'),
              'maxlength'   => '1000',
              'size'        => '1000',
			  'class'        => 'form-control',  
             'required'=> 'required'
            );

echo form_textarea($data);
?>
	 
	</div>	
<div class="form-group">
    <label><?php echo form_label('Company For', 'Company For');?></label>
<br />
<?php echo form_error('company_for','<div class="alert alert-danger">','</div>'); ?>		
	  <?php
        $companyinfo=array();
		foreach($company as $getcompany)
		{
		$companyinfo[$getcompany->id]=$getcompany->name;
		}
		$selectvalue=isset($hourlyjob[0]->company_id)?$hourlyjob[0]->company_id:set_value('company_for');
		echo form_dropdown('company_for', $companyinfo,$selectvalue);
        ?>	 
	</div>
	
	<div class="form-group">
    <label><?php echo form_label('Role', 'Role');?></label>
	<br />
<?php echo form_error('truckrole','<div class="alert alert-danger">','</div>'); ?>			
	  <?php
        $truckrole=array();

		foreach($role_names as $role)
		{

		$truckrole[$role->id]=$role->role_name;
		}
	    $selectvalue=isset($hourlyjob[0]->truck_role_id)?$hourlyjob[0]->truck_role_id:set_value('truckrole');	
		echo form_dropdown('truckrole', $truckrole,$selectvalue);
        ?>	 
	</div>
	
   <div class="form-group">
    <label><?php echo form_label('Per Hour', 'Per Hour');?></label>
	<br />
<?php echo form_error('per_hour','<div class="alert alert-danger">','</div>'); ?>				
	 <?php

$data = array(
              'name'        => 'per_hour',
			  'type'        => 'text',
              'id'          => 'per_hour',
              'value'       =>isset($hourlyjob[0]->per_hour)?$hourlyjob[0]->per_hour:set_value('per_hour'),
              'maxlength'   => '100',
              'size'        => '25',
			   'class'        => 'form-control',  
             
			  'required'=> 'required'
            );

echo form_input($data);
?>

	</div>
	
	<div class="form-group">
    <label><?php echo form_label('Assign Dates', 'Assign Dates');?></label>
	
	<?php echo form_error('assigndate','<div class="alert alert-danger">','</div>'); ?>

<div class="input-group date" data-provide="datepicker" data-date-multidate="true" data-date-format="yyyy-mm-dd" data-date-start-date="<?php echo date("Y-m-d"); ?>">
     <?php

$data = array(
              'name'        => 'assigndate',
			  'type'        => 'text',
              'id'          => 'assigndate',
              'value'       => isset($hourlyjob[0]->assign_dates)?$hourlyjob[0]->assign_dates:set_value('assigndate'),
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
	 <div class="form-group">
    <label><?php echo form_label('Work Description', 'Work Description');?></label>
	<br />
<?php echo form_error('work_description','<div class="alert alert-danger">','</div>'); ?>					
<?php

$data = array(
              'name'        => 'work_description',
			  'id'          => 'work_description',
              'value'       =>isset($hourlyjob[0]->description)?$hourlyjob[0]->description:set_value('work_description'),
              'maxlength'   => '1000',
              'size'        => '25',
			   'class'        => 'form-control',  
             
			  'required'=> 'required'
            );

echo form_textarea($data);
?>

	</div>
	<?php

$data = array(
              'name'        => 'hourlyjobassignid',
			  'type'        => 'hidden',
              'id'          => 'hourlyjobassignid',
              'value'       =>$hourlyjobassignid,              
			  
            );

echo form_input($data);
?>
	<?php echo form_submit('submitbut', 'Add Job');?> <?php echo form_reset('reset1', 'reset');?> <?php echo form_close();?>					
	</div>
	</div>			
</div>
</div>