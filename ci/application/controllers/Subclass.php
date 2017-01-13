<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Subclass  extends CI_Controller 
{

    public function __construct() 
	{
	 parent::__construct();
	 if($this->session->userdata('li_token')==FALSE)
	 {
	 $this->session->set_userdata('li_token', md5(uniqid() . microtime() . rand()));
	 }
	 $_POST["li_token"]= $this->session->userdata('li_token');	

	 $this->load->model('user_model');
	 $this->load->helper('file');
    }
	public function assignhourlytask()
	{

	           $data= file_get_contents("php://input");
			   $data = strip_tags($data);
               $clean_input = trim($data);
               $data = array();
               parse_str($clean_input, $data);
			   $result= $this->gethourlyassigntask($data);
			   header('Content-type: application/json');
			   echo json_encode($result);
	
	
	}
	private function gethourlyassigntask($data)
	{
	      $this->form_validation->set_rules('email', 'Email', 'required|valid_email|xss_clean');
	      if($this->form_validation->run() == FALSE)
		  {
                  $result["status"]=0;
				  //$result["message"]= $this->form_validation->error_array();
				  $errorarray=array_values($this->form_validation->error_array());
				  $result["message"]["error"]= $errorarray[0];
		  }else
		  {
		    $choosedate='';
			$choosedate=(!empty($this->input->post("prevhidden"))?$this->input->post("prevhidden"):(!empty($this->input->post("nexthidden"))?$this->input->post("nexthidden"):''));
			
			if(empty($choosedate))
			{
		    // $dayresult=$this->user_model->use_query("select DAYOFWEEK( CURDATE( )) as daynum");
			$day_of_week = date('N', strtotime(date('d-m-Y')));
		    //if($dayresult[0]->daynum==1)
			if($day_of_week==7)
			{
			  $data["startenddate"]=$this->user_model->use_query("select DATE_FORMAT( CURDATE( ) - INTERVAL 7 -2
DAY ,  '%m-%d-%Y' ) as start_date,DATE_FORMAT( (
CURDATE( ) - INTERVAL 7 -1
DAY ) + INTERVAL 7 
DAY ,  '%m-%d-%Y'
) as end_date");
			}else
			{	
			
			$data["startenddate"]=$this->user_model->use_query("select DATE_FORMAT( CURDATE( ) - INTERVAL DAYOFWEEK( CURDATE( ) ) -2
DAY ,  '%m-%d-%Y' ) as start_date,DATE_FORMAT( (
CURDATE( ) - INTERVAL DAYOFWEEK( CURDATE( ) ) -1
DAY ) + INTERVAL 7 
DAY ,  '%m-%d-%Y'
) as end_date");
           }
            }
			else
			{
			$sendtype=(!empty($this->input->post("nexthidden"))?"next":"prev");
			if($sendtype=="next")
			{
			$data["startenddate"]=$this->user_model->use_query("select DATE_FORMAT('".$choosedate."' - INTERVAL DAYOFWEEK('".$choosedate."') -2
DAY ,  '%m-%d-%Y' ) as start_date,DATE_FORMAT( (
'".$choosedate."' - INTERVAL DAYOFWEEK( '".$choosedate."' ) -2
DAY ) + INTERVAL 6 
DAY ,  '%m-%d-%Y'
) as end_date");
			}
			else
			{
$data["startenddate"]=$this->user_model->use_query("select DATE_FORMAT('".$choosedate."' - INTERVAL 6
DAY ,  '%m-%d-%Y' ) as start_date,DATE_FORMAT(('".$choosedate."' - INTERVAL 0 DAY ),  '%m-%d-%Y') as end_date");
			}
			}
			$start_date=	trim($data['startenddate'][0]->start_date);
		    $end_date=trim($data['startenddate'][0]->end_date);
			$result["weekstartdate"]=$start_date;
			$result["weekenddate"]=$end_date;
		    $data["nextprevdate"]=$this->user_model->use_query("SELECT STR_TO_DATE('".$start_date."' ,'%m-%d-%Y' ) - INTERVAL 1 
DAY as prevdate,STR_TO_DATE('".$end_date."' ,'%m-%d-%Y' ) + INTERVAL 1 
DAY as nextdate");

           $result["prevhidden"]=$data["nextprevdate"][0]->prevdate;
           $result["nexthidden"]=$data["nextprevdate"][0]->nextdate;
				 if(empty($choosedate))
				 {

				 //if($dayresult[0]->daynum==1)
				 if($day_of_week==7)
				 {
$query="select `hourly_job_assign`.`id`, `user`.`name` as `username`,`hourly_job_assign`.`fr8no`,`hourly_job_assign`.`expectedtime`,`hourly_job_assign`.`start_form`,`company`.`name` as `companyname`,`truckrole`.`role_name`,`hourly_job_assign`.`per_hour`,DATE_FORMAT(`hourly_job_assign`.`assign_dates`,'%m-%d-%Y') as `assign_dates`,`hourly_job_assign`.`description`,DATE_FORMAT(`hourly_job_assign`.`assign_dates`,'%W' ) as dayname from `hourly_job_assign` inner join `truckrole` on `hourly_job_assign`.`truck_role_id`=`truckrole`.`id` inner join `company` on `company`.`id`=`hourly_job_assign`.company_id inner join `user` on `user`.`user_id`=`hourly_job_assign`.`user_id`  where DATE_FORMAT(`hourly_job_assign`.`assign_dates`,'%m-%d-%Y') between DATE_FORMAT( CURDATE( ) - INTERVAL 7 -2DAY ,  '%m-%d-%Y' ) and  DATE_FORMAT( (CURDATE( ) - INTERVAL 7DAY ) + INTERVAL 9DAY ,  '%m-%d-%Y') and `user`.`email`='".$this->input->post('email')."' and `hourly_job_assign`.`id` not in (select `assign_id` from `hourlyjob` where `status`='done') order by `hourly_job_assign`.`assign_dates` asc";				
				
				 
				 }else
				 {
 $query="select `hourly_job_assign`.`id`, `user`.`name` as `username`,`hourly_job_assign`.`fr8no`,`hourly_job_assign`.`expectedtime`,`hourly_job_assign`.`start_form`,`company`.`name` as `companyname`,`truckrole`.`role_name`,`hourly_job_assign`.`per_hour`,DATE_FORMAT(`hourly_job_assign`.`assign_dates`,'%m-%d-%Y') as `assign_dates`,`hourly_job_assign`.`description`,DATE_FORMAT(`hourly_job_assign`.`assign_dates`,'%W' ) as dayname from `hourly_job_assign` inner join `truckrole` on `hourly_job_assign`.`truck_role_id`=`truckrole`.`id` inner join `company` on `company`.`id`=`hourly_job_assign`.company_id inner join `user` on `user`.`user_id`=`hourly_job_assign`.`user_id`  where DATE_FORMAT(`hourly_job_assign`.`assign_dates`,'%m-%d-%Y') between DATE_FORMAT(CURDATE( ) - INTERVAL DAYOFWEEK( CURDATE( ) ) -2
DAY ,  '%m-%d-%Y' ) AND DATE_FORMAT( (
CURDATE( ) - INTERVAL DAYOFWEEK( CURDATE( ) ) -2
DAY ) + INTERVAL 6 
DAY ,  '%m-%d-%Y'
) and `user`.`email`='".$this->input->post('email')."' and `hourly_job_assign`.`id` not in (select `assign_id` from `hourlyjob` where `status`='done') order by `hourly_job_assign`.`assign_dates` asc";
               }
$data= $this->user_model->use_query($query);
					 
						 $result["status"]=1;
						 $result["message"]=$data;
				}else
				{
$sdate=(string)$start_date;
$edate=(string)$end_date;
					
					
	$query="select `hourly_job_assign`.`id`,  `user`.`name` as `username`,`hourly_job_assign`.`fr8no`,`hourly_job_assign`.`expectedtime`,`hourly_job_assign`.`start_form`,`company`.`name` as `companyname`,`truckrole`.`role_name`,`hourly_job_assign`.`per_hour`,DATE_FORMAT(`hourly_job_assign`.`assign_dates`,'%m-%d-%Y') as `assign_dates`,`hourly_job_assign`.`description`,DATE_FORMAT(`hourly_job_assign`.`assign_dates`, '%W' ) as dayname from `hourly_job_assign` inner join `truckrole` on `hourly_job_assign`.`truck_role_id`=`truckrole`.`id` inner join `company` on `company`.`id`=`hourly_job_assign`.company_id inner join `user` on `user`.`user_id`=`hourly_job_assign`.`user_id`  where DATE_FORMAT(`hourly_job_assign`.`assign_dates`,'%m-%d-%Y') between STR_TO_DATE( '".$sdate."','%m-%d-%Y') and STR_TO_DATE('".$edate."','%m-%d-%Y') and `user`.`email`='".$this->input->post('email')."' and `hourly_job_assign`.`id` not in (select `assign_id` from `hourlyjob` where `status`='done') order by `hourly_job_assign`.`assign_dates` asc";
$data= $this->user_model->use_query($query);				
					
				
						 $result["status"]=1;
						 $result["message"]=$data;
				
				
				
				}

		 }
		 return $result;
		  
	}
	private function imageuploadbywebservice($filename,$for)
	{
	//echo $_REQUEST['image'];
	//echo "<br>";
	//die;
      if(isset($_REQUEST['image']) && !empty($_REQUEST['image']))
	  {
      $base=$_REQUEST['image'];
    // Get file name posted from Android App
      $filename = $filename.".jpg";
    // Decode Image
      $binary=base64_decode($base);
    //header('Content-Type: image/jpg');
    // Images will be saved under 'www/imgupload/uplodedimages' folder
	  if($for=="email")
	  {
       $file = fopen('assets/uploadimage/email/'.$filename, 'wb');
	  }
    // Create File
    fwrite($file, $binary);
    fclose($file);
	return true;
    }
	else
	{
			   $result["status"]=0;
	           $result["message"]='image not upload';
			   header('Content-type: application/json');
              echo json_encode($result);    die;
	}
				 
	}
	private function small_img_uploadbywebservice($filename,$for)
	{
	   try
	   {
        $this->load->library('image_lib');
	    unset($config);
		$config['image_library'] = 'gd2';
		if($for=="email")
		{
         $config['source_image']	= 'assets/uploadimage/email/'.$filename.'';
         $config['new_image'] = 'assets/uploadimage/email/thumb/';
		}
		$config['create_thumb'] = TRUE;
        $config['maintain_ratio'] = TRUE;
        $config['width']	 =100;
        $config['height']	= 100;
		$this->image_lib->initialize($config);
		$this->image_lib->resize();
	    $this->image_lib->clear();
		}
		catch(Exception $e)
		{
		echo 'Caught exception: ',  $e->getMessage();
		
		}
	}
	public function addfeedback()
	{
	           $data= file_get_contents("php://input");
			   $data = strip_tags($data);
               $clean_input = trim($data);
               $data = array();
               parse_str($clean_input, $data);
			   
	           $this->form_validation->set_rules('assign_id', 'assign id', 'trim|required|xss_clean');
			   $this->form_validation->set_rules('email', 'email id', 'trim|required|valid_email|xss_clean');
			   $this->form_validation->set_rules('truck_plate_number', 'plate number', 'trim|required|xss_clean');
			   $this->form_validation->set_rules('engine_oil', 'engine oil', 'trim|required|xss_clean');
			   $this->form_validation->set_rules('lights', 'lights', 'trim|required|xss_clean');
			   $this->form_validation->set_rules('tyres', 'tyres', 'trim|required|xss_clean');
			   $this->form_validation->set_rules('vehicle_body', 'vehicle body', 'trim|required|xss_clean');
               /*$this->form_validation->set_rules('registration', 'registration', 'trim|required|xss_clean');*/ 
			   $this->form_validation->set_rules('other', 'other', 'trim|xss_clean'); 
			   $this->form_validation->set_rules('type', 'type', 'trim|required|xss_clean'); 
			   
			   if($this->form_validation->run() == FALSE)
		       {
			   
				 $result["status"]=0;
				 $errorarray=array_values($this->form_validation->error_array());
				 $result["message"]["error"]=$errorarray[0];
			   }
			   else
			   {
	$userdata= $this->user_model->getdatawithcondition("user_id","user",array("email"=>$this->input->post('email'))); if(count($userdata))
			     {
				 /*
$this->user_model->insert_data("`feedback`",array("`assign_id`"=>$this->input->post('assign_id'),"`user_id`"=>$userdata[0]->user_id,"`truck_plate_number`"=>$this->input->post('truck_plate_number'),"`engine_oil`"=>$this->input->post('engine_oil'),"`lights`"=>$this->input->post('lights'),"`tyres`"=>$this->input->post('tyres'),"`vehicle_body`"=>$this->input->post('vehicle_body'),"`registration`"=>$this->input->post('registration'),"`other`"=>$this->input->post('other'),"`type`"=>$this->input->post('type')));*/

$this->user_model->insert_data("`feedback`",array("`assign_id`"=>$this->input->post('assign_id'),"`user_id`"=>$userdata[0]->user_id,"`truck_plate_number`"=>$this->input->post('truck_plate_number'),"`engine_oil`"=>$this->input->post('engine_oil'),"`lights`"=>$this->input->post('lights'),"`tyres`"=>$this->input->post('tyres'),"`vehicle_body`"=>$this->input->post('vehicle_body'),"`other`"=>$this->input->post('other'),"`type`"=>$this->input->post('type')));
			     $result["status"]=1;
			     $result["message"]="Your feedback has been send";
			     }
				 else
				 {
				 $result["status"]=0;
				 $result["message"]="Your are not registered user";
				 }
			   }
		     header('Content-type: application/json');
			echo json_encode($result);	   
	}
	public function truckinfo()
	{
	   
	           $data= file_get_contents("php://input");
			   $data = strip_tags($data);
               $clean_input = trim($data);
               $data = array();
               parse_str($clean_input, $data);
	           $this->form_validation->set_rules('email', 'email id', 'trim|required|valid_email|xss_clean');
			   $this->form_validation->set_rules('store_number', 'Store number', 'trim|required|xss_clean');
			   $this->form_validation->set_rules('run_name', 'Run name', 'trim|required|xss_clean');
			   $this->form_validation->set_rules('problem', 'Problem', 'trim|required|xss_clean');
			   $this->form_validation->set_rules('image', 'Image', 'trim|required|xss_clean');
			   
           	     if($this->form_validation->run() == FALSE)
		         {
				 $result["status"]=0;
				 $errorarray=array_values($this->form_validation->error_array());
				 $result["message"]["error"]=$errorarray[0];
				 }else
				 {
		$userdata= $this->user_model->getdatawithcondition("user_id,email,name","user",array("email"=>$this->input->post('email'))); 		
	     
		          if(count($userdata))
		          { 
		$rt=	$this->user_model->runquery('call Getmax("id","truck_fault")');

		$filename=$rt[0]["maxid"];

		$next=$this->imageuploadbywebservice($filename,"email");
		$filename=$rt[0]["maxid"].".jpg";
		if($next)
		{
		     $this->small_img_uploadbywebservice($filename,"email");
		}
		
				        
		$assignid= $this->user_model->insert_data("`truck_fault`",array("`id`"=>$rt[0]["maxid"],"`user_id`"=>$userdata[0]->user_id,"`store_number`"=>$this->input->post('store_number'),"`run_name`"=>$this->input->post('run_name'),"`problem`"=>$this->input->post('problem'),"`image_name`"=>$filename));
	$subject=	"Inform about ".$this->input->post('store_number')." ".$this->input->post('run_name')."";
	
	$image=base_url()."assets/uploadimage/email/".$filename;
	
	
	
	$attechimg="<img src=".$image." alt='Test Image'/>";
	$message="<b>Inform about ".$this->input->post('store_number')."&nbsp;".$this->input->post('run_name')."</b><br/>".$this->input->post('problem')."<br/>".$attechimg;
	//$toemail="alinnaamo@live.com.au";
	//$toemail="jsr8919@gmail.com";
	$toemail="Hotline.fr8services@gmail.com";
	$formemail=$userdata[0]->email;
	
	$username=$userdata[0]->name;
	//$username='jagroop';
	$username='FR8 Services';
	$this->user_model->sendemil($formemail,$toemail,$username,$subject,$message);		 
				  $result["message"]="email has been send"; 
				  }else
				  {
				  $result["status"]=0;
				  $result["message"]="Your are not registered user";
				  }
				 }
            header('Content-type: application/json');
			echo json_encode($result);		
	}
	public function gethourlyjobstatus()
	{
               $data= file_get_contents("php://input");
			   $data = strip_tags($data);
               $clean_input = trim($data);
               $data = array();
               parse_str($clean_input, $data);

	          $this->form_validation->set_rules('id', 'send assign task id', 'trim|required|xss_clean');
           	     if($this->form_validation->run() == FALSE)
		         {
				 $result["status"]=0;
				 $errorarray=array_values($this->form_validation->error_array());
				 $result["message"]["error"]=$errorarray[0];
				 }else
				 {
$getresult= $this->user_model->getdatawithcondition("`assign_id`,`upadtedatetime`,`status`,`start`,`break` as `userbreak`","`hourlyjob`",array("assign_id"=>$this->input->post("id"),'status'=>"pending"));

                  if(!empty($getresult))
                  {
                    $result["status"]=$getresult[0]->status;
					$result["job_assign_id"]=$getresult[0]->assign_id;
					if(!empty($getresult[0]->userbreak) && $getresult[0]->status=="pending")
				    {
				    $breakdata=$getresult[0]->userbreak;
					$breakdata=explode('#@#',$breakdata);
					$index=count($breakdata)-1;
					$breakdata=$breakdata[$index];
					$breakdata=json_decode($breakdata);
				    $gettime=isset($breakdata->startdatetime)?$breakdata->startdatetime:$breakdata->enddatetime;
				    $timefor= isset($breakdata->startdatetime)?"startdatetime":"enddatetime";
				    $gettype="break";
					
					
					$result["gettime"]=$gettime;
					$result["timefor"]=$timefor;
					$result["type"]=$gettype;
					
				    }else if(!empty($getresult[0]->start) && $getresult[0]->status=="pending")
				    {
				    $breakdata=$getresult[0]->start;
					$gettype="startwork";

					$breakdata=json_decode($breakdata);

					$gettime=$breakdata->startdatetime;
					$result["gettime"]=$gettime;
					
					$result["type"]=$gettype;
					}
					else if($getresult[0]->status=="done")
					{
					
					$result["gettime"]=$getresult[0]->upadtedatetime;
					$result["type"]="end";
					}
					}
				   else
				   {
				   $result["status"]=1;
				   $result["message"]='No hourly work exist';
				   }
			   
				 }
			    header('Content-type: application/json');
			    echo json_encode($result);	 	
	}
	
	public function assignjob()
	{
	    
		       $data= file_get_contents("php://input");
			   $data = strip_tags($data);
               $clean_input = trim($data);
               $data = array();
               parse_str($clean_input, $data);
               $this->form_validation->set_rules('email', 'Email id', 'trim|required|valid_email|xss_clean');
			   $this->form_validation->set_rules('description', 'Description', 'trim|required|xss_clean');
			   $this->form_validation->set_rules('comment', 'Comment', 'trim|required|xss_clean');
			     if($this->form_validation->run() == FALSE)
		         {
				 $result["status"]=0;
				 $errorarray=array_values($this->form_validation->error_array());
				 $result["message"]["error"]=$errorarray[0];
				 }
				 else
				 {
	$userdata= $this->user_model->getdatawithcondition("user_id","user",array("email"=>$this->input->post('email'))); 
				 
		$assignid= $this->user_model->insert_data("hourlyjob",array("description"=>$this->input->post('description'),"comment"=>$this->input->post('comment'),"user_id"=>$userdata[0]->user_id));
		$result["status"]=1;
		$result["job_assign_id"]=$assignid;
		$result["message"]="Information has been saved!";
				 }
				 header('Content-type: application/json');
			    echo json_encode($result);
			   
	
	}
   public function workonhourlyjob()
	{
	    
		       $data= file_get_contents("php://input");
			   $data = strip_tags($data);
               $clean_input = trim($data);
               $data = array();
               parse_str($clean_input, $data);

			   $result= $this->hourlygeolocation();
			   header('Content-type: application/json');
			   echo json_encode($result);
	}
	
   public function hourlygeolocation()
   {
   			    $this->form_validation->set_rules('assignid', 'Send Assign Task Id', 'trim|required|xss_clean');
				$this->form_validation->set_rules('type', 'Send Type', 'trim|required|xss_clean');
				$this->form_validation->set_rules('currentdatetime', 'Send Current Date Time', 'trim|required|xss_clean');
				$this->form_validation->set_rules('currentlatitude', 'Send Latitude', 'trim|required|xss_clean');
				$this->form_validation->set_rules('currentlongitude', 'Send Longitude', 'trim|required|xss_clean');
				if($this->input->post("type")=="break")
				$this->form_validation->set_rules('breakpoint', 'Send Break Point', 'trim|required|xss_clean');
		         if($this->form_validation->run() == FALSE)
		         {
				 $result["status"]=0;
				 $errorarray=array_values($this->form_validation->error_array());
				 $result["message"]["error"]=$errorarray[0];
				 return $result;
				 }
				 else
				 {

					if($this->input->post("type")=="start")
					{
					 $getdata["startdatetime"]=$this->input->post("currentdatetime");
					 $getdata["currentlatitude"]= $this->input->post("currentlatitude");
					 $getdata["currentlongitude"]=  $this->input->post("currentlongitude");
					 $getdata=json_encode($getdata);	 
				$hascount=$this->user_model->countresult(array("assign_id"=>$this->input->post("assignid")),"`hourlyjob`");

					  if(!$hascount)
					  {
$this->user_model->insert_data("`hourlyjob`",array("assign_id"=>$this->input->post("assignid"),'start'=>$getdata,'upadtedatetime'=>$this->input->post("currentdatetime"),'start_time'=>date('Y-m-d H:i:s',strtotime($this->input->post("currentdatetime")))));
	
					  $result["status"]=1;
					  $result["message"]="Information has been updated";
					  return $result;
					  }
					
					}
					else if($this->input->post("type")=="break")
					{ 
					  if($this->input->post("breakpoint")=="start")
					  $getdata["startdatetime"]=$this->input->post("currentdatetime");
					  else
					  $getdata["enddatetime"]=$this->input->post("currentdatetime");
					  
					  $getdata["currentlatitude"]= $this->input->post("currentlatitude");
					  $getdata["currentlongitude"]=  $this->input->post("currentlongitude");
					  $getdata=json_encode($getdata);	 
					 
				$hascount=$this->user_model->countresult(array("assign_id"=>$this->input->post("assignid")),"`hourlyjob`");
					 if($hascount)
					 {
					$getresult= $this->user_model->getdatawithcondition("`break` as `breakdata`","`hourlyjob`",array("assign_id"=>$this->input->post("assignid")));
					$getdata= empty($getresult[0]->breakdata)?$getdata:$getresult[0]->breakdata."#@#".$getdata;
					$this->user_model->update_info("`hourlyjob`","assign_id",$this->input->post("assignid"),array('break'=>$getdata,'upadtedatetime'=>$this->input->post("currentdatetime")));
					 
					  $result["status"]=1;
					  $result["message"]="Information has been updated";
					  return $result;
					 }
					 
					}
					else if($this->input->post("type")=="end")
					{ 
					  $getdata["enddatetime"]=$this->input->post("currentdatetime");
					  
					  $getdata["currentlatitude"]= $this->input->post("currentlatitude");
					  $getdata["currentlongitude"]=  $this->input->post("currentlongitude");
					  $getdata=json_encode($getdata);	 
					 
			$hascount=$this->user_model->countresult(array("assign_id"=>$this->input->post("assignid")),"`hourlyjob`");
					 if($hascount)
					 {
					   $this->user_model->update_info("`hourlyjob`","assign_id",$this->input->post("assignid"),array('end'=>$getdata,'upadtedatetime'=>$this->input->post("currentdatetime"),'status'=>'done','end_time'=>date('Y-m-d H:i:s',strtotime($this->input->post("currentdatetime")))));
					  $result["status"]=1;
					  $result["message"]="Information has been updated";
					  return $result;
					 }
				    }
				}

	  }
   
}

?>