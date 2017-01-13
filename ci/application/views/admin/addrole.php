<div id="page-wrapper" >
     <div id="page-inner">
	<div class="row">
                    <div class="col-lg-12">
                     <h2>Add New 7-Eleven Run</h2>   
                    </div>
                </div>
				<hr />
				<div class="row">
                    <div class="col-lg-12">
				<?php echo $this->session->flashdata('message');?>
				</div>
				</div>
	<div class="row">
	<div class="col-lg-12">
	<?php 

$attributes = array('class' => '', 'id' => 'userform','name'=>'roleform');
echo form_open('admin/addrole',$attributes);
?>
<div class="form-group">
<label><?php echo form_label('Roll Name', 'name');?></label>
 <?php echo form_error('rolename','<div class="alert alert-danger">','</div>'); ?>
 <?php

$data = array(
              'name'        => 'rolename',
			  'type'        => 'text',
              'id'          => 'username',
              'value'       =>set_value('rolename'),
              'maxlength'   => '100',
              'size'        => '25',
			   'class'        => 'form-control',  
             
			  'required'=> 'required'
            );

echo form_input($data);
?>
</div>
<div class="form-group">
<label><?php echo form_label('Company Name', 'company');?></label>
 <br />
 <?php

$options = $company;

echo form_dropdown('companyname', $options);?>

</div>
<div class="form-group">
<label><?php echo form_label('Shift Time', 'time');?></label>
 <br />
 <?php

$options = array(
                  'evening'  => 'evening',
                  'morning'    => 'morning'
                );

echo form_dropdown('shifttime', $options);?>

</div>

<div class="form-group">
<label><?php echo form_label('Occupations', 'occupations');?></label>
<br/>
 <?php

$options = array(
                  'driver'  => 'driver',
                  'helper'    => 'helper'
                );

echo form_dropdown('useroccupations', $options);?>


</div>
<div class="form-group">
<label><?php echo form_label('Role Amount', 'amount');?></label>
 <?php echo form_error('role_amount','<div class="alert alert-danger">','</div>'); ?>
 <?php

$data = array(
              'name'        => 'role_amount',
			  'type'        => 'text',
              'id'          => 'role_amount',
              'value'       =>set_value('role_amount'),
              'maxlength'   => '100',
              'size'        => '25',
			   'class'        => 'form-control',  
             
			  'required'=> 'required'
            );

echo form_input($data);
?>
</div>
	<?php echo form_submit('submitbut', 'Add Roll');?> <?php echo form_reset('reset1', 'reset');?> <?php echo form_close();?>					
	</div>
	</div>			
	
	</div>
	</div>