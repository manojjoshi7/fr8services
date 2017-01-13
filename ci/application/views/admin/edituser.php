  <div id="page-wrapper" >
     <div id="page-inner">
	 
	 <div class="row">
                    <div class="col-lg-12">
                     <h2>Edit User</h2>   
                    </div>
                </div>
				<hr />
					
	<div class="row">
                    <div class="col-lg-12">
					
					 <?php 

$attributes = array('class' => '', 'id' => 'edituserform','name'=>'edituserform');
echo form_open('admin/edituser',$attributes);
?>
<div class="form-group">
<label><?php echo form_label('Name', 'name');?></label>
 <?php echo form_error('username','<div class="alert alert-danger">','</div>');?>
 <?php

$data = array(
              'name'        => 'username',
			  'type'        => 'text',
              'id'          => 'username',
              'value'       =>isset($userinfo[0]->name)?$userinfo[0]->name:set_value('username'),
              'maxlength'   => '1000',
              'size'        => '25',
			   'class'        => 'form-control',  
             
			  'required'=> 'required'
            );

echo form_input($data);
?>
</div>

<div class="form-group">
<label><?php echo form_label('License number', 'license_number');?></label>
 <?php echo form_error('userlincese','<div class="alert alert-danger">','</div>'); ?>
 <?php

$data = array(
              'name'        => 'userlincese',
			  'type'        => 'text',
              'id'          => 'userlincese',
              'value'       =>isset($userinfo[0]->license_number)?$userinfo[0]->license_number:set_value('userlincese'),
              'maxlength'   => '1000',
              'size'        => '25',
			   'class'        => 'form-control',  
             
			  'required'=> 'required'
            );

echo form_input($data);
?>
</div>
<div class="form-group">
<label><?php echo form_label('Mobile', 'mobile');?></label>
 <?php echo form_error('usermobile','<div class="alert alert-danger">','</div>'); ?>
 <?php

$data = array(
              'name'        => 'usermobile',
			  'type'        => 'text',
              'id'          => 'usermobile',
              'value'       => isset($userinfo[0]->mobile)?$userinfo[0]->mobile:set_value('usermobile'),
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
 <?php echo form_error('useremail','<div class="alert alert-danger">','</div>'); ?>
 <?php

$data = array(
              'name'        => 'useremail',
			  'type'        => 'email',
              'id'          => 'useremail',
              'value'       =>isset($userinfo[0]->email)?$userinfo[0]->email:set_value('useremail'),
              'maxlength'   => '1000',
              'size'        => '25',
			   'class'        => 'form-control',  
             
			  'required'=> 'required'
            );

echo form_input($data);
?>
</div>
<div class="form-group">
<label><?php echo form_label('Occupations', 'occupations');?></label>
<br/>
 <?php

$options = array(
                  'driver'  => 'driver',
                  'helper'    => 'helper',
				  'staff'=>'staff'
                );
$selectvalue=isset($userinfo[0]->occupation)?$userinfo[0]->occupation:set_value('useroccupations');
echo form_dropdown('useroccupations', $options,$selectvalue);?>
</div>
<div class="form-group">
<label><?php echo form_label('Account number 1', 'bsb');?></label>
 <?php echo form_error('userbsb','<div class="alert alert-danger">','</div>'); ?>
 <?php

$data = array(
              'name'        => 'userbsb',
			  'type'        => 'text',
              'id'          => 'userbsb',
              'value'       =>isset($userinfo[0]->bsb)?$userinfo[0]->bsb:set_value('userbsb'),
              'maxlength'   => '1000',
              'size'        => '25',
			   'class'        => 'form-control',  
             
			  'required'=> 'required'
            );

echo form_input($data);
?>
</div>
<div class="form-group">
<label><?php echo form_label('Account number 2', 'acc');?></label>
 <?php echo form_error('useracc','<div class="alert alert-danger">','</div>'); ?>
 <?php

$data = array(
              'name'        => 'useracc',
			  'type'        => 'text',
              'id'          => 'useracc',
              'value'       => isset($userinfo[0]->acc)?$userinfo[0]->acc:set_value('useracc'),
              'maxlength'   => '1000',
              'size'        => '25',
			   'class'        => 'form-control',  
             

            );

echo form_input($data);
?>
</div>					
					
<!--<div class="form-group">
<label><?php //echo form_label('Type', 'type');?></label>
 <br/>
 <?php
/*
$options = array(
                  'old'  => 'old',
                  'new'    => 'new'
                );
$selectvalue2=isset($userinfo[0]->type)?$userinfo[0]->type:set_value('usertype');
echo form_dropdown('usertype', $options,$selectvalue2);
*/
?>
</div>
-->
<div class="form-group">
    <label><?php echo form_label('Enter Fix Amount', 'fix_amount');?></label>
	<?php echo form_error('assignfixamount','<div class="alert alert-danger">','</div>'); ?>
<?php
           $data = array(
              'name'        => 'assignfixamount',
			  'type'        => 'text',
              'id'          => 'assignfixamount',
              'value'       => isset($userinfo[0]->fix_amount)?$userinfo[0]->fix_amount:set_value('assignfixamount'),
              'maxlength'   => '100',
              'size'        => '25',
			   'class'        => 'form-control',  
             

            );

echo form_input($data);
?>
    

	 
	</div>	
<?php

$data = array(
              'name'        => 'userid',
			  'type'        => 'hidden',
              'id'          => 'userid',
              'value'       =>$userid,              
			  
            );

echo form_input($data);
?>  				
 <?php echo form_submit('submitbut', 'Edit User');?> <?php echo form_reset('reset1', 'reset');?> <?php echo form_close();?>					
</div>
	</div>							
				
	 </div>
  
  </div>
  </div>