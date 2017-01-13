<div id="page-wrapper" >

<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">GeoLocation</h4>
      </div>
      <div class="modal-body">
        
		<p id="modaltime"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

     <div id="page-inner">
	 <div class="row">
                    <div class="col-lg-10">
                     <h2>User Location</h2>   
                    </div>
					
                </div>
				<hr />
<div class="row">
<div class="col-lg-12">
	<?php echo $map['html']; ?>
	 </div>
	 </div>
	 
	 
	</div>
</div>