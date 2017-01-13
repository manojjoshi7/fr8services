  <div id="page-wrapper" >
     <div id="page-inner">
	 
	 <div class="row">
                    <div class="col-lg-12">
                     <h2>Add  New Employe</h2>   
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

$attributes = array('class' => '', 'id' => 'userform','name'=>'userform');
echo form_open('admin/adduser',$attributes);
?>
<div class="form-group">
<label><?php echo form_label('Name', 'name');?></label>
 <?php echo form_error('username','<div class="alert alert-danger">','</div>');?>
 <?php

$data = array(
              'name'        => 'username',
			  'type'        => 'text',
              'id'          => 'username',
              'value'       => set_value('username'),
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
              'value'       => set_value('userlincese'),
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
              'value'       => set_value('usermobile'),
              'maxlength'   => '1000',
              'size'        => '25',
			   'class'        => 'form-control',  
             
			  'required'=> 'required'
            );

echo form_input($data);
?>
</div>
<div class="form-group">
<label><?php echo form_label('Password', 'password');?></label>
 <?php echo form_error('userpassword','<div class="alert alert-danger">','</div>'); ?>
 <?php

$data = array(
              'name'        => 'userpassword',
			  'type'        => 'text',
              'id'          => 'userpassword',
              'value'       => set_value('userpassword'),
              'maxlength'   => '1000',
              'size'        => '25',
			   'class'        => 'form-control',  
             
			  'required'=> 'required'
            );

echo form_input($data);
?>
</div>
<div class="form-group">
<label><?php echo form_label('Confirm Password', 'confirmpassword');?></label>
 <?php echo form_error('userconfirmpassword','<div class="alert alert-danger">','</div>'); ?>
 <?php

$data = array(
              'name'        => 'userconfirmpassword',
			  'type'        => 'text',
              'id'          => 'userconfirmpassword',
              'value'       => set_value('userconfirmpassword'),
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
              'value'       => set_value('useremail'),
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

echo form_dropdown('useroccupations', $options);?>
</div>
<div class="form-group">
<label><?php echo form_label('Account number 1', 'bsb');?></label>
 <?php echo form_error('userbsb','<div class="alert alert-danger">','</div>'); ?>
 <?php

$data = array(
              'name'        => 'userbsb',
			  'type'        => 'text',
              'id'          => 'userbsb',
              'value'       => set_value('userbsb'),
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
              'value'       => set_value('useracc'),
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

/*$options = array(
                  'old'  => 'old',
                  'new'    => 'new'
                );
*/
//echo form_dropdown('usertype', $options);
?>
</div>
--><div class="form-group">
    <label><?php echo form_label('Extra amount', 'fix_amount');?></label>
	<?php echo form_error('assignfixamount','<div class="alert alert-danger">','</div>'); ?>


     <?php

$data = array(
              'name'        => 'assignfixamount',
			  'type'        => 'text',
              'id'          => 'assignfixamount',
              'value'       => set_value('assignfixamount'),
              'maxlength'   => '100',
              'size'        => '25',
			   'class'        => 'form-control',  
             

            );

echo form_input($data);
?>
    
</div>	
				
 <?php echo form_submit('submitbut', 'Add User');?> <?php echo form_reset('reset1', 'reset');?> <?php echo form_close();?>					
</div>
	</div>							
				
	 </div>
  
  </div>
  </div>