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

	  
	  <div class="col-lg-1" >
        No.</div>
          <div class="col-lg-2" >
        User Name</div>
		<div class="col-lg-4" align="center">
        7-Eleven Run</div>
		<div class="col-lg-2" >
        Date</div>
		<div class="col-lg-3" >7-Eleven Work Amount
        </div>

           		  
		  <div class="col-lg-12" style="overflow-y:scroll; height:250px;">
		  <table class="table">
		              <?php

	$i=1;
	$total_amount=0;
	if(count($fixedresult))
	{
	foreach($fixedresult as $row)
	{
	
     echo "<td>{$i}</td><td>{$row->name}</td><td>{$row->rolename}</td><td>{$row->assign_date}</td><td>{$row->role_amount}</td></tr>";
    $total_amount=($total_amount+$row->role_amount);
	$i++;
	}
	}
	?>
	<tr>
	<td colspan="3">&nbsp;
	
	</td>
	<td>
	<h3>Total:</h3>
	</td>
	<td>
	<?php echo $total_amount;?>
	</td>
	</tr>
	</table>
	</div>
      
    </div>
	<div class="row">
      <h3>Invoice Of Swire Jobs</h3>
	  <div class="col-lg-1" >
        No.
	   </div>
       <div class="col-lg-2">
        User Name
		</div>
		<div class="col-lg-2">
        Start Time
		</div>
	    <div class="col-lg-2">
        End Time
		</div>
		<div class="col-lg-2">
		Time Take
        </div>
		<div class="col-lg-3">
		Amount
        </div>
	  
	  <div class="col-lg-12" style="overflow-y:scroll; height:400px;">
		  <table class="table">
		              <?php

	$i=1;
	$total_amount=0;
	if(count($hourlyresult))
	{
	foreach($hourlyresult as $row)
	{
	     echo "<td>{$i}</td><td>{$row->name}</td><td>{$row->start_time}</td><td>{$row->end_time}</td><td>{$row->HOUR}:{$row->MINUTES}</td><td>{$row->AMOUNT}</td></tr>";
    $total_amount=($total_amount+$row->AMOUNT);
	$i++;
	}
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
	</div>
	  </div>
  </div>
</div>
