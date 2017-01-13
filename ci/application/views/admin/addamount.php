<div id="page-wrapper" >
     <div id="page-inner">
	<div class="row">
                    <div class="col-lg-12">
                     <h2>Add Per hour Rate</h2>   
                    </div>
                </div>
				<hr />
				<div class="row">
                    <div class="col-lg-12">
				<?php //echo $this->session->flashdata('message');?>
				</div>
				</div>
	<div class="row">
	<div class="col-lg-12">
	<?php 

$attributes = array('class' => '', 'id' => 'addprice','name'=>'addprice');
echo form_open('admin/addhourlyprice',$attributes);
?>
<div class="form-group">
<?php echo form_error('useroccupations','<div class="alert alert-danger">','</div>'); ?>
<label><?php echo form_label('User Type', 'occupations');?></label>
<br/>
 <?php

$options = array(
                  'driver'  => 'driver',
                  'helper'    => 'helper'
                );

echo form_dropdown('useroccupations', $options);?>


</div>


<div class="form-group">
<label><?php echo form_label('Hourly Amount', 'amount');?></label>
 <?php echo form_error('hourly_amount','<div class="alert alert-danger">','</div>'); ?>
 <?php

$data = array(
              'name'        => 'hourly_amount',
			  'type'        => 'text',
              'id'          => 'hourly_amount',
              'value'       =>set_value('hourly_amount'),
              'maxlength'   => '100',
              'size'        => '25',
			   'class'        => 'form-control',  
             
			  'required'=> 'required'
            );

echo form_input($data);
?>
</div>
	<?php echo form_submit('submitbut', 'Add Amount');?> <?php echo form_reset('reset1', 'reset');?> <?php echo form_close();?>					
	</div>
	</div>			
	
	</div>
	</div>