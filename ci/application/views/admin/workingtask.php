<div id="page-wrapper" >
     <div id="page-inner">
	 <div class="row">
                    <div class="col-lg-10">
                     <h2>Currents 7-Eleven Jobs</h2>   
                    </div>
					
                </div>
<div class="row">
                    <div class="col-lg-4">
                     <h3><b style="color:red;">From</b>&nbsp; &nbsp;<?php echo $startenddate[0]->start_date;?>&nbsp; &nbsp; <b style="color:red;">To</b>&nbsp; &nbsp; <?php echo $startenddate[0]->end_date;?>)</h3>   
                    </div>
					<div class="col-lg-1">
<?php 

$attributes = array('class' => '', 'id' => 'prevform','name'=>'prevform');
echo form_open('admin/workingtask',$attributes);

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
echo form_open('admin/workingtask',$attributes);
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
				<hr />
<div class="row">
<div class="col-lg-12">
					
	 <table class="table table-condensed table-bordered">
	 <thead>
	 <th >
	 Name
	 </th>
	 <th>
	Job Name
	 </th>
	 <th>
	 Assign Date
	 </th>
     <th>
	 Start Time
	 </th>
	 <th>
	 Finish Time
	 </th>
	 <th>
	 Status
	 </th>
	 <th>
	 View
	 </th>
	 <th>
	 Truck Issues
	 </th>
	 </thead>
	 <tbody>
	<?php
	foreach($datarows as $row)
	{
	
	$starttask=(array)json_decode($row->start);
    $endtask=(array)json_decode($row->endtask);
	$startcoordinate="Lat: ".$starttask["currentlatitude"]."&nbsp;Lon:".$starttask["currentlongitude"];
	$enstasktime=	isset($endtask['enddatetime'])?$endtask['enddatetime']:'';
	$endcoordinate=isset($endtask['enddatetime'])?"Lat: ".$endtask["currentlatitude"]."&nbsp;Lon:".$endtask["currentlongitude"]:'';
echo "<tr><td>{$row->username}</td><td>{$row->rolename}</td><td>{$row->assign_date}</td><td>{$starttask['startdatetime']} </td><td>{$enstasktime} </td><td>{$row->status}</td><td><a href=".site_url('admin/userlocation/'.$row->assign_task_id.'').">Location</a></td><td><a href=".site_url('admin/feedback/'.$row->assign_task_id.'/fixed').">Checklist</a></td></tr>";
	}
	?>
	
	 </tbody>
	 </table>
	 </div>
	 </div>
	 <div class="row">
	 <div class="col-lg-4">
	 	 &nbsp;
	 </div>
	 <div class="col-lg-4">
	 <?php //echo $links; ?>
	 </div>
	 <div class="col-lg-4">
	 &nbsp;
	 </div>
	 </div>
	</div>
</div>