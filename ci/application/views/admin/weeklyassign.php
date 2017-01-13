<div id="page-wrapper" >
  <div id="page-inner">
    <div class="row">
      <div class="col-lg-4">
        <h3> <b style="color:red;">From</b>&nbsp; &nbsp;<?php echo $startenddate[0]->start_date;?> &nbsp; &nbsp;<b style="color:red;">To</b> &nbsp; &nbsp;<?php echo $startenddate[0]->end_date;?></h3>
      </div>
      <div class="col-lg-1">
        <?php 
$attributes = array('class' => '', 'id' => 'prevform','name'=>'prevform');
echo form_open('admin/weeklyassign',$attributes);

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
echo form_open('admin/weeklyassign',$attributes);
$data = array(
              'name'        => 'nexthidden',
			  'type'        => 'hidden',
              'id'          => 'nexthidden',
              'value'       => $nextprevdate[0]->nextdate,
              );

echo form_input($data);

?>
        <?php echo form_submit('submitbut', 'Next',"class='btn'");?> <?php echo form_close();?> </div>
    </div>
    <hr />
    <div class="row">
      <div class="col-lg-12">
        <table class="table">
          <thead>
          <th> RUNS </th>
            <th> MONDAY </th>
            <th> TUESDAY </th>
            <th> WEDNESDAY </th>
            <th> THURSDAY </th>
            <th> FRIDAY </th>
            <th> SATURDAY </th>
            <th> SUNDAY </th>
            </thead>
          <tbody>
            <?php
	foreach($roles as $row)
	{
echo "<tr><td style='font-weight:bold;'>{$row->name}</td><td id='mon_{$row->role_id}'>&nbsp;</td><td id='tue_{$row->role_id}'>&nbsp;</td><td id='wed_{$row->role_id}'>&nbsp;</td><td id='thu_{$row->role_id}'>&nbsp;</td><td id='fri_{$row->role_id}'>&nbsp;</td><td id='sat_{$row->role_id}'>&nbsp;</td><td id='sun_{$row->role_id}'>&nbsp;</td></tr>";
	}
	?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<input type="hidden" id="weekpath" value="<?php echo site_url('admin/datacurrentweek');?>"/>
<input  type="hidden" id="choosedate" value="<?php echo $choosedate;?>"/>
<input  type="hidden" id="choosetype" value="<?php echo $choosetype;?>"/>
