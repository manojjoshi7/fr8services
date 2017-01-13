  <div id="page-wrapper" >
     <div id="page-inner">
	 
	 <div class="row">
                    <div class="col-lg-12">
                     <h2>Update Clients Details</h2>   
                    </div>
                </div>
				
					
	<div class="row">
                    <div class="col-lg-12">
					
					 <?php 

$attributes = array('class' => '', 'id' => 'editcompanyform','name'=>'editcompanyform');
echo form_open('admin/companyedit',$attributes);
?>
<div class="form-group">
<label><?php echo form_label('Company Name', 'name');?></label>
 <?php echo form_error('companyname','<div class="alert alert-danger">','</div>');?>
 <?php

$data = array(
              'name'        => 'companyname',
			  'type'        => 'text',
              'id'          => 'companyname',
              'value'       => isset($companyinfo[0]->name)?$companyinfo[0]->name:set_value('companyname'),
              'maxlength'   => '1000',
              'size'        => '25',
			   'class'        => 'form-control',  
             
			  'required'=> 'required'
            );

echo form_input($data);
?>
</div>
<div class="form-group">
<label><?php echo form_label('Email', 'email');?></label>
 <?php echo form_error('companyemail','<div class="alert alert-danger">','</div>'); ?>
 <?php

$data = array(
              'name'        => 'companyemail',
			  'type'        => 'email',
              'id'          => 'companyemail',
              'value'       => isset($companyinfo[0]->email)?$companyinfo[0]->email:set_value('companyemail'),
              'maxlength'   => '1000',
              'size'        => '25',
			   'class'        => 'form-control',  
             
			  'required'=> 'required'
            );

echo form_input($data);
?>
</div>
<div class="form-group">
<label><?php echo form_label('Address', 'address');?></label>
<?php echo form_error('companyaddress','<div class="alert alert-danger">','</div>'); ?>
 <?php

$data = array(
              'name'        => 'companyaddress',
			  'id'          => 'companyaddress',
              'value'       => isset($companyinfo[0]->address)?$companyinfo[0]->address:set_value('companyaddress'),
              'maxlength'   => '1000',
              'size'        => '25',
			  'rows'=>5,
			   'class'        => 'form-control',  
             
			  'required'=> 'required'
            );

echo form_textarea($data);
?>
</div>
<div class="form-group">
<label><?php echo form_label('Phone Number', 'phone');?></label>
<?php echo form_error('companyphone','<div class="alert alert-danger">','</div>'); ?>
 <?php

$data = array(
              'name'        => 'companyphone',
			  'type'        => 'text',
              'id'          => 'companyphone',
              'value'       => isset($companyinfo[0]->phone_number)?$companyinfo[0]->phone_number:set_value('companyphone'),
              'maxlength'   => '1000',
              'size'        => '25',
			   'class'        => 'form-control',  
             
			  'required'=> 'required'
            );

echo form_input($data);
?>
</div>
					
<div class="form-group">
<label><?php echo form_label('AB number', 'number1');?></label>
<?php echo form_error('abnumber','<div class="alert alert-danger">','</div>'); ?>
  <?php
$data = array(
              'name'        => 'abnumber',
			  'type'        => 'text',
              'id'          => 'abnumber',
              'value'       => isset($companyinfo[0]->ab_number)?$companyinfo[0]->ab_number:set_value('abnumber'),
              'maxlength'   => '1000',
              'size'        => '25',
			   'class'        => 'form-control',  
             
			  'required'=> 'required'
            );

echo form_input($data);
?>
</div>
<div class="form-group">
<label><?php echo form_label('AC number', 'number2');?></label>
<?php echo form_error('acnumber','<div class="alert alert-danger">','</div>'); ?>
  <?php
$data = array(
              'name'        => 'acnumber',
			  'type'        => 'text',
              'id'          => 'acnumber',
              'value'       => isset($companyinfo[0]->ac_number)?$companyinfo[0]->ac_number:set_value('acnumber'),
              'maxlength'   => '1000',
              'size'        => '25',
			   'class'        => 'form-control',  
             
			  'required'=> 'required'
            );

echo form_input($data);
?>
</div>
<div class="form-group">
<label><?php echo form_label('Description', 'description');?></label>
<?php echo form_error('companydescription','<div class="alert alert-danger">','</div>'); ?>
 <?php

$data = array(
              'name'        => 'companydescription',
			  'id'          => 'companydescription',
              'value'       => isset($companyinfo[0]->description)?$companyinfo[0]->description:set_value('companydescription'),
              'maxlength'   => '1000',
              'size'        => '25',
			  'rows'=>5,
			   'class'        => 'form-control',  
             
			  'required'=> 'required'
            );

echo form_textarea($data);
?>
</div>	
<?php

$data = array(
              'name'        => 'companyid',
			  'type'        => 'hidden',
              'id'          => 'companyid',
              'value'       =>$companyid,              
			  
            );

echo form_input($data);
?>  				
 <?php echo form_submit('submitbut', 'Edit Company');?> <?php echo form_reset('reset1', 'reset');?> <?php echo form_close();?>					
</div>
	</div>							
				
	 </div>
  
  </div>
  </div>