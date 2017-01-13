<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include("Subclass.php");

class App  extends Subclass

{

       private $senddata;

       private $datakey;

    

	public function userhourlygeolocation()

	{

	    

		       $data= file_get_contents("php://input");

			   $data = strip_tags($data);

               $clean_input = trim($data);

               $data = array();

               parse_str($clean_input, $data);



			   $result= $this->hourlyjoblocation();

			   header('Content-type: application/json');

			   echo json_encode($result);

	

	

	}

	public function deletehourlyjob()

	{

	     

		       $data= file_get_contents("php://input");

			   $data = strip_tags($data);

               $clean_input = trim($data);

               $data = array();

               parse_str($clean_input, $data);



			   $result= $this->deleteassignuserjob();

			   header('Content-type: application/json');

			   echo json_encode($result);

	

	}

	public function usergeolocation()

	{

	    

		       $data= file_get_contents("php://input");

			   $data = strip_tags($data);

               $clean_input = trim($data);

               $data = array();

               parse_str($clean_input, $data);



			   $result= $this->geolocation();

			   header('Content-type: application/json');

			   echo json_encode($result);

	

	

	} 

	

	public function getgeolocationtime()

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

				 

	$getresult= $this->user_model->getdatawithcondition("`upadtedatetime`,`status`,`start`,`break` as `userbreak`","`geolocation`",array("assign_task_id"=>$this->input->post("id")));

                  if(!empty($getresult))

                  {

                    $result["status"]=$getresult[0]->status;

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

				   $result["message"]='Not work';

				   }

				 }

			    header('Content-type: application/json');

			   echo json_encode($result);	 	

	}

    public function hourlyjoblocation()

	{

	

	            $this->form_validation->set_rules('assignid', 'send assign id', 'trim|required|xss_clean');

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

					 

				$hascount=$this->user_model->countresult(array("assign_id"=>$this->input->post("assignid")),"`hourly_job_location`");

				

					  if($hascount)

					  {

					  

					 $this->user_model->update_info("`hourly_job_location`","assign_id",$this->input->post("assignid"),array('start'=>$getdata,'upadtedatetime'=>$this->input->post("currentdatetime")));

					

					 

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

					 

					 $hascount=$this->user_model->countresult(array("assign_id"=>$this->input->post("assignid")),"`hourly_job_location`");

					 if($hascount)

					 {

					$getresult= $this->user_model->getdatawithcondition("`break` as `breakdata`","`hourly_job_location`",array("assign_id"=>$this->input->post("assignid")));

					$getdata= empty($getresult[0]->breakdata)?$getdata:$getresult[0]->breakdata."#@#".$getdata;

					$this->user_model->update_info("`hourly_job_location`","assign_id",$this->input->post("assignid"),array('break'=>$getdata,'upadtedatetime'=>$this->input->post("currentdatetime")));

					 

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

					 

					 $hascount=$this->user_model->countresult(array("assign_id"=>$this->input->post("assignid")),"`hourly_job_location`");

					 if($hascount)

					 {

					   $this->user_model->update_info("`hourly_job_location`","assign_id",$this->input->post("assignid"),array('end'=>$getdata,'upadtedatetime'=>$this->input->post("currentdatetime"),'status'=>'done'));

					  $result["status"]=1;

					  $result["message"]="Information has been updated";

					  return $result;

					 }

				    }

				}

					

	

	}

	

	public function geolocation()

	{

	

	            $this->form_validation->set_rules('id', 'Send Assign Task Id', 'trim|required|xss_clean');

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

				$hascount=$this->user_model->countresult(array("assign_task_id"=>$this->input->post("id")),"`geolocation`");

					  

					  if(!$hascount)

					  {

					   

					   $this->user_model->data_insert("`geolocation`",array('assign_task_id'=>$this->input->post("id"),'start'=>$getdata,'upadtedatetime'=>$this->input->post("currentdatetime"))); 

					  

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

					 

					 $hascount=$this->user_model->countresult(array("assign_task_id"=>$this->input->post("id")),"`geolocation`");

					 if($hascount)

					 {

					$getresult= $this->user_model->getdatawithcondition("`break` as `breakdata`","`geolocation`",array("assign_task_id"=>$this->input->post("id")));

					$getdata= empty($getresult[0]->breakdata)?$getdata:$getresult[0]->breakdata."#@#".$getdata;

					$this->user_model->update_info("`geolocation`","assign_task_id",$this->input->post("id"),array('break'=>$getdata,'upadtedatetime'=>$this->input->post("currentdatetime")));

					 

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

					 

					 $hascount=$this->user_model->countresult(array("assign_task_id"=>$this->input->post("id")),"`geolocation`");

					 if($hascount)

					 {

					   $this->user_model->update_info("`geolocation`","assign_task_id",$this->input->post("id"),array('end'=>$getdata,'upadtedatetime'=>$this->input->post("currentdatetime"),'status'=>'done'));

					  $result["status"]=1;

					  $result["message"]="Information has been updated";

					  return $result;

					 }

				    }

				}

					

	

	}

	

	public function changeemail()

	{

	    

		       $data= file_get_contents("php://input");

			   $data = strip_tags($data);

               $clean_input = trim($data);

               $data = array();

               parse_str($clean_input, $data);

			   $result= $this->changeemaillog($data);

			   header('Content-type: application/json');

			   echo json_encode($result);



	

	}

	public function changepassword()

	{

	           $data= file_get_contents("php://input");

			   $data = strip_tags($data);

               $clean_input = trim($data);

               $data = array();

               parse_str($clean_input, $data);

			  $result= $this->changepasswordlog($data);

			  header('Content-type: application/json');

			  echo json_encode($result);

	

	}



	public function assigntask()

	{

	

               $data= file_get_contents("php://input");

			   $data = strip_tags($data);

               $clean_input = trim($data);

               $data = array();

               parse_str($clean_input, $data);

			  $result= $this->getassigntask($data);

			  header('Content-type: application/json');

			  echo json_encode($result);

				

	}

	private function deleteassignuserjob()

	{

	

	          $this->form_validation->set_rules('assignid', 'assign id', 'required|xss_clean');

		      if($this->form_validation->run() == FALSE)

			  {

			      $result["status"]=0;

				  $errorarray=array_values($this->form_validation->error_array());

				  $result["message"]["error"]= $errorarray[0];

			  }

			  else

			  {

			   $result["status"]=1;

			   $this->user_model->row_delete_with_othertable('`hourly_job_location`',array("`assign_id`"=>$this->input->post("assignid")));

			  $result["message"]="Your job has been deleted!";

			  }

			  return $result;

	}

	private function getassigntask($data)

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
            
			 //$dayresult=$this->user_model->use_query("select DAYOFWEEK( CURDATE( )) as daynum");
		     $day_of_week = date('N', strtotime(date('d-m-Y')));
		// echo date('d-m-Y')."--".$day_of_week;die;   

		
			//if($dayresult[0]->daynum==1)
			if($day_of_week==7)
			{
			$data["startenddate"]=$this->user_model->use_query("select  DATE_FORMAT( CURDATE( ) - INTERVAL 7 -2

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
		
			   $data=	$this->user_model->three_table_join_with_condition("`assign_role_date`.`id` as `assign_id`,`user`.`occupation`,`assign_role_date`.`assign_date`,`roles`.`name` as `role_name`,`user`.`name`,DATE_FORMAT( STR_TO_DATE(  `assign_role_date`.`assign_date` ,  '%m-%d-%Y' ) ,  '%W' ) as dayname","`assign_role_date`","`user`","`roles`","`assign_role_date`.`user_id`=`user`.`user_id`","inner","`assign_role_date`.`role_id`=`roles`.`role_id`","inner","`user`.`email`='".$this->input->post('email')."' and `assign_role_date`.`id` not in(select `assign_task_id` from `geolocation` where status='done') and DATE_FORMAT( STR_TO_DATE(  `assign_role_date`.`assign_date` , '%m-%d-%y' ),  '%m-%d-%Y' ) between

DATE_FORMAT( CURDATE( ) - INTERVAL 7 -2

DAY ,  '%m-%d-%Y' ) and  

DATE_FORMAT( (

CURDATE( ) - INTERVAL 7

DAY ) + INTERVAL 9

DAY ,  '%m-%d-%Y'

)","`assign_role_date`.`assign_date`","asc",0, 100);
			   }
			   else
			   {
$data=	$this->user_model->three_table_join_with_condition("`assign_role_date`.`id` as `assign_id`,`user`.`occupation`,`assign_role_date`.`assign_date`,`roles`.`name` as `role_name`,`user`.`name`,DATE_FORMAT( STR_TO_DATE(  `assign_role_date`.`assign_date` ,  '%m-%d-%Y' ) ,  '%W' ) as dayname","`assign_role_date`","`user`","`roles`","`assign_role_date`.`user_id`=`user`.`user_id`","inner","`assign_role_date`.`role_id`=`roles`.`role_id`","inner","`user`.`email`='".$this->input->post('email')."' and `assign_role_date`.`id` not in(select `assign_task_id` from `geolocation` where status='done') and DATE_FORMAT( STR_TO_DATE(  `assign_role_date`.`assign_date` , '%m-%d-%y' ),  '%m-%d-%Y' ) between

DATE_FORMAT( CURDATE( ) - INTERVAL DAYOFWEEK( CURDATE( ) ) -2

DAY ,  '%m-%d-%Y' ) and  

DATE_FORMAT( (

CURDATE( ) - INTERVAL DAYOFWEEK( CURDATE( ) ) -2

DAY ) + INTERVAL 7

DAY ,  '%m-%d-%Y'

)","`assign_role_date`.`assign_date`","asc",0, 100);
                  
}


					 

						 $result["status"]=1;

						 $result["message"]=$data;

				}else

				{

$sdate=(string)$start_date;

$edate=(string)$end_date;

						   $data=	$this->user_model->three_table_join_with_condition("`user`.`occupation`,`assign_role_date`.`assign_date`,`roles`.`name` as `role_name`,`user`.`name`,DATE_FORMAT( STR_TO_DATE(  `assign_role_date`.`assign_date` ,  '%m-%d-%Y' ) ,  '%W' ) as dayname","`assign_role_date`","`user`","`roles`","`assign_role_date`.`user_id`=`user`.`user_id`","inner","`assign_role_date`.`role_id`=`roles`.`role_id`","inner"," `user`.`email`='".$this->input->post('email')."' and `assign_role_date`.`id` not in(select `assign_task_id` from `geolocation` where status='done') and DATE_FORMAT( STR_TO_DATE(  `assign_role_date`.`assign_date` , '%m-%d-%y' ) ,  '%m-%d-%Y' )  between '".$sdate."' and '".$edate."'","`assign_role_date`.`assign_date`","asc",0, 100);

					

				//die ($this->db->last_query());

						 $result["status"]=1;

						 $result["message"]=$data;

				

				

				

				}



		 }

		 return $result;

		  

	}

	

	private function uploadimage($filename)

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

    $file = fopen('assets/uploadimage/'.$filename, 'wb');

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

	private function small_img($filename)

	{

	   try

	   {

        $this->load->library('image_lib');

	    unset($config);

		$config['image_library'] = 'gd2';

        $config['source_image']	= 'assets/uploadimage/'.$filename.'';

        $config['new_image'] = 'assets/uploadimage/thumb/';

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

	private function generate_random_password($length = 15) 

	{

    $alphabets = range('A','Z');

    $numbers = range('0','9');

    $additional_characters = array('_','.');

    $final_array = array_merge($alphabets,$numbers,$additional_characters);

         

    $password = '';

  

    while($length--) {

      $key = array_rand($final_array);

      $password .= $final_array[$key];

    }

  

    return $password;

    }

	public function forgetpassword()

	{

	

	           

	           $data= file_get_contents("php://input");

			   $data = strip_tags($data);

               $clean_input = trim($data);

               $data = array();

               parse_str($clean_input, $data);

			   $message= $this->forgetpasswordlog();

			   header('Content-type: application/json');

			  echo json_encode($message); 

	}

	public function editprofile()

	{

	     

		       $data= file_get_contents("php://input");

			   $data = strip_tags($data);

               $clean_input = trim($data);

               $data = array();

               parse_str($clean_input, $data);

			 // print_r($data);

			   //die;

			   $message=$this->editprofilelog();

			   header('Content-type: application/json');

			   echo json_encode($message);

			   

			   

		 

	

	}	   

	public function signup()

	{

	

               $data= file_get_contents("php://input");

			   $data = strip_tags($data);

               $clean_input = trim($data);

               $data = array();

               parse_str($clean_input, $data);

			 // print_r($data);

			   //die;

			   $message=$this->userlog();

			  header('Content-type: application/json');

			  echo json_encode($message);

			   

	

	}

	private function checksession()

    {

	  $getid= $this->session->userdata('user_id');

	  return (empty($getid)?0:1);

    }

	public function userinfo()

	{

	     

		 $this->form_validation->set_rules('email', 'Email', 'required|valid_email|xss_clean');

	     if($this->form_validation->run() == FALSE)

		  {

                  $result["status"]=0;

				  $errorarray=array_values($this->form_validation->error_array());

				  //$result["message"]["error"]= implode(',',$this->form_validation->error_array());

				  //$result["message"]= $this->form_validation->error_array();

				  $result["message"]["error"]=$errorarray[0];

		  }

		 else

		 {

		 $fetch_data=  $this->user_model->getdatawithcondition('name,license_number,mobile,email,bsb,acc,occupation,fix_amount,imagename','user',array('email'=>$this->input->post('email')));

	  

	  $userinfo=array();

	  foreach($fetch_data as $row)

	  {

	  $userinfo["name"]=$row->name;

	  $userinfo["license_number"]=$row->license_number;

	  $userinfo["mobile"]=$row->mobile;

	  $userinfo["email"]=$row->email;

	  $userinfo["bsb"]=$row->bsb;

	  $userinfo["acc"]=$row->acc;

	  $userinfo["occupation"]=$row->occupation;

      $userinfo["fix_amount"]=$row->fix_amount;

	  $filename=$row->license_number.".jpg";

     $path= site_url('assets/uploadimage/'.$filename.'');

	 $userinfo["imagepath"]=$path;

     $type = pathinfo($path, PATHINFO_EXTENSION);

     $data = file_get_contents($path);



     $img= base64_encode($data);



//echo '<img src="data:image/jpeg;base64,'.$img.'" />';

//die;

	  

	  $userinfo["imagename"]=$img;

	  }

	  $result["status"]=1;

      $result["message"]=$userinfo;

      }

	  return $result;

	

	}

	public function displayroll()

	{

	 

	     $this->form_validation->set_rules('email', 'Email', 'required|valid_email|xss_clean');

          if($this->form_validation->run() == FALSE)

		  {

                  $result["status"]=0;

				  //$result["message"]= $this->form_validation->error_array();

				  $errorarray=array_values($this->form_validation->error_array());

				  $result["message"]["error"]=$errorarray[0];

				  

				  

		  }else

		  {

		  

	 $userdata= $this->user_model->getdatawithcondition("user_id","user",array("email"=>$this->input->post('email'))); 

	 $assignjob= $this->user_model->leftright_join_with_limit("`roles`.`role_id`,`roles`.`name`","`roles`","`hourly_job_location`","`roles`.`role_id`=`hourly_job_location`.`role_id`","inner",array("`hourly_job_location`.`status`"=>"pending","`hourly_job_location`.`user_id`"=>$userdata[0]->user_id),0,1);

	 

	 if(count($assignjob))

	 {

	  $result["status"]=1;

      $result["roles"]=$assignjob;

	 }

	 else

	 {

	   $data=$this->user_model->getalldatawithorderby("`roles`.`role_id`,`roles`.`name`","`roles`","`occupation`","asc");

       $result["status"]=1;

       $result["roles"]=$data;

	 }

	header('Content-type: application/json');

	echo json_encode($result);

			 

   }

	 

	 

		  

	}

	public function assignrole()

	{

	

	           $data= file_get_contents("php://input");	   

			   $data = strip_tags($data);

               $clean_input = trim($data);

               $data = array();

               parse_str($clean_input, $data);

	           $message=$this->assignlog();

			  header('Content-type: application/json');

		      echo json_encode($message);	

	}

	private function assignlog()

	{

	      $this->form_validation->set_rules('roleid', 'Role Id', 'required|xss_clean');

		  $this->form_validation->set_rules('email', 'Email', 'required|valid_email|xss_clean');

          if($this->form_validation->run() == FALSE)

		  {

                  $result["status"]=0;

				  

				  $errorarray=array_values($this->form_validation->error_array());

				  $result["message"]["error"]=$errorarray[0];

				  

		  }else

		  {

		  

		  

		         $userdata= $this->user_model->getdatawithcondition("user_id","user",array("email"=>$this->input->post('email'))); 

				 $gethourlyjob=$this->user_model->getdatawithcondition("hourly_job_location.`assign_id`","hourly_job_location",array("`hourly_job_location`.`status`"=>"pending","`hourly_job_location`.`role_id`"=>$this->input->post('roleid')));

				if(count($gethourlyjob))

				{

				  $result["status"]=1;

				  $result["assignid"]=$gethourlyjob[0]->assign_id;

				}

				else

				{

				 $assignid= $this->user_model->insert_data("hourly_job_location",array("role_id"=>$this->input->post('roleid'),"user_id"=>$userdata[0]->user_id));

				 $result["status"]=1;

				 $result["assignid"]=$roleid;

				}

				 $roledata= $this->user_model->getdatawithcondition("name","roles",array("role_id"=>$this->input->post('roleid'))); 

				 $result["message"]=$roledata[0]->name." has assign to you.";

		  }

		  return $result;

	

	}

	public function userprofile()

	{

               $data= file_get_contents("php://input");

			   $data = strip_tags($data);

               $clean_input = trim($data);

               $data = array();

               parse_str($clean_input, $data);

              $message=$this->userinfo();

			  header('Content-type: application/json');

			   echo json_encode($message);

	

	}

	public function singin()

	{

	

              $data= file_get_contents("php://input");

			   $data = strip_tags($data);

               $clean_input = trim($data);

               $data = array();

               parse_str($clean_input, $data);

			 // print_r($data);

			   //die;

			   $message=$this->signinlog();

			  header('Content-type: application/json');

			   echo json_encode($message);

	

	

	}

	//******* after login it display user profile-------//

	public function usersignin()

	{

	

	          $data= file_get_contents("php://input");

			   $data = strip_tags($data);

               $clean_input = trim($data);

               $data = array();

               parse_str($clean_input, $data);

			 // print_r($data);

			   //die;

			   $message=$this->usersigninlog();

			  header('Content-type: application/json');

			   echo json_encode($message);

	

			

			

	}



	private function forgetpasswordlog()

	{

	     $this->form_validation->set_rules('email', 'Email', 'required|valid_email|xss_clean');

	     if($this->form_validation->run() == FALSE)

		  {

                  $result["status"]=0;

				  //$result["message"]["error"]= implode(',',$this->form_validation->error_array());

				  //$result["message"]= $this->form_validation->error_array();

				  $errorarray=array_values($this->form_validation->error_array());

				  $result["message"]["error"]=$errorarray[0];

		  }else

		  {

		  

		      $count=$this->user_model->countresult(array("email"=>$this->input->post('email')),"user");

		      if($count)

			  {

		       $newpassword=$this->generate_random_password($length = 15);

		       $password=sha1($newpassword); 

		       $this->user_model->update_info("user","email",$this->input->post('email'),array("password"=>$password));

			   $name= $this->user_model->getdatawithcondition("name","user",array("email"=>$this->input->post('email')));

		       $username=$name[0]->name;

			   $this->user_model->send_email_forgetpassword($username,$this->input->post('email'),$newpassword);

			   $result["status"]=1;

			   $result["message"]= "Your new password has been send to your email id: ".$this->input->post('email')."";

			  }

			  else

			  {

			   $result["status"]=0;

			   $result["message"]["error"]= "Email accound does not exist";

			  }

		  }

	    return $result;

	}

	/*** after log in it display user profile *******/

	private function usersigninlog()

	{


	      $this->form_validation->set_rules('email', 'Email', 'required|valid_email|xss_clean');

		  $this->form_validation->set_rules('password', 'Password', 'required|sha1|xss_clean');

          if($this->form_validation->run() == FALSE)

		  {

                  $result["status"]=0;

				  //$result["message"]= $this->form_validation->error_array();

				  $errorarray=array_values($this->form_validation->error_array());

				  //$result["message"]["error"]=$errorarray[0];

				  $result["message"]=$errorarray[0];

		  }

		  else

		  {



			$data=array('email'=>$this->input->post('email'),'password'=>$this->input->post('password'));

			$count=$this->user_model->countresult($data,'user');

            

			if($count==0)

			{

			$result["status"]=0;

			

			//$result["message"]= "Enter valid email address and password";

			$result["message"]["error"]= "Enter valid email address and password";

			}

		else

		{

			

			$condition=array('email'=>$this->input->post('email'),'password'=>$this->input->post('password'));

			$hasactive=$this->user_model->getdatawithcondition("active","user",$condition);

			if($hasactive[0]->active==0)

			{

			  $random_num=sha1(uniqid()); 

			  $this->user_model->update_info("user","email",$this->input->post('email'),array("random_num"=>$random_num));

			  $getid= $this->user_model->getdatawithcondition("user_id","user",$condition);

			  $id=$getid[0]->user_id;

			  $this->user_model->send_active_message($this->input->post("user"),$this->input->post("email"),$id,$random_num);	
              
			  if($this->input->post("devicetoken") && !empty($this->input->post("devicetoken")))
			  {
			  $this->user_model->update_info("user",'email',$this->input->post('email'),array('devicetoken'=>$this->input->post("devicetoken")));
			  }
			  $result["status"]=0; 

			  $result["message"]["error"]="Please active your account.For active your account go to your email id:".$this->input->post("email").""; 

			}else

			{

			$data=$this->user_model->getdatawithcondition("user_id","user",array('email'=>$this->input->post('email'),'password'=>$this->input->post('password')));



			$this->session->set_userdata('user_id',$data[0]->user_id);

			

			      

			$fetch_data=  $this->user_model->getdatawithcondition('name,license_number,mobile,email,bsb,acc,occupation,fix_amount,imagename','user',array('email'=>$this->input->post('email')));

				  

				  $userinfo=array();

				  foreach($fetch_data as $row)

				  {

				  $userinfo["name"]=$row->name;

				  $userinfo["license_number"]=$row->license_number;

				  $userinfo["mobile"]=$row->mobile;

				  $userinfo["email"]=$row->email;

				  $userinfo["bsb"]=$row->bsb;

				  $userinfo["acc"]=$row->acc;

				  $userinfo["occupation"]=$row->occupation;

				  $userinfo["fix_amount"]=$row->fix_amount;

				  $filename=$row->license_number.".jpg";

				 $path= site_url('assets/uploadimage/'.$filename.'');

				 $userinfo["imagepath"]=$path;

				 $type = pathinfo($path, PATHINFO_EXTENSION);

                 $data = file_get_contents($path);



                 $img= base64_encode($data);



	              $userinfo["imagebytecode"]=$img;

				 

				  }

				  $result["status"]=1;

				  $result["message"]=$userinfo;

				  

			

			

			

			}

			

			}

		  }

		  return $result;

    }

	

	

	

	private function signinlog()

	{





	      $this->form_validation->set_rules('email', 'Email', 'required|valid_email|xss_clean');

		  $this->form_validation->set_rules('password', 'Password', 'required|sha1|xss_clean');

          if($this->form_validation->run() == FALSE)

		  {

                  $result["status"]=0;

				  //$result["message"]= $this->form_validation->error_array();

				  $errorarray=array_values($this->form_validation->error_array());

				  $result["message"]["error"]=$errorarray[0];

		  }

		  else

		  {



			$data=array('email'=>$this->input->post('email'),'password'=>$this->input->post('password'));

			$count=$this->user_model->countresult($data,'user');

            

			if($count==0)

			{
              
			$result["status"]=0;

			

			//$result["message"]= "Enter valid email address and password";

			$result["message"]["error"]= "Enter valid email address and password";

			}

			else

			{

			

			$condition=array('email'=>$this->input->post('email'),'password'=>$this->input->post('password'));

			$hasactive=$this->user_model->getdatawithcondition("active","user",$condition);

			if($hasactive[0]->active==0)

			{

			  $random_num=sha1(uniqid()); 

			  $this->user_model->update_info("user","email",$this->input->post('email'),array("random_num"=>$random_num));

			  $getid= $this->user_model->getdatawithcondition("user_id","user",$condition);

			  $id=$getid[0]->user_id;

			  $this->user_model->send_active_message($this->input->post("user"),$this->input->post("email"),$id,$random_num);	

			  $result["status"]=0; 

			  $result["message"]["error"]="Please active your account.For active your account go to your email id:".$this->input->post("email").""; 

			}else

			{
              

			$data=$this->user_model->getdatawithcondition("user_id","user",array('email'=>$this->input->post('email'),'password'=>$this->input->post('password')));



			$this->session->set_userdata('user_id',$data[0]->user_id);

			$result["status"]=1; 

			$result["message"]="you have been successfully logged in";

			}

			

			}

		  }

		  return $result;

    }

	public function uniqueemail($newemail,$oldemail)

	{

      $getcount= $this->user_model->countresult(array("email"=>$newemail,"email!="=>$oldemail),"user"); 

	  if($getcount)

	  {

	  $this->form_validation->set_message('uniquelincese', 'This email allready existed');

      return false;

	  }

	  return true;

	}

	private function changeemaillog()

	{

	     $this->form_validation->set_rules('oldemail', 'Old email address', 'trim|required|valid_email|xss_clean');

		 $this->form_validation->set_rules('newemail', 'New email address', 'trim|required|valid_email|callback_uniqueemail|xss_clean');

		 if($this->form_validation->run() === FALSE)

         {

	      $result["status"]=0;

		  $errorarray=array_values($this->form_validation->error_array());

          $result["message"]["error"]=$errorarray[0];

	     }

		 else

		 {

		 $random_num=sha1(uniqid());

		 $this->user_model->update_info("user","email",trim($this->input->post("oldemail")),array("email"=>$this->input->post("newemail"),'random_num'=>$random_num,'active'=>'0'));

		 

		 

		 $dataid=$this->user_model->getdatawithcondition("user_id,name,email","user",array('email'=>$this->input->post('newemail')));



      $this->user_model->send_email_forchangeemail($dataid[0]->name,$dataid[0]->email,$dataid[0]->user_id,$random_num);	

		 

	$result["status"]=1;

	$result["message"]="Your email has been changed. For Active Your Account Go to Your Email Address:".$dataid[0]->email;	  	  

		 }

		 return $result; 

	

	}

	private function changepasswordlog()

	{

	  $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|xss_clean');

 	  $this->form_validation->set_rules('oldpass', 'Old Password', 'required|min_length[8]|max_length[15]|xss_clean');

	  $this->form_validation->set_rules('newpass', 'New Password', 'required|min_length[8]|max_length[15]|xss_clean');

	  if($this->form_validation->run() === FALSE)

      {

	    $result["status"]=0;

		$errorarray=array_values($this->form_validation->error_array());

        $result["message"]["error"]=$errorarray[0];

	  }

	  else

	  {

	   $count=  $this->user_model->countresult(array('email'=>$this->input->post("email")),'user');

	   

	   if(!$count)

	   {

	   $result["message"]["error"]="This email is not exist in database";

	   }

	   else

	   {

	      $count=  $this->user_model->countresult(array('email'=>$this->input->post("email"),"password"=>sha1($this->input->post("oldpass")),"active"=>'1'),'user');

	      if(!$count)

		  {

		  $result["message"]["error"]="Your Old password is not match in database";

		  }

		  else

		  {

		  $this->user_model->update_info("user","email",trim($this->input->post("email")),array("password"=>sha1($this->input->post("newpass"))));

		  $result["message"]="Your password has been changed";

		  }

	   }

	   

	   }

	  return $result;

	}

	public function uniquelincese($lincesenumber,$email)

	{

      $getcount= $this->user_model->countresult(array("license_number"=>$lincesenumber,"email!="=>$email),"user"); 

	  if($getcount)

	  {

	  $this->form_validation->set_message('uniquelincese', 'This lincese number allready exist');

      return false;

	  }

	  return true;

	}

	

	

	public function uniquemobile($mobile,$email)

	{

      $getcount= $this->user_model->countresult(array("mobile"=>$mobile,"email!="=>$email),"user"); 

	  if($getcount)

	  {

	  $this->form_validation->set_message('uniquemobile', 'This mobile number allready exist');

      return false;

	  }

	  return true;

	}

	public function uniquebsb($bsbaccount,$email)

	{

	

	  $getcount= $this->user_model->countresult(array("bsb"=>$bsbaccount,"email!="=>$email),"user"); 

	  if($getcount)

	  {

	  $this->form_validation->set_message('uniquebsb', 'This bsb account number allready exist');

      return false;

	  }

	  return true;

	

	}

	

	public function uniqueacc($accaccount,$email)

	{

	

	  $getcount= $this->user_model->countresult(array("acc"=>$accaccount,"email!="=>$email),"user"); 

	  if($getcount)

	  {

	  $this->form_validation->set_message('uniqueacc', 'This acc account number allready exist');

      return false;

	  }

	  return true;

	

	}

	private function editprofilelog()

	{

	   

	  $this->form_validation->set_rules('username', 'Name', 'trim|required|min_length[3]|max_length[100]|xss_clean');

	  $this->form_validation->set_rules('useremail', 'Email', 'trim|required|valid_email|max_length[100]|xss_clean');

	  $this->form_validation->set_rules('userlincese', 'Lincese', 'trim|required|min_length[5]|max_length[100]|callback_uniquelincese['.$this->input->post("useremail").']|xss_clean');

	  $this->form_validation->set_rules('usermobile', 'Mobile', 'trim|required|callback_uniquemobile['.$this->input->post("useremail").']|min_length[10]|max_length[15]|xss_clean');

	  $this->form_validation->set_rules('userbsb', 'BSB Account', 'trim|required|alpha_dash|max_length[100]|xss_clean');

	  $this->form_validation->set_rules('useracc', 'Acc Account', 'trim|alpha_dash|callback_uniqueacc['.$this->input->post("useremail").']|max_length[100]|xss_clean');

	  $this->form_validation->set_rules('useroccupations', 'Occupations', 'trim|required|max_length[100]|xss_clean');

	  //$this->form_validation->set_rules('usertype', 'Type', 'trim|required|max_length[100]|xss_clean');

	  $this->form_validation->set_rules('image', 'Upload Image', 'trim|required|xss_clean');

	  if($this->form_validation->run() === FALSE)

	  {

	    $result["status"]=0;

	    $errorarray=array_values($this->form_validation->error_array());

        $result["message"]["error"]=$errorarray[0];

	  }

	  else

	  {
         $filename=$this->input->post("userlincese").".jpg";
	     @unlink('assets/uploadimage/'.$filename.'');
	    $next= $this->uploadimage($this->input->post("userlincese"));

	    if($next)

	    {

		@unlink('assets/uploadimage/thumb/'.$filename.'');

	    $lincese=$this->input->post("userlincese");

	    $filename=$lincese.".jpg";

	    $this->small_img($filename); 

		}

	   $filename=$this->input->post("userlincese")."_thumb.jpg";

			 

/*$data=array("name"=>$this->input->post("username"),"license_number"=>$this->input->post("userlincese"),"mobile"=>$this->input->post("usermobile"),"occupation"=>$this->input->post("useroccupations"),"bsb"=>$this->input->post("userbsb"),"acc"=>$this->input->post("useracc"),"type"=>$this->input->post("usertype"),"imagename"=>$filename);
*/
$data=array("name"=>$this->input->post("username"),"license_number"=>$this->input->post("userlincese"),"mobile"=>$this->input->post("usermobile"),"occupation"=>$this->input->post("useroccupations"),"bsb"=>$this->input->post("userbsb"),"acc"=>$this->input->post("useracc"),"imagename"=>$filename);	  

	  $this->user_model->update_info("user","email",$this->input->post("useremail"),$data);

	  $result["status"]=1;

	  $result["message"]="Your Information has been updated!";

	  }	 

	return $result;

	

	}

	private function userlog()

	{

	

	  $this->form_validation->set_rules('username', 'Name', 'trim|required|min_length[3]|max_length[100]|xss_clean');

	  $this->form_validation->set_rules('useremail', 'email', 'trim|required|valid_email|is_unique[user.email]|xss_clean');

	  $this->form_validation->set_rules('userlincese', 'lincese number', 'trim|required|is_unique[user.license_number]|min_length[5]|max_length[100]|xss_clean');

	  $this->form_validation->set_rules('usermobile', 'mobile number', 'trim|required|min_length[10]|max_length[15]|is_unique[user.mobile]|xss_clean');

	  $this->form_validation->set_rules('userpassword', 'Password', 'trim|required|min_length[8]|max_length[15]|xss_clean');

	  $this->form_validation->set_rules('userconfirmpassword', 'Confirm Password', 'trim|required|matches[userpassword]|xss_clean');

	  $this->form_validation->set_rules('userbsb', 'BSB Account', 'trim|required|alpha_dash|max_length[100]|xss_clean');

	  $this->form_validation->set_rules('useracc', 'Acc Account', 'trim|alpha_dash|is_unique[user.acc]|max_length[100]|xss_clean');

	  $this->form_validation->set_rules('useroccupations', 'Occupations', 'trim|required|max_length[100]|xss_clean');

	  /*$this->form_validation->set_rules('usertype', 'Type', 'trim|required|max_length[100]|xss_clean');*/

	 /* $this->form_validation->set_rules('image', 'Upload Image', 'trim|required|xss_clean');*/

	  $this->form_validation->set_message('is_unique', 'This %s already exist');

	  if($this->form_validation->run() === FALSE)

      {

	    

        $result["status"]=0;

		

		//print_r(emplode(array_values($this->form_validation->error_array()));

		

		//$result["message"][]= $this->form_validation->error_array();

		//$result["message"]= $this->form_validation->error_array();

		$errorarray=array_values($this->form_validation->error_array());

        $result["message"]["error"]=$errorarray[0];

	  }

	  else

	  {

	   $next= $this->uploadimage($this->input->post("userlincese"));

	   

	   if($next)

	   {

	   $lincese=$this->input->post("userlincese");

	   $filename=$lincese.".jpg";

	   $this->small_img($filename); 

	  $random_num=sha1(uniqid());


/*
	  $data=array("name"=>$this->input->post("username"),"email"=>$this->input->post("useremail"),"password"=>sha1($this->input->post("userpassword")),"license_number"=>$this->input->post("userlincese"),"mobile"=>$this->input->post("usermobile"),"occupation"=>$this->input->post("useroccupations"),"bsb"=>$this->input->post("userbsb"),"acc"=>$this->input->post("useracc"),"type"=>$this->input->post("usertype"),"imagename"=>$filename,"random_num"=>$random_num);
*/

  $data=array("name"=>$this->input->post("username"),"email"=>$this->input->post("useremail"),"password"=>sha1($this->input->post("userpassword")),"license_number"=>$this->input->post("userlincese"),"mobile"=>$this->input->post("usermobile"),"occupation"=>$this->input->post("useroccupations"),"bsb"=>$this->input->post("userbsb"),"acc"=>$this->input->post("useracc"),"imagename"=>$filename,"random_num"=>$random_num);
  
	  $this->user_model->data_insert('user',$data);

	  $dataid=$this->user_model->getdatawithcondition("user_id","user",array('email'=>$this->input->post('useremail')));







	$this->user_model->send_active_message($this->input->post("username"),$this->input->post("useremail"),$dataid[0]->user_id,$random_num);	

		$result["status"]=1;

		$result["message"]="Your Are Successfully Register. For Active Your Account Go to Your Email Address:".$this->input->post("useremail");	  	  

	    }

	  }

	  return $result;

	}

	

 }  

?>