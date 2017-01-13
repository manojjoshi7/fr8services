    <div class="footer">
      

            <div class="row">
                <div class="col-lg-12" >
                    
                </div>
            </div>
        </div>
   

      <!-- BOOTSTRAP SCRIPTS -->
    <script src="<?php echo base_url('assets/js/bootstrap.min.js');?>"></script>
    <script src="<?php echo base_url('assets/js/bootstrap-datepicker.min.js');?>"></script>
	<script src="<?php echo base_url('assets/js/bootbox.min.js');?>"></script>
	  <!-- CUSTOM SCRIPTS -->
    <script src="<?php echo base_url('assets/js/custom.js');?>"></script>
	<script src="<?php echo base_url('assets/js/js/wickedpicker.js');?>"></script>
	<script>
	var timepickers = $('.timepicker').wickedpicker(); console.log(timepickers.wickedpicker('time', 1));
	function dispalyimagepopup(type,h)
	{
	
	  $("#modaltime").html("");
	  var image= (type=="users"?$("#baseurl").val()+"assets/uploadimage/"+h+".jpg":$("#baseurl").val()+"assets/uploadimage/email/"+h+".jpg");
	  $("#modaltime").html("<img src="+image+" style='width:65%'>");
	  $("#myModal").modal('show');	
	}
	
function dispalypopup(h)
{

$("#modaltime").html(h);
//$("#modaltime").html(t);
$("#myModal").modal('show');
//$(".hover-tooltip").show();
	//					$(".hover-tooltip a").tooltip('show');
	//var offset = this.offset();					
//alert( "left: " + offset.left + ", top: " + offset.top);
}

</script>

	<script>
	
	$(document).ready(function()
	{
  
	 if($("#infoWindow").length)
	 {
	 document.getElementById('infoWindow').style.overflow = 'visible';
	 }
	 /*var dispalytooltip=function()
	                    {
						$(".hover-tooltip").show();
						$(".hover-tooltip a").tooltip('show');
						
						}*/
	})
	//$(".datepicker").datepicker('update', new Date());
	$(".deleteit").click(function(e)
	{
	var url= $(this).attr("href")
	e.preventDefault();


	bootbox.confirm("Are you sure to delete this", function(result) {
	if(result)
	{

	     document.location.href = url;
	}
	});
	})
	$(document).ready(function()
	{

	$(".dump").click(function()
	   {
									$(".hide_penal").hide();  
									
									  $(this).next().show()
	   })
	   
	   if($("#weekpath").length)
	   {
	     $.post($("#weekpath").val(),{choosedate:$("#choosedate").val(),choosetype:$("#choosetype").val(),li_token:$("input[name=li_token]").val()},function(result,status){
		  		 console.log(result);
		   parsed = JSON.parse(result);
		   for(var key in parsed) 
		   {
		   $("#"+key).html(parsed[key])
           console.log("Key: " + key + " value: " + parsed[key]);
           }
		  //parsed = JSON.parse(result);
	/*	  
var arr = [];

for(var x in parsed){
  arr.push(parsed[x]);
}*/
		 console.log(parsed);
		 })
	   
	   }
	   
	   
	   
	})
	/*
	*/
	
	</script>
</body>
</html>
