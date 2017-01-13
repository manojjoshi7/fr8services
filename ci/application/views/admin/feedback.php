<div id="page-wrapper" >
     <div id="page-inner">
	 <div class="row">
                    <div class="col-lg-10">
                     <h2>Feedback</h2>   
                    </div>
					
                </div>
				<hr />
<div class="row">
<div class="col-lg-12">
					
	 <table class="table table-condensed table-bordered">
	 <thead>
	 <th>
	 Assign id
	 </th>
	 <th>
	Name
	 </th>
	 <th>
	 Plate Number
	 </th>
     <th>
	 Engine oil
	 </th>
	 <th>
	 Lights
	 </th>
	 <th>
	 Tyres
	 </th>
	 <th>
	 Vehicle Body
	 </th>
     <th>
     other
	 </th>
	 <th>
     Feedback Type
	 </th>
	 </thead>
	 <tbody>
	<?php
	foreach($feedback as $row)
	{

echo "<tr><td>{$row->assign_id}</td><td>{$row->name}</td><td>{$row->truck_plate_number}</td><td>{$row->engine_oil}</td><td>{$row->lights}</td><td>{$row->tyres}</td><td>{$row->vehicle_body}</td><td>{$row->other}</td><td>{$row->type}</td></tr>";
	}
	?>
	
	 </tbody>
	 </table>
	 </div>
	 </div>
	 
	</div>
</div>