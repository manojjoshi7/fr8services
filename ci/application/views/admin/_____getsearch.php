<div id="page-wrapper" >
  <div id="page-inner">
    <div class="row">
      <div class="col-lg-6">
	  &nbsp;
	  </div>
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
      <h3>Invoice Of Eleven Run</h3>

	  <div class="col-lg-12" >
	  
        <table class="table">
          <thead>
          <th> No.</th>
            <th>User Name</th>
            <th>7-Eleven Run</th>
			<th>Date</th>
            <th>7-Eleven Work Amount </th>
            </thead>
		  <tr>
		  <td colspan="5">
		  <div style="overflow-y:scroll; height:400px;">
		  <table class="table">
		              <?php

	$i=1;
	$total_amount=0;
	foreach($fixedresult as $row)
	{
	
     echo "<td>{$i}</td><td>{$row->name}</td><td>{$row->rolename}</td><td>{$row->assign_date}</td><td>{$row->role_amount}</td></tr>";
    $total_amount=($total_amount+$row->role_amount);
	$i++;
	}
	
	?>
	<tr>
	<td colspan="3">
	&nbsp;
	</td>
	<td>
	<h3>Total:</h3>
	</td>
	<td>
	<?php echo $total_amount;?>
	</td>
	</tr>
	</table>
	</div></td></tr>
          		  
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