  <div id="page-wrapper" >
     <div id="page-inner">
	 
	 <div class="row">
                    <div class="col-lg-12">
                     <h2>Add New Client</h2>   
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

$attributes = array('class' => '', 'id' => 'companyform','name'=>'companyform');
echo form_open('admin/addcompany',$attributes);
?>
<div class="form-group">
<label><?php echo form_label('Company Name', 'name');?></label>
 <?php echo form_error('companyname','<div class="alert alert-danger">','</div>');?>
 <?php

$data = array(
              'name'        => 'companyname',
			  'type'        => 'text',
              'id'          => 'companyname',
              'value'       => set_value('companyname'),
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
              'value'       => set_value('companyemail'),
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
              'value'       => set_value('companyaddress'),
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
              'value'       => set_value('companyphone'),
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
              'value'       => set_value('abnumber'),
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
              'value'       => set_value('acnumber'),
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
              'value'       => set_value('companydescription'),
              'maxlength'   => '1000',
              'size'        => '25',
			  'rows'=>5,
			   'class'        => 'form-control',  
             
			  'required'=> 'required'
            );

echo form_textarea($data);
?>
</div>					
 <?php echo form_submit('submitbut', 'Add Company');?> <?php echo form_reset('reset1', 'reset');?> <?php echo form_close();?>					
</div>
	</div>							
				
	 </div>
  
  </div>
  </div>