  <div id="page-wrapper" >
     <div id="page-inner">
	 
	 <div class="row">
                    <div class="col-lg-12">
                     <h2>Add Truck</h2>   
                    </div>
                </div>
<div class="row">
                    <div class="col-lg-12">

					 <?php 

$attributes = array('class' => '', 'id' => 'truckform','name'=>'truckform','method'=>'post');
echo form_open('admin/truckedit',$attributes);
?>
<div class="form-group">
<label><?php echo form_label('Feed No', 'Feed No');?></label>
 <?php echo form_error('feed_no','<div class="alert alert-danger">','</div>');?>
 <?php

$data = array(
              'name'        => 'feed_no',
			  'type'        => 'text',
              'id'          => 'feed_no',
              'value'       => isset($truckinfo[0]->feed_no)?$truckinfo[0]->feed_no:set_value('feed_no'),
              'maxlength'   => '1000',
              'size'        => '25',
			   'class'        => 'form-control',  
             
			  'required'=> 'required'
            );

echo form_input($data);
?>
</div>
<div class="form-group">
<label><?php echo form_label('GVM', 'GVM');?></label>
 <?php echo form_error('gvm','<div class="alert alert-danger">','</div>'); ?>
 <?php

$data = array(
              'name'        => 'gvm',
			  'type'        => 'text',
              'id'          => 'gvm',
              'value'       => isset($truckinfo[0]->gvm)?$truckinfo[0]->gvm:set_value('gvm'),
              'maxlength'   => '1000',
              'size'        => '25',
			   'class'        => 'form-control',  
             
			  'required'=> 'required'
            );

echo form_input($data);
?>
</div>
<div class="form-group">
<label><?php echo form_label('Tweight', 'Tweight');?></label>
 <?php echo form_error('truck_tweight','<div class="alert alert-danger">','</div>'); ?>
 <?php

$data = array(
              'name'        => 'truck_tweight',
			  'type'        => 'text',
              'id'          => 'truck_tweight',
              'value'       =>  isset($truckinfo[0]->tweight)?$truckinfo[0]->tweight:set_value('truck_tweight'),
              'maxlength'   => '1000',
              'size'        => '25',
			   'class'        => 'form-control',  
             
			  'required'=> 'required'
            );

echo form_input($data);
?>
</div>
<div class="form-group">
<label><?php echo form_label('Pallets', 'Pallets');?></label>
 <?php echo form_error('truck_pallets','<div class="alert alert-danger">','</div>'); ?>
 <?php

$data = array(
              'name'        => 'truck_pallets',
			  'type'        => 'text',
              'id'          => 'truck_pallets',
              'value'       => isset($truckinfo[0]->pallets)?$truckinfo[0]->pallets:set_value('truck_pallets'),
              'maxlength'   => '1000',
              'size'        => '25',
			   'class'        => 'form-control',  
             
			  'required'=> 'required'
            );

echo form_input($data);
?>
</div>
<div class="form-group">
<label><?php echo form_label('Rego Expire', 'Rego Expire');?></label>
 <?php echo form_error('rego_expire','<div class="alert alert-danger">','</div>'); ?>
<div class="input-group date" data-provide="datepicker"  data-date-format="yyyy-mm-dd" data-date-start-date="<?php echo date("m-d-Y"); ?>">
<?php

$data = array(
              'name'        => 'rego_expire',
			  'type'        => 'text',
              'id'          => 'rego_expire',
              'value'       =>isset($truckinfo[0]->rego_expire)?$truckinfo[0]->rego_expire:set_value('rego_expire'),
              'maxlength'   => '1000',
              'size'        => '25',
			   'class'        => 'form-control',  
             
			  'required'=> 'required'
            );

echo form_input($data);
?>    <div class="input-group-addon">
        <span class="glyphicon glyphicon-th"></span>
    </div>
</div>
</div>
<div class="form-group">
<label><?php echo form_label('FR8 No.', 'FR8 No.');?></label>
 <?php echo form_error('fr8_no','<div class="alert alert-danger">','</div>'); ?>
 <?php

$data = array(
              'name'        => 'fr8_no',
			  'type'        => 'fr8_no',
              'id'          => 'fr8_no',
              'value'       =>isset($truckinfo[0]->fr8_no)?$truckinfo[0]->fr8_no:set_value('fr8_no'),
              'maxlength'   => '1000',
              'size'        => '25',
			   'class'        => 'form-control',  
             
			  'required'=> 'required'
            );

echo form_input($data);
?>

</div>

<div class="form-group">
<label><?php echo form_label('License', 'License');?></label>
 <?php echo form_error('truck_license','<div class="alert alert-danger">','</div>'); ?>
<br/>
 <?php

$options = array(  
                  'MR'=> 'MR',
                  'HR'=> 'HR',
				  'HC'=>'HC',
				  'MC'=>'MC'
                );
$selectvalue=isset($truckinfo[0]->license)?$truckinfo[0]->license:set_value('truck_license');
echo form_dropdown('truck_license', $options,$selectvalue);?>
</div>

<?php 
$data = array(
              'name'        => 'truck_info_id',
			  'type'        => 'hidden',
              'id'          => 'truck_info_id',
              'value'       =>$truck_info_id,              
			  
            );

echo form_input($data);



echo form_submit('submitbut', 'Edit Truck Info');?> <?php echo form_reset('reset1', 'reset');?> <?php echo form_close();?>					
</div>
	</div>							
				
	 </div>
  
  </div>
  </div>