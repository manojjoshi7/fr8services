<div id="page-wrapper" >
     <div id="page-inner">
	 <div class="row">
                    <div class="col-lg-10">
                     <h2>Swire NSW Jobs</h2>   
                    </div>
					
                </div>
				<br/>
<div class="row">
                    <div class="col-lg-4">
                     <h3><b style="color:red;">From</b>&nbsp; &nbsp;<?php echo $startenddate[0]->start_date;?>&nbsp; &nbsp; <b style="color:red;">To</b>&nbsp; &nbsp; <?php echo $startenddate[0]->end_date;?>)</h3>   
                    </div>
					<div class="col-lg-1">
<?php 

$attributes = array('class' => '', 'id' => 'prevform','name'=>'prevform');
echo form_open('admin/displayhourlyjob',$attributes);

$data = array(
              'name'        => 'prevhidden',
			  'type'        => 'hidden',
              'id'          => 'prevhidden',
              'value'       => $nextprevdate[0]->prevdate,
              );

echo form_input($data);
?>
<?php echo form_submit('submitbut', 'Prev',"class='btn'");
?>
<?php echo form_close();?> 
</div>

<div class="col-lg-1">

<?php 
$attributes = array('class' => '', 'id' => 'nextform','name'=>'nextform');
echo form_open('admin/displayhourlyjob',$attributes);
$data = array(
              'name'        => 'nexthidden',
			  'type'        => 'hidden',
              'id'          => 'nexthidden',
              'value'       => $nextprevdate[0]->nextdate,
              );

echo form_input($data);

?>
<?php echo form_submit('submitbut', 'Next',"class='btn'");?>
<?php echo form_close();?> 
</div>
                </div>
<div class="row">
<div class="col-lg-12">
				
	 <table class="table">
	 <thead>
	 <th>
     Date
	 </th>
	 <th>
	 Name
	 </th>
	 <th>
	 FR8 No 
	 </th>
	 <th>
	 Expected Time 
	 </th>
	 <th>
	 Start Form
	 </th>
	 <th>
	Company For
	 </th>
	 <th>
	 Role
	 </th>
	 <th>
	 Per Hour 
	 </th>
	 <th>
	 Work Description 
	 </th>
	 <th>
	 Action
	 </th>
	 </thead>
	 <tbody>
	<?php
	foreach($hourlyjob as $row)
	{
	
	$amount='$'.$row->per_hour;
echo "<tr><td>{$row->assign_dates}</td><td>{$row->username}</td><td>{$row->fr8no}</td><td>{$row->expectedtime}</td><td>{$row->companyname}</td><td>{$row->start_form}</td><td>{$row->role_name}</td><td>{$amount}</td><td>{$row->description}</td><td><a class='btn btn-success' href=".site_url('admin/editdriverhourlyjob/'.$row->id.'').">Edit</a>&nbsp;<a href=".site_url('admin/deletedata/'.$row->id.'/hourly_job_assign')." class='btn btn-danger deleteit'>Delete</a></td></tr>";
	}
	?>
	
	 </tbody>
	 </table>
	 </div>
	 </div>
	 
	</div>
</div>