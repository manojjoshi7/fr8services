<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Parentclass  extends CI_Controller 

{



    public function __construct() 

	{

	  parent::__construct();

	  $this->load->model('user_model');

	}
	public function ios_push()
	{
	$this->load->model('push_model');
	$this->push_model->sendIosPushNotification();
	
	}
    public function android_push()
	{
	$this->load->model('push_model');
	//$regId = 'dOe7vPtzca4:APA91bFQp_Z4Tugtj_55xJ7cz7IQFtbfXBbxC2pacnkX0QKUKC-DKjI-nGnrTK-HsyOVRBUj2rAggeyk8hN4cJe_s56gZYdtwMDK8XKRw4EcvTXhfhcpvOpxW4QhQ4ml6KKnpL3QeEZv';
	//$msg_payload = array('mtitle' => 'message','mdesc' => "hello sunil how are you.How goes your fucking day");
	//$result=$this->push_model->android($msg_payload, $regId);
	///$result=$this->push_model->send($regId, "hello sunil how are you.How goes your fucking day");
	$result=$this->push_model->sendPushNotification(); 
	print_r($result);
	die("funcking me");
	
	}
    private function truckrolelog()

	{

	  $this->form_validation->set_rules('truckrole', 'Role Name','trim|required|max_length[50]|is_unique[truckrole.role_name]|xss_clean');

	 if($this->form_validation->run() === FALSE)

	 {

	  return true;

	 }else

	 {

	  $data=array("role_name"=>$this->input->post("truckrole"));

	  $this->user_model->data_insert('truckrole',$data);

	  

	  redirect('/admin/truckrole','refresh');

	 }

	

	}

	public function truck_role_name()

	{

	  $roleid=$this->input->post("truckroleid");

	  $role_name=$this->input->post("truckrole");

	  $result=$this->user_model->countresult(array("id!="=>$roleid,"lower(role_name)"=>strtolower($role_name)),"truckrole");

		  if($result==0)

		  {

		    return true;

		  }

		  else

		  {

		    $this->form_validation->set_message('truck_role_name', 'This %s allready exist');

		    return FALSE;

		  }



	}

	private function truckeditrolelog()

	{

	    $this->form_validation->set_rules('truckrole', 'Role Name','trim|required|max_length[50]|callback_truck_role_name|xss_clean');

	 if($this->form_validation->run() === FALSE)

	 {

	  return true;

	 }else

	 {

	   $data=array("role_name"=>$this->input->post("truckrole"));

	   $this->user_model->update_info('truckrole','id',$this->input->post("truckroleid"),$data);

	   redirect('/admin/truckrole','refresh');

	 }

	

	}

	public function truckrole($id=NULL,$task=NULL)

	{

	   

	    if($this->checksession()==1)

		{

           

	      $getid= $this->session->userdata('adminid');

		  $data=array('id'=>$getid);

		  $userdata["admininfo"]=$this->user_model->get_info('admin',$data);

          $userdata["name"]=$userdata["admininfo"][0]->name;

		  $userdata["activeurl"]="truckrole";

		  $this->load->view('admin/header',$userdata);

		  

		  $editrole='no';

		  if(isset($id) && !empty($id) && isset($task) && !empty($task))

		  {

		   $data["rolenameinfo"]=$this->user_model->preventdata("select `id`,`role_name` FROM `truckrole` where `id`=?",array($id));

           if(count($data["rolenameinfo"])==0)

		   {

		     redirect('/admin/truckrole','refresh');		

		   }

		   else

		   {

		    $editrole='yes';

		    $data["truckroleid"]=$id;

		   }

		  

		  }

		  if($_POST)

		  {

		    

		    if($this->input->post("truckroleid")!=FALSE)

			{

			  $editrole='yes';

			  $data["truckroleid"]=$this->input->post("truckroleid");

			  $this->truckeditrolelog();

			}else

			{

		     $this->truckrolelog();

			}

		  }

		   $getpaginationlink=$this->pagination("admin/truckrole","truckrole",50);

		   $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

		   $page=($editrole=='yes'?0:$page);

		   $data['trackrole']=$this->user_model->getalldata('id,role_name','truckrole',50,$page);

		   $data["links"] = $getpaginationlink;

		  

		  $this->load->view('admin/truckrole',$data);

		  $this->load->view('admin/footer');

		 }

		 else

		 {

		   redirect('/admin','refresh');		

		 }

	

	}
    public function helperhourlyjobassign()
	{
	    if($this->checksession()==1)

		     {

               $getid= $this->session->userdata('adminid');

		       $data=array('id'=>$getid);

		       $userdata["admininfo"]=$this->user_model->get_info('admin',$data);

               $userdata["name"]=$userdata["admininfo"][0]->name;

		       $userdata["activeurl"]="helperhourlyjobassign";

		       $this->load->view('admin/header',$userdata);

			   if($_POST)
               {

			      $this->hourlyjobassignlog('helper');

			   }

			   

			   $totaldriver=$this->user_model->countresult("user.occupation='helper'","user");

		       if($totaldriver==0)

		       {

		        $this->session->set_flashdata('message', '<div class="alert alert-info">No Driver exist. First add driver here.</div>');

		        redirect('/admin/adduser','refresh');

		       }

			   else

			   {

			   $data["drivers"]=$this->user_model->getdatawithcondition("`user_id`,`name`","`user`",array("`occupation`"=>"helper"));    }

			   $totalcomapny=$this->user_model->countresult(NULL,"company");

			   if($totalcomapny==0)

		       {

			   $this->session->set_flashdata('message', '<div class="alert alert-info">No Company exist. First add Company here.</div>');  redirect('/admin/addcompany','refresh');

			   }else

			   {

			   $data["company"]=$this->user_model->use_query("select `id`,`name` from `company`");

			   }

			   $gettotal=$this->user_model->countresult(NULL,"truck_info");

			   if($gettotal==0)

			   {

			  $this->session->set_flashdata('message', '<div class="alert alert-info">No Truck Info exist. First add Truck Info here.</div>'); 

			  redirect('/admin/addtruck','refresh');

			   }else

			   {

			   $data["fr8_no"]=$this->user_model->use_query("select `id`,`fr8_no` from `truck_info`");

			   }

			   $gettotal=$this->user_model->countresult(NULL,"truckrole");

			   if($gettotal==0)

			   {

			   $this->session->set_flashdata('message', '<div class="alert alert-info">No Truck Role exist. First add Truck Role here.</div>'); 

			  redirect('/admin/truckrole','refresh');
			   }else
			   {

			   $data["role_names"]=$this->user_model->use_query("select `id`,`role_name` from `truckrole`");

			   }

			   $this->load->view('admin/helperhourlyjobassign',$data);
			   $this->load->view('admin/footer');
	         }else{

			    redirect('/admin','refresh');		

			 }

	}
    public function hourlyjobassign()
    {

             if($this->checksession()==1)

		     {

               $getid= $this->session->userdata('adminid');

		       $data=array('id'=>$getid);

		       $userdata["admininfo"]=$this->user_model->get_info('admin',$data);

               $userdata["name"]=$userdata["admininfo"][0]->name;

		       $userdata["activeurl"]="hourlyjobassign";

		       $this->load->view('admin/header',$userdata);
			   if($_POST)
               {
			      $this->hourlyjobassignlog('driver');
               }
			   $totaldriver=$this->user_model->countresult("user.occupation='driver'","user");
               if($totaldriver==0)
               {

		        $this->session->set_flashdata('message', '<div class="alert alert-info">No Driver exist. First add driver here.</div>');
                redirect('/admin/adduser','refresh');

		       }
               else
               {

$data["drivers"]=$this->user_model->getdatawithconditionwithorder("`user_id`,`name`","`user`",array("`occupation`"=>"driver"),"`user`.`name`","asc");  
			   
			   }

			   $totalcomapny=$this->user_model->countresult(NULL,"company");

			   if($totalcomapny==0)

		       {

			   $this->session->set_flashdata('message', '<div class="alert alert-info">No Company exist. First add Company here.</div>');  redirect('/admin/addcompany','refresh');

			   }else

			   {

			   $data["company"]=$this->user_model->use_query("select `id`,`name` from `company`");

			   }

			   $gettotal=$this->user_model->countresult(NULL,"truck_info");

			   if($gettotal==0)

			   {

			  $this->session->set_flashdata('message', '<div class="alert alert-info">No Truck Info exist. First add Truck Info here.</div>'); 

			  redirect('/admin/addtruck','refresh');

			   }else

			   {

			   $data["fr8_no"]=$this->user_model->use_query("select `id`,`fr8_no` from `truck_info`");

			   }

			   $gettotal=$this->user_model->countresult(NULL,"truckrole");

			   if($gettotal==0)

			   {

			   $this->session->set_flashdata('message', '<div class="alert alert-info">No Truck Role exist. First add Truck Role here.</div>'); 

			  redirect('/admin/truckrole','refresh');

			   

			   }else

			   {

			   $data["role_names"]=$this->user_model->use_query("select `id`,`role_name` from `truckrole`");

			   }

			   $this->load->view('admin/hourlyjobassign',$data);

			   

			   $this->load->view('admin/footer');

			   

	         }

			 else

			 {

			 

			    redirect('/admin','refresh');		

			 }

	

	

	}

	private function editdriverhourlyjoblog($usertype)
    {

		 if($usertype=="driver")
		 {
		 $this->form_validation->set_rules('drivername', 'Driver Name', 'trim|required|max_length[50]|xss_clean');
		 }
		 else
		 {
		 $this->form_validation->set_rules('helpername', 'Helper Name', 'trim|required|max_length[50]|xss_clean');
		 }
	   $this->form_validation->set_rules('fr8_no', 'FR8 No', 'trim|required|xss_clean');
       $this->form_validation->set_rules('timepicker-one', 'Expected Time', 'trim|required|max_length[50]|xss_clean');
       $this->form_validation->set_rules('startform', 'Start Form', 'trim|required|xss_clean');
       $this->form_validation->set_rules('company_for', 'Company For', 'trim|required|alpha_dash|max_length[50]|xss_clean');	       $this->form_validation->set_rules('truckrole', 'Role', 'trim|required|xss_clean');
       $this->form_validation->set_rules('per_hour', 'Per Hour', 'trim|required|decimal|max_length[10]|xss_clean'); 
       $this->form_validation->set_rules('assigndate', 'Assign Dates', 'trim|required|xss_clean');
       $this->form_validation->set_rules('work_description', 'Work Description', 'trim|required|xss_clean'); 

	 if($this->form_validation->run() === FALSE)
     {
      return true;
     }else
     {
	 
	$this->user_model->row_delete_with_othertable('hourly_job_assign',array('id'=>$this->input->post("hourlyjobassignid")));
    $assigndate= explode(',',$this->input->post("assigndate"));
    $userid=($usertype=="driver"?$this->input->post("drivername"):$this->input->post("helpername"));
	foreach($assigndate as $key=>$getdate)
    {
	    $gettotal=$this->user_model->countresult(array("user_id"=>$userid,"assign_dates"=>$getdate),'hourly_job_assign');
	    if($gettotal)
        {
         continue;
        }

	   $data=array("user_id"=>$userid,"fr8no"=>$this->input->post("fr8_no"),"expectedtime"=>$this->input->post("timepicker-one"),"start_form"=>$this->input->post("startform"),"company_id"=>$this->input->post("company_for"),"truck_role_id"=>$this->input->post("truckrole"),"per_hour"=>$this->input->post("per_hour"),"assign_dates"=>$getdate,"description"=>$this->input->post("work_description"));
      $this->user_model->data_insert('hourly_job_assign',$data);
	   }
      if($usertype=="driver")
	  redirect('/admin/displayhourlyjob','refresh'); 
	  else
	  redirect('/admin/helperdisplayhourlyjob','refresh'); 

	 }

	

	}

	private function hourlyjobassignlog($usertype)

	{

	      
     if($usertype=="driver")
     $this->form_validation->set_rules('drivername', 'Driver Name', 'trim|required|max_length[50]|xss_clean');
     else if($usertype=="helper")
	 $this->form_validation->set_rules('helpername', 'Helper Name', 'trim|required|max_length[50]|xss_clean');
	 $this->form_validation->set_rules('fr8_no', 'FR8 No', 'trim|required|xss_clean');

	 $this->form_validation->set_rules('timepicker-one', 'Expected Time', 'trim|required|max_length[50]|xss_clean');

	 $this->form_validation->set_rules('startform', 'Start Form', 'trim|required|xss_clean');

     $this->form_validation->set_rules('company_for', 'Company For', 'trim|required|alpha_dash|max_length[50]|xss_clean');	     $this->form_validation->set_rules('truckrole', 'Role', 'trim|required|xss_clean');

	 $this->form_validation->set_rules('per_hour', 'Per Hour', 'trim|required|decimal|max_length[10]|xss_clean'); 

	 $this->form_validation->set_rules('assigndate', 'Assign Dates', 'trim|required|xss_clean');

	 $this->form_validation->set_rules('work_description', 'Work Description', 'trim|required|xss_clean'); 

	 if($this->form_validation->run() === FALSE)

     {



	  return true;

	 }

	 else

	  {

	   $assigndate= explode(',',$this->input->post("assigndate"));

	   $userid=(($usertype=="driver")?$this->input->post("drivername"):$this->input->post("helpername"));

	   foreach($assigndate as $key=>$getdate)
       {
	    $gettotal=$this->user_model->countresult(array("user_id"=>$userid,"assign_dates"=>$getdate),'hourly_job_assign');
	    if($gettotal)
        {
         continue;
        }

	   $data=array("user_id"=>$userid,"fr8no"=>$this->input->post("fr8_no"),"expectedtime"=>$this->input->post("timepicker-one"),"start_form"=>$this->input->post("startform"),"company_id"=>$this->input->post("company_for"),"truck_role_id"=>$this->input->post("truckrole"),"per_hour"=>$this->input->post("per_hour"),"assign_dates"=>$getdate,"description"=>$this->input->post("work_description"));
       $this->user_model->data_insert('hourly_job_assign',$data);
       }
	   if($usertype=="driver")	
	   redirect('/admin/displayhourlyjob','refresh');
       else
       redirect('/admin/helperdisplayhourlyjob','refresh');
	  }

	}

	public function editdriverhourlyjob($id=NULL)
    {
	    if($this->checksession()==1)

		{

               $getid= $this->session->userdata('adminid');

		       $data=array('id'=>$getid);

		       $userdata["admininfo"]=$this->user_model->get_info('admin',$data);

               $userdata["name"]=$userdata["admininfo"][0]->name;

		       $userdata["activeurl"]="displayhourlyjob";

		       $this->load->view('admin/header',$userdata);

			   $data["hourlyjobassignid"]=$id;

			   if($_POST)
               {
               $data["hourlyjobassignid"]=$this->input->post("hourlyjobassignid");
               $this->editdriverhourlyjoblog('driver');
               }

			   $data["hourlyjob"]=$this->user_model->preventdata("select `id`,`user_id`,`fr8no`,`expectedtime`,`start_form`,`company_id`,`truck_role_id`,`per_hour`,DATE_FORMAT(`assign_dates`,'%Y-%m-%d') as `assign_dates`,`description` from `hourly_job_assign` where `id`=?",array($id));

               

			   $totaldriver=$this->user_model->countresult("user.occupation='driver'","user");

		       if($totaldriver==0)

		       {

		        $this->session->set_flashdata('message', '<div class="alert alert-info">No Driver exist. First add driver here.</div>');

		        redirect('/admin/adduser','refresh');

		       }

			   else

			   {

			   $data["drivers"]=$this->user_model->getdatawithcondition("`user_id`,`name`","`user`",array("`occupation`"=>"driver"));    }

			   $totalcomapny=$this->user_model->countresult(NULL,"company");

			   if($totalcomapny==0)

		       {

			   $this->session->set_flashdata('message', '<div class="alert alert-info">No Company exist. First add Company here.</div>');  redirect('/admin/addcompany','refresh');

			   }else

			   {

			   $data["company"]=$this->user_model->use_query("select `id`,`name` from `company`");

			   }

			   $gettotal=$this->user_model->countresult(NULL,"truck_info");

			   if($gettotal==0)

			   {

			  $this->session->set_flashdata('message', '<div class="alert alert-info">No Truck Info exist. First add Truck Info here.</div>'); 

			  redirect('/admin/addtruck','refresh');

			   }else

			   {

			   $data["fr8_no"]=$this->user_model->use_query("select `id`,`fr8_no` from `truck_info`");

			   }

			   $gettotal=$this->user_model->countresult(NULL,"truckrole");

			   if($gettotal==0)

			   {

			   $this->session->set_flashdata('message', '<div class="alert alert-info">No Truck Role exist. First add Truck Role here.</div>'); 

			  redirect('/admin/truckrole','refresh');

			   

			   }else

			   {

			   $data["role_names"]=$this->user_model->use_query("select `id`,`role_name` from `truckrole`");

			   }

			   $this->load->view('admin/edithourlyjob',$data);

			   

			   $this->load->view('admin/footer');

			   

         }else

		 {

		 

		      redirect('/admin','refresh');		

		 }
	}
	public function edithelperhourlyjob($id=NULL)
    {
	    if($this->checksession()==1)

		{

               $getid= $this->session->userdata('adminid');

		       $data=array('id'=>$getid);

		       $userdata["admininfo"]=$this->user_model->get_info('admin',$data);

               $userdata["name"]=$userdata["admininfo"][0]->name;

		       $userdata["activeurl"]="helperdisplayhourlyjob";

		       $this->load->view('admin/header',$userdata);

			   $data["hourlyjobassignid"]=$id;

			   if($_POST)
               {
               $data["hourlyjobassignid"]=$this->input->post("hourlyjobassignid");
               $this->editdriverhourlyjoblog('helper');
               }
$data["hourlyjob"]=$this->user_model->preventdata("select `id`,`user_id`,`fr8no`,`expectedtime`,`start_form`,`company_id`,`truck_role_id`,`per_hour`,DATE_FORMAT(`assign_dates`,'%Y-%m-%d') as `assign_dates`,`description` from `hourly_job_assign` where `id`=?",array($id));

               

			   $totaldriver=$this->user_model->countresult("user.occupation='helper'","user");

		       if($totaldriver==0)

		       {

		        $this->session->set_flashdata('message', '<div class="alert alert-info">No Driver exist. First add driver here.</div>');

		        redirect('/admin/adduser','refresh');

		       }

			   else

			   {

			   $data["drivers"]=$this->user_model->getdatawithcondition("`user_id`,`name`","`user`",array("`occupation`"=>"helper"));    }

			   $totalcomapny=$this->user_model->countresult(NULL,"company");

			   if($totalcomapny==0)

		       {

			   $this->session->set_flashdata('message', '<div class="alert alert-info">No Company exist. First add Company here.</div>');  redirect('/admin/addcompany','refresh');

			   }else

			   {

			   $data["company"]=$this->user_model->use_query("select `id`,`name` from `company`");

			   }

			   $gettotal=$this->user_model->countresult(NULL,"truck_info");

			   if($gettotal==0)

			   {

			  $this->session->set_flashdata('message', '<div class="alert alert-info">No Truck Info exist. First add Truck Info here.</div>'); 

			  redirect('/admin/addtruck','refresh');

			   }else

			   {

			   $data["fr8_no"]=$this->user_model->use_query("select `id`,`fr8_no` from `truck_info`");

			   }

			   $gettotal=$this->user_model->countresult(NULL,"truckrole");

			   if($gettotal==0)

			   {

			   $this->session->set_flashdata('message', '<div class="alert alert-info">No Truck Role exist. First add Truck Role here.</div>'); 

			  redirect('/admin/truckrole','refresh');

			   

			   }else

			   {

			   $data["role_names"]=$this->user_model->use_query("select `id`,`role_name` from `truckrole`");

			   }

			   $this->load->view('admin/edithelperhourlyjob',$data);

			   

			   $this->load->view('admin/footer');

			   

         }else

		 {

		 

		      redirect('/admin','refresh');		

		 }
	}


	public function helperdisplayhourlyjob()
    {

        

		  if($this->checksession()==1)

		     {

               $getid= $this->session->userdata('adminid');

		       $data=array('id'=>$getid);

		       $userdata["admininfo"]=$this->user_model->get_info('admin',$data);

               $userdata["name"]=$userdata["admininfo"][0]->name;

		       $userdata["activeurl"]="helperdisplayhourlyjob";

		       $this->load->view('admin/header',$userdata);

			   

			 if($_POST)

			 {

			

$choosedate=(isset($_POST["prevhidden"])?$this->input->post("prevhidden"):(isset($_POST["nexthidden"])?$this->input->post("nexthidden"):''));



			 }

			if(empty($choosedate))

			{

			$data["startenddate"]=$this->user_model->use_query("select DATE_FORMAT( CURDATE( ) - INTERVAL DAYOFWEEK( CURDATE( ) ) -2

DAY ,  '%Y-%m-%d' ) as start_date,DATE_FORMAT( (

CURDATE( ) - INTERVAL DAYOFWEEK( CURDATE( ) ) -2

DAY ) + INTERVAL 6 

DAY ,  '%Y-%m-%d'

) as end_date");



 $query="select `hourly_job_assign`.`id`,  `user`.`name` as `username`,`hourly_job_assign`.`fr8no`,`hourly_job_assign`.`expectedtime`,`hourly_job_assign`.`start_form`,

 `company`.`name` as `companyname`,`truckrole`.`role_name`,`hourly_job_assign`.`per_hour`,DATE_FORMAT(`hourly_job_assign`.`assign_dates`,'%Y-%m-%d') as `assign_dates`,`hourly_job_assign`.`description` from `hourly_job_assign` inner join `truckrole` on `hourly_job_assign`.`truck_role_id`=`truckrole`.`id` inner join `company` on `company`.`id`=`hourly_job_assign`.company_id inner join `user` on `user`.`user_id`=`hourly_job_assign`.`user_id` where `hourly_job_assign`.`assign_dates` between DATE_FORMAT(CURDATE( ) - INTERVAL DAYOFWEEK( CURDATE( ) ) -2

DAY ,  '%Y-%m-%d' ) AND DATE_FORMAT( (

CURDATE( ) - INTERVAL DAYOFWEEK( CURDATE( ) ) -2

DAY ) + INTERVAL 6 

DAY ,  '%Y-%m-%d'

) and `user`.`occupation`='helper'";

$data["hourlyjob"]= $this->user_model->use_query($query);

			}

			else

			{

			

			$choosetype=(isset($_POST["prevhidden"])?'prev':(isset($_POST["nexthidden"])?'next':''));

			

				if($choosetype=="next")

				{

				$data["startenddate"]=$this->user_model->use_query("select DATE_FORMAT('".$choosedate."' - INTERVAL DAYOFWEEK('".$choosedate."') -2

	DAY ,  '%Y-%m-%d' ) as start_date,DATE_FORMAT( (

	'".$choosedate."' - INTERVAL DAYOFWEEK( '".$choosedate."' ) -2

	DAY ) + INTERVAL 6 

	DAY ,  '%Y-%m-%d'

	) as end_date");

	

	 $query="select `hourly_job_assign`.`id`,  `user`.`name` as `username`,`hourly_job_assign`.`fr8no`,`hourly_job_assign`.`expectedtime`,`hourly_job_assign`.`start_form`,

 `company`.`name` as `companyname`,`truckrole`.`role_name`,`hourly_job_assign`.`per_hour`,DATE_FORMAT(`hourly_job_assign`.`assign_dates`,'%Y-%m-%d') as `assign_dates`,`hourly_job_assign`.`description` from `hourly_job_assign` inner join `truckrole` on `hourly_job_assign`.`truck_role_id`=`truckrole`.`id` inner join `company` on `company`.`id`=`hourly_job_assign`.company_id inner join `user` on `user`.`user_id`=`hourly_job_assign`.`user_id` where `hourly_job_assign`.`assign_dates` between DATE_FORMAT('".$choosedate."' - INTERVAL DAYOFWEEK('".$choosedate."') -2 DAY ,  '%Y-%m-%d' ) AND DATE_FORMAT( ('".$choosedate."' - INTERVAL DAYOFWEEK( '".$choosedate."' ) -2 DAY ) + INTERVAL 6 DAY ,  '%Y-%m-%d') and `user`.`occupation`='helper'";

	$data["hourlyjob"]= $this->user_model->use_query($query);

				}else

				{

				$data["startenddate"]=$this->user_model->use_query("select DATE_FORMAT('".$choosedate."' - INTERVAL 6

	DAY ,  '%Y-%m-%d' ) as start_date,DATE_FORMAT(('".$choosedate."' - INTERVAL 0 DAY ),  '%Y-%m-%d') as end_date");

	

	 $query="select `hourly_job_assign`.`id`, `user`.`name` as `username`,`hourly_job_assign`.`fr8no`,`hourly_job_assign`.`expectedtime`,`hourly_job_assign`.`start_form`,

 `company`.`name` as `companyname`,`truckrole`.`role_name`,`hourly_job_assign`.`per_hour`,DATE_FORMAT(`hourly_job_assign`.`assign_dates`,'%Y-%m-%d') as `assign_dates`,`hourly_job_assign`.`description` from `hourly_job_assign` inner join `truckrole` on `hourly_job_assign`.`truck_role_id`=`truckrole`.`id` inner join `company` on `company`.`id`=`hourly_job_assign`.`company_id` inner join `user` on `user`.`user_id`=`hourly_job_assign`.`user_id` where `hourly_job_assign`.`assign_dates` between DATE_FORMAT('".$choosedate."' - INTERVAL 6

	DAY ,  '%Y-%m-%d' ) AND DATE_FORMAT(('".$choosedate."' - INTERVAL 0 DAY ),  '%Y-%m-%d') and `user`.`occupation`='helper'";

	$data["hourlyjob"]= $this->user_model->use_query($query);

				

				}

			}  

  $start_date=	trim($data['startenddate'][0]->start_date);

  $end_date=trim($data['startenddate'][0]->end_date);

		

		$data["nextprevdate"]=$this->user_model->use_query("SELECT STR_TO_DATE('".$start_date."' ,'%Y-%m-%d' ) - INTERVAL 1 

DAY as prevdate,STR_TO_DATE('".$end_date."' ,'%Y-%m-%d' ) + INTERVAL 1 

DAY as nextdate");


		$this->load->view('admin/helperdisplayhourlyjob',$data);

		$this->load->view('admin/footer');

			 }
            else
             {
			     redirect('/admin','refresh');		

			 }
	}

public function displayhourlyjob()
    {

        

		  if($this->checksession()==1)

		     {

               $getid= $this->session->userdata('adminid');

		       $data=array('id'=>$getid);

		       $userdata["admininfo"]=$this->user_model->get_info('admin',$data);

               $userdata["name"]=$userdata["admininfo"][0]->name;

		       $userdata["activeurl"]="displayhourlyjob";

		       $this->load->view('admin/header',$userdata);

			   

			 if($_POST)
              {
$choosedate=(isset($_POST["prevhidden"])?$this->input->post("prevhidden"):(isset($_POST["nexthidden"])?$this->input->post("nexthidden"):''));
			 }
           if(empty($choosedate))
           {

            //$result=$this->user_model->use_query("select DAYOFWEEK( CURDATE( )) as daynum");
		    $day_of_week = date('N', strtotime(date('d-m-Y')));
		
			
			//if($result[0]->daynum==1)
			if($day_of_week==7)
			{
			
			   $data["startenddate"]=$this->user_model->use_query("select DATE_FORMAT( CURDATE( ) - INTERVAL 7 -1

DAY ,  '%Y-%m-%d' ) as start_date,DATE_FORMAT( (

CURDATE( ) - INTERVAL 7 -1

DAY ) + INTERVAL 6 

DAY ,  '%Y-%m-%d'

) as end_date");



 $query="select `hourly_job_assign`.`id`,  `user`.`name` as `username`,`hourly_job_assign`.`fr8no`,`hourly_job_assign`.`expectedtime`,`hourly_job_assign`.`start_form`,

 `company`.`name` as `companyname`,`truckrole`.`role_name`,`hourly_job_assign`.`per_hour`,DATE_FORMAT(`hourly_job_assign`.`assign_dates`,'%Y-%m-%d') as `assign_dates`,`hourly_job_assign`.`description` from `hourly_job_assign` inner join `truckrole` on `hourly_job_assign`.`truck_role_id`=`truckrole`.`id` inner join `company` on `company`.`id`=`hourly_job_assign`.company_id inner join `user` on `user`.`user_id`=`hourly_job_assign`.`user_id` where `hourly_job_assign`.`assign_dates` between DATE_FORMAT(CURDATE( ) - INTERVAL 7 -1

DAY ,  '%Y-%m-%d' ) AND DATE_FORMAT( (

CURDATE( ) - INTERVAL 7 -1

DAY ) + INTERVAL 6 

DAY ,  '%Y-%m-%d'

) and `user`.`occupation`='driver'";
			
			
			}
			else
			{
			$data["startenddate"]=$this->user_model->use_query("select DATE_FORMAT( CURDATE( ) - INTERVAL DAYOFWEEK( CURDATE( ) ) -2

DAY ,  '%Y-%m-%d' ) as start_date,DATE_FORMAT( (

CURDATE( ) - INTERVAL DAYOFWEEK( CURDATE( ) ) -2

DAY ) + INTERVAL 6 

DAY ,  '%Y-%m-%d'

) as end_date");



 $query="select `hourly_job_assign`.`id`,  `user`.`name` as `username`,`hourly_job_assign`.`fr8no`,`hourly_job_assign`.`expectedtime`,`hourly_job_assign`.`start_form`,

 `company`.`name` as `companyname`,`truckrole`.`role_name`,`hourly_job_assign`.`per_hour`,DATE_FORMAT(`hourly_job_assign`.`assign_dates`,'%Y-%m-%d') as `assign_dates`,`hourly_job_assign`.`description` from `hourly_job_assign` inner join `truckrole` on `hourly_job_assign`.`truck_role_id`=`truckrole`.`id` inner join `company` on `company`.`id`=`hourly_job_assign`.company_id inner join `user` on `user`.`user_id`=`hourly_job_assign`.`user_id` where `hourly_job_assign`.`assign_dates` between DATE_FORMAT(CURDATE( ) - INTERVAL DAYOFWEEK( CURDATE( ) ) -2

DAY ,  '%Y-%m-%d' ) AND DATE_FORMAT( (

CURDATE( ) - INTERVAL DAYOFWEEK( CURDATE( ) ) -2

DAY ) + INTERVAL 6 

DAY ,  '%Y-%m-%d'

) and `user`.`occupation`='driver'";
			} 

$data["hourlyjob"]= $this->user_model->use_query($query);

			}

			else

			{

			

			$choosetype=(isset($_POST["prevhidden"])?'prev':(isset($_POST["nexthidden"])?'next':''));

			

				if($choosetype=="next")

				{

				$data["startenddate"]=$this->user_model->use_query("select DATE_FORMAT('".$choosedate."' - INTERVAL DAYOFWEEK('".$choosedate."') -2

	DAY ,  '%Y-%m-%d' ) as start_date,DATE_FORMAT( (

	'".$choosedate."' - INTERVAL DAYOFWEEK( '".$choosedate."' ) -2

	DAY ) + INTERVAL 6 

	DAY ,  '%Y-%m-%d'

	) as end_date");

	

	 $query="select `hourly_job_assign`.`id`,  `user`.`name` as `username`,`hourly_job_assign`.`fr8no`,`hourly_job_assign`.`expectedtime`,`hourly_job_assign`.`start_form`,

 `company`.`name` as `companyname`,`truckrole`.`role_name`,`hourly_job_assign`.`per_hour`,DATE_FORMAT(`hourly_job_assign`.`assign_dates`,'%Y-%m-%d') as `assign_dates`,`hourly_job_assign`.`description` from `hourly_job_assign` inner join `truckrole` on `hourly_job_assign`.`truck_role_id`=`truckrole`.`id` inner join `company` on `company`.`id`=`hourly_job_assign`.company_id inner join `user` on `user`.`user_id`=`hourly_job_assign`.`user_id` where `hourly_job_assign`.`assign_dates` between DATE_FORMAT('".$choosedate."' - INTERVAL DAYOFWEEK('".$choosedate."') -2 DAY ,  '%Y-%m-%d' ) AND DATE_FORMAT( ('".$choosedate."' - INTERVAL DAYOFWEEK( '".$choosedate."' ) -2 DAY ) + INTERVAL 6 DAY ,  '%Y-%m-%d') and `user`.`occupation`='driver'";

	$data["hourlyjob"]= $this->user_model->use_query($query);

				}else

				{

				$data["startenddate"]=$this->user_model->use_query("select DATE_FORMAT('".$choosedate."' - INTERVAL 6

	DAY ,  '%Y-%m-%d' ) as start_date,DATE_FORMAT(('".$choosedate."' - INTERVAL 0 DAY ),  '%Y-%m-%d') as end_date");

	$query="select `hourly_job_assign`.`id`, `user`.`name` as `username`,`hourly_job_assign`.`fr8no`,`hourly_job_assign`.`expectedtime`,`hourly_job_assign`.`start_form`,

 `company`.`name` as `companyname`,`truckrole`.`role_name`,`hourly_job_assign`.`per_hour`,DATE_FORMAT(`hourly_job_assign`.`assign_dates`,'%Y-%m-%d') as `assign_dates`,`hourly_job_assign`.`description` from `hourly_job_assign` inner join `truckrole` on `hourly_job_assign`.`truck_role_id`=`truckrole`.`id` inner join `company` on `company`.`id`=`hourly_job_assign`.`company_id` inner join `user` on `user`.`user_id`=`hourly_job_assign`.`user_id` where `hourly_job_assign`.`assign_dates` between DATE_FORMAT('".$choosedate."' - INTERVAL 6

	DAY ,  '%Y-%m-%d' ) AND DATE_FORMAT(('".$choosedate."' - INTERVAL 0 DAY ),  '%Y-%m-%d') and `user`.`occupation`='driver'";

	$data["hourlyjob"]= $this->user_model->use_query($query);

				

				}

			}  

  $start_date=	trim($data['startenddate'][0]->start_date);

  $end_date=trim($data['startenddate'][0]->end_date);

		

		$data["nextprevdate"]=$this->user_model->use_query("SELECT STR_TO_DATE('".$start_date."' ,'%Y-%m-%d' ) - INTERVAL 1 

DAY as prevdate,STR_TO_DATE('".$end_date."' ,'%Y-%m-%d' ) + INTERVAL 1 

DAY as nextdate");


		$this->load->view('admin/displayhourlyjobassign',$data);

		$this->load->view('admin/footer');

			 }
            else
             {
			     redirect('/admin','refresh');		

			 }

			

	

	}
	

}







?>