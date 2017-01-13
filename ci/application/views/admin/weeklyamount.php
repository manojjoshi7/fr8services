<div id="page-wrapper" >
  <div id="page-inner">
    <div class="row">
      <div class="col-lg-4">
        <h3><b style="color:red;">From</b>&nbsp; &nbsp;<?php echo $startenddate[0]->start_date;?>&nbsp; &nbsp;<b style="color:red;">To</b>&nbsp; &nbsp; <?php echo $startenddate[0]->end_date;?></h3>
        <input type="hidden" value="<?php echo $startenddate[0]->start_date;?>" id="startdate"/>
        <input type="hidden" value="<?php echo $startenddate[0]->end_date;?>" id="enddate"/>
        <input type="hidden" value="<?php echo base_url();?>" id="path"/>
      </div>
      <div class="col-lg-1">
        <?php 
$attributes = array('class' => '', 'id' => 'prevform','name'=>'prevform');
echo form_open('admin/weeklyfixedamount',$attributes);

$data = array(
              'name'        => 'prevhidden',
			  'type'        => 'hidden',
              'id'          => 'prevhidden',
              'value'       => $nextprevdate[0]->prevdate,
              );

echo form_input($data);
?>
        <?php echo form_submit('submitbut', 'Prev',"class='btn'");
?> <?php echo form_close();?> </div>
      <div class="col-lg-1">
        <?php 
$attributes = array('class' => '', 'id' => 'nextform','name'=>'nextform');
echo form_open('admin/weeklyfixedamount',$attributes);
$data = array(
              'name'        => 'nexthidden',
			  'type'        => 'hidden',
              'id'          => 'nexthidden',
              'value'       => $nextprevdate[0]->nextdate,
              );

echo form_input($data);?>
        <?php echo form_submit('submitbut', 'Next',"class='btn'");?> <?php echo form_close();?> </div>
		<div class="col-lg-6">
		<?php
		$attributes = array('class' => 'navbar-form navbar-left', 'id' => 'searchform','name'=>'searchform');
echo form_open('admin/getsearch',$attributes);
?>

    <div class="form-group">
    <span>Search By Name</span><span>
	<?php echo form_dropdown('user_name', $username);?>
	</span>
    </div>
  <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search"></span></button>
<?php echo form_close();?>		
		</div>
    </div>
    <hr />
    <div class="row">
      <div class="col-lg-12">
        <table class="table">
          <thead>
          <th> No. </th>
            <th> Name </th>
            <th> No Of 7-Eleven Jobs </th>
            <th> 7-Eleven Work Amount </th>
            <th> No of Swire Jobs </th>
            <th> Swire Total Time </th>
            <th> Swire Work Amount </th>
            <th> Total Amount</th>
            <th> Action </th>
            </thead>
          <tbody>
            <?php

	$i=1;
	foreach($weeklyamount as $row)
	{
    $view=$row['total_amount']!=0?'<button type="button" onclick="viewdetails('.$row["user_id"].');" class="btn btn-info">view</button>':'';
	if($i%2==0)
	{
	echo "<td>{$i}</td><td style='font-weight:bold';>{$row['user_name']}</td><td>{$row['totalfixedjob']}</td><td>{$row['total_fixed_amount']}</td><td>{$row['totalhourlyjob']}</td><td>{$row['totaltime']}</td><td>{$row['total_hourly_amount']}</td><td  style='font-weight:bold';>{$row['total_amount']}</td><td style='color:green;'>".$view."</td></tr><tr><td class='weeklydetail' colspan='9' id='detail_".$row["user_id"]."'></td></tr>";
	}else
	{
     echo "<td>{$i}</td><td style='font-weight:bold';>{$row['user_name']}</td><td>{$row['totalfixedjob']}</td><td>{$row['total_fixed_amount']}</td><td>{$row['totalhourlyjob']}</td><td>{$row['totaltime']}</td><td>{$row['total_hourly_amount']}</td><td style='font-weight:bold';>{$row['total_amount']}</td><td  style='color:green;'>".$view."</td></tr><tr><td class='weeklydetail' colspan='9' id='detail_".$row["user_id"]."'></td></tr>";
    }
	$i++;
	}
	?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<script>
viewdetails=function(id)
{

 $.post($("#path").val()+"admin/getuserweeklyamount",{startdate:$("#startdate").val(),enddate:$("#enddate").val(),user_id:id,li_token:$("input[name=li_token]").val()},function(result,status)
 {
 console.log(result);
$(".weeklydetail").hide();
 $("#detail_"+id).html(result)
 $("#detail_"+id).show();
 })

}

</script>