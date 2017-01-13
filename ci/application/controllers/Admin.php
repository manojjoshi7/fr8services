<?php

defined('BASEPATH') OR exit('No direct script access allowed');

include("Parentclass.php");

class Admin extends Parentclass 

{



    public function __construct() 

	{

	  parent::__construct();

      $this->load->model('user_model');
      
	}

    public function feed_no()

	{

	

	       $truck_info_id=$this->input->post("truck_info_id");

		   $feed_no=$this->input->post("feed_no");

	       

$result=$this->user_model->countresult(array("id!="=>$truck_info_id,"lower(feed_no)"=>strtolower($feed_no)),"truck_info");

		  if($result==0)

		  {

		    return true;

		  }

		  else

		  {

		    $this->form_validation->set_message('feed_no', 'This %s  allready exist');

		    return FALSE;

		  }

	}

	public function fr8_no()

	{

	      

		   $truck_info_id=$this->input->post("truck_info_id");

		   $frno=$this->input->post("fr8_no");

	       

$result=$this->user_model->countresult(array("id!="=>$truck_info_id,"lower(fr8_no)"=>strtolower($frno)),"truck_info");

		  if($result==0)

		  {

		    return true;

		  }

		  else

		  {

		    $this->form_validation->set_message('fr8_no', 'This %s allready exist');

		    return FALSE;

		  }

	

	

	}

	private function edittrucklog()

	{

	

	  $this->form_validation->set_rules('feed_no', 'Feed No', 'trim|required|min_length[3]|max_length[50]|callback_feed_no|xss_clean');

	 $this->form_validation->set_rules('gvm', 'GVM', 'trim|required|xss_clean');

	 $this->form_validation->set_rules('truck_tweight', 'Truck Tweight', 'trim|required|max_length[50]|xss_clean');

	 $this->form_validation->set_rules('truck_pallets', 'Truck Pallets', 'trim|required|xss_clean');

     $this->form_validation->set_rules('rego_expire', 'Rego Expire', 'trim|required|alpha_dash|max_length[50]|xss_clean');	     $this->form_validation->set_rules('fr8_no', 'FR8 No.', 'trim|required|callback_fr8_no|alpha_dash|max_length[50]|xss_clean');

	 $this->form_validation->set_rules('truck_license', 'License', 'trim|required|max_length[50]|xss_clean'); 

	 if($this->form_validation->run() === FALSE)

     {



	  return true;

	 }

	 else

	  {

	   $data=array("feed_no"=>$this->input->post("feed_no"),"gvm"=>$this->input->post("gvm"),"tweight"=>$this->input->post("truck_tweight"),"pallets"=>$this->input->post("truck_pallets"),"rego_expire"=>$this->input->post("rego_expire"),"fr8_no"=>$this->input->post("fr8_no"),"license"=>$this->input->post("truck_license"));

			

		$this->user_model->update_info('truck_info','id',$this->input->post("truck_info_id"),$data);



	   redirect('/admin/displaytruck','refresh');

	  }

	

	}

    public function truckedit($id=NULL)

	{

	   if($this->checksession()==1)

		{

	     $getid= $this->session->userdata('adminid');

		 $data=array('id'=>$getid);

		 $userdata["admininfo"]=$this->user_model->get_info('admin',$data);

         $userdata["name"]=$userdata["admininfo"][0]->name;

		 $userdata["activeurl"]="displaytruck";

		 $this->load->view('admin/header',$userdata);

		if($_POST)

		{

		 $this->edittrucklog();

		 $data["truck_info_id"]=$this->input->post('truck_info_id');

		}

		else

		{

		

$data["truckinfo"]=$this->user_model->preventdata("select `id`,`feed_no`,`gvm`,`tweight`,`pallets`,`rego_expire`,`fr8_no`,`license` from `truck_info` where `id`=?",array($id));

		 if(count($data["truckinfo"])==0)

		 {

		   redirect('/admin/displaytruck','refresh');		

		 }

		 $data["truck_info_id"]=$id;

		}

		$this->load->view('admin/truck_info_edit',$data);

		

		$this->load->view('admin/footer');

		}

		else

		{

        		redirect('/admin','refresh');		

		}

	}

	public function displaytruck()

	{

	     

		 if($this->checksession()==1)

		 {

		   $getpaginationlink=$this->pagination("admin/displaytruck","truck_info",50);

		   $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

		   $getid= $this->session->userdata('adminid');

		   $data=array('id'=>$getid);

		   $userdata["admininfo"]=$this->user_model->get_info('admin',$data);



		   $userdata["name"]=$userdata["admininfo"][0]->name;

		   $userdata["activeurl"]="displaytruck";

	       $this->load->view('admin/header',$userdata);

			

		$data["truckinfo"]=$this->user_model->getalldatawithorder('id,feed_no,gvm,tweight,pallets,rego_expire,fr8_no,license,
		
		(datediff(rego_expire,CURDATE())-1) as day','truck_info','day','asc',50,$page);

		$data["links"] = $getpaginationlink;

		$this->load->view('admin/displaytruckinfo',$data);

		$this->load->view('admin/footer');

		  }

		  else

		  {

		  

		  redirect('/admin','refresh');		

		  

		  }

		  

	

	

	}

	public function addtruck()

	{

	    if($this->checksession()==1)

		{

		  $getid= $this->session->userdata('adminid');

		  $data=array('id'=>$getid);

		  $userdata["admininfo"]=$this->user_model->get_info('admin',$data);



		  $userdata["name"]=$userdata["admininfo"][0]->name;

		  $activeurl="addtruck";

		  $userdata["activeurl"]=$activeurl;

	      $this->load->view('admin/header',$userdata);

		  if($_POST)

		  {

		  $this->trucklog();

		  }

		  

          $this->load->view('admin/addtruck');

		  $this->load->view('admin/footer');

		

		}else

		{

		   redirect('/admin','refresh');		

		}

	

	}

	private function trucklog()

	{



	 $this->form_validation->set_rules('feed_no', 'Feed No', 'trim|required|min_length[3]|max_length[50]|is_unique[truck_info.feed_no]|xss_clean');

	 $this->form_validation->set_rules('gvm', 'GVM', 'trim|required|xss_clean');

	 $this->form_validation->set_rules('truck_tweight', 'Truck Tweight', 'trim|required|max_length[50]|xss_clean');

	 $this->form_validation->set_rules('truck_pallets', 'Truck Pallets', 'trim|required|xss_clean');

     $this->form_validation->set_rules('rego_expire', 'Rego Expire', 'trim|required|alpha_dash|max_length[50]|xss_clean');	     $this->form_validation->set_rules('fr8_no', 'FR8 No.', 'trim|required|is_unique[truck_info.fr8_no]|alpha_dash|max_length[50]|xss_clean');

	 $this->form_validation->set_rules('truck_license', 'License', 'trim|required|max_length[50]|xss_clean'); 

	 if($this->form_validation->run() === FALSE)

     {



	  return true;

	 }

	 else

	  {



	  $data=array("feed_no"=>$this->input->post("feed_no"),"gvm"=>$this->input->post("gvm"),"tweight"=>$this->input->post("truck_tweight"),"pallets"=>$this->input->post("truck_pallets"),"rego_expire"=>$this->input->post("rego_expire"),"fr8_no"=>$this->input->post("fr8_no"),"license"=>$this->input->post("truck_license"));



	  $this->user_model->data_insert('truck_info',$data);

	  redirect('/admin/displaytruck','refresh');

	  }

	  

	}

	public function feedback($assignid,$type)

	{

	    if($this->checksession()==1)

		{

		  $getid= $this->session->userdata('adminid');

		  $data=array('id'=>$getid);

		  $userdata["admininfo"]=$this->user_model->get_info('admin',$data);



		  $userdata["name"]=$userdata["admininfo"][0]->name;

		  $activeurl=($type=='fixed'?'workingtask':'hourlyworkingtask');

		  $userdata["activeurl"]=$activeurl;

	      

		  $this->load->view('admin/header',$userdata);

$query="select `user`.`name`,`feedback`.`assign_id`,`feedback`.`truck_plate_number`,`feedback`.`engine_oil`,`feedback`.`lights`,`feedback`.`tyres`,`feedback`.`vehicle_body`,`feedback`.`other`,`feedback`.`type`  from `feedback` inner join `user` on `user`.`user_id`=`feedback`.`user_id` where `feedback`.`assign_id`=? and `feedback`.`type`=?";

		  $result=$this->user_model->preventdata($query,array($assignid, $type));



		  $data['feedback']=$result;

		  $this->load->view('admin/feedback',$data);

		  $this->load->view('admin/footer');

		}

		else

		{

		

		      redirect('/admin','refresh');		

		}

	

	}

	public function addhourlyprice()

	{

	

	    if($this->checksession()==1)

		{

		      

		$getid= $this->session->userdata('adminid');

		$data=array('id'=>$getid);

		$userdata["admininfo"]=$this->user_model->get_info('admin',$data);



		$userdata["name"]=$userdata["admininfo"][0]->name;

		$userdata["activeurl"]="addamount";

	    $this->load->view('admin/header',$userdata);

		if($_POST)

		{

		$this->addhourlyamountlog();

		}	  

		$this->load->view('admin/addamount');	  

		$this->load->view('admin/footer');

		}

		else

		{

		      redirect('/admin','refresh');		

		

		}

	

	

	}

	public function displayhourlyamount()

	{

	    if($this->checksession()==1)

		{

		

		$getid= $this->session->userdata('adminid');

		$data=array('id'=>$getid);

		$userdata["admininfo"]=$this->user_model->get_info('admin',$data);



		$userdata["name"]=$userdata["admininfo"][0]->name;

		$userdata["activeurl"]="displayamount";

	    $this->load->view('admin/header',$userdata);

		

        $data["hourlyamount"]=$this->user_model->use_query("select id,user_type,prices from hourly_prices");

		

		$this->load->view('admin/displayhourlyamount',$data);

		$this->load->view('admin/footer');

		}

		else

		{

        redirect('/admin','refresh');		

		}

       	

	}

	public function unique_price()

	{

	

	       $user_type=$this->input->post("useroccupations");

	       $result=$this->user_model->countresult(array("user_type"=>$user_type),"`hourly_prices`");



		  if($result==0)

		  {

		    return true;

		  }

		  else

		  {

		    $this->form_validation->set_message('unique_price', 'The %s hourly amount allready exist');

		    return FALSE;

		  }

	}

	private function addhourlyamountlog()

	{

	  $this->form_validation->set_rules('useroccupations', 'User Type', 'required|callback_unique_price|xss_clean');

	  $this->form_validation->set_rules('hourly_amount', 'Hourly Amount', 'required|decimal|max_length[10]|xss_clean');

	  if($this->form_validation->run() === FALSE)

      {

	  return validation_errors();

	  }

	  else

	  {

	  $data=array("user_type"=>$this->input->post("useroccupations"),"prices"=>$this->input->post("hourly_amount"));

	  $this->user_model->data_insert('`hourly_prices`',$data);

      redirect('/admin/displayhourlyamount','refresh');

	  }

	

	}

	public function truckinfo()

	{

	

	    if($this->checksession()==1)

		{

		

		$getpaginationlink=$this->pagination("admin/truckinfo","truck_fault",50,"select count(*) as total from truck_fault inner join user on truck_fault.user_id=user.user_id","join");

		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

		$getid= $this->session->userdata('adminid');

		$data=array('id'=>$getid);

		$userdata["admininfo"]=$this->user_model->get_info('admin',$data);



		$userdata["name"]=$userdata["admininfo"][0]->name;

		$userdata["activeurl"]="displaytruckinfo";

	    $this->load->view('admin/header',$userdata);

	$userdata["truckinfo"]=$this->user_model->leftright_join_without_condition("`truck_fault`.`id`,`user`.`name`,`truck_fault`.`store_number` as `store_number`,`truck_fault`.`run_name`,`truck_fault`.`problem`,`truck_fault`.`image_name`,`truck_fault`.`updatetime`","`truck_fault`","`user`","`truck_fault`.`user_id`=`user`.`user_id`","inner",50, $page);

	

		$userdata["links"]=$getpaginationlink;

		$this->load->view('admin/truckfalut',$userdata);

		$this->load->view('admin/footer');

		}else

		{

		redirect('/admin','refresh');		

		}

	

	

	

	}

	public function adminlogout()

	{

	$this->session->sess_destroy();

	redirect('/admin','refresh');

	}

	public function company_name()

	{

	  $comapnyname=$this->input->post("companyname");

	  $comapnyid=$this->input->post("companyid");

      $result=$this->user_model->countresult(array("id!="=>$comapnyid,"lower(name)"=>strtolower($comapnyname)),"company");

	

	  if($result==0)

	  {

	  return true;

	  }

	  else

	  {

	 

	   $this->form_validation->set_message('company_name', 'The %s name allready exist');

       return FALSE;

	  }

	}

	public function company_email()

	{

	  

	   $companyemail=$this->input->post("companyemail");

	   $companyid=$this->input->post("companyid");

       $result=$this->user_model->countresult(array("id!="=>$companyid,"lower(email)"=>strtolower($companyemail)),"company");

	

	  if($result==0)

	  {

	  return true;

	  }

	  else

	  {

	 

	   $this->form_validation->set_message('company_name', 'The %s email allready exist');

       return FALSE;

	  }

	  

	}

    public function company_phone_number()

	{

	   

	   $companyphone=$this->input->post("companyphone");

	   $companyid=$this->input->post("companyid");

       $result=$this->user_model->countresult(array("id!="=>$companyid,"lower(phone_number)"=>strtolower($companyphone)),"company");

	

	  if($result==0)

	  {

	  return true;

	  }

	  else

	  {

	 

	   $this->form_validation->set_message('company_phone_number', 'The %s phone allready exist');

       return FALSE;

	  }

	   

	}

	private function editcomapnylog()

	{

	   	$this->form_validation->set_rules('companyname', 'Company Name', 'required|callback_company_name|min_length[5]|max_length[100]|xss_clean');

	$this->form_validation->set_rules('companyemail', 'Company Email', 'required|callback_company_email|max_length[400]|valid_email|xss_clean');

	$this->form_validation->set_rules('companyaddress', 'Company Address', 'required|max_length[1000]|xss_clean');

	$this->form_validation->set_rules('companyphone', 'Company Phone', 'required|callback_company_phone_number|min_length[10]|max_length[15]|xss_clean');

	$this->form_validation->set_rules('abnumber', 'AB Number', 'required|max_length[50]|xss_clean');

	$this->form_validation->set_rules('acnumber', 'AC Number', 'required|max_length[50]|xss_clean');

	$this->form_validation->set_rules('companydescription', 'Company Description', 'required|max_length[1000]|xss_clean');

     if($this->form_validation->run() == FALSE)

     return validation_errors();

	 else

	 {

	        $companyid=$this->input->post("companyid");

	        $data=array('name'=>$this->input->post('companyname'),'email'=>$this->input->post('companyemail'),'address'=>$this->input->post('companyaddress'),'phone_number'=>$this->input->post('companyphone'),'ab_number'=>$this->input->post('abnumber'),'ac_number'=>$this->input->post('acnumber'),'description'=>$this->input->post('companydescription'));

			

			$this->user_model->update_info('company','id',$companyid,$data);



			$this->displaycompany();

	 }

	

	}

	private function companylog()

	{

	$this->form_validation->set_rules('companyname', 'Company Name', 'required|is_unique[company.name]|min_length[5]|max_length[100]|xss_clean');

	$this->form_validation->set_rules('companyemail', 'Company Email', 'required|is_unique[company.email]|max_length[400]|valid_email|xss_clean');

	$this->form_validation->set_rules('companyaddress', 'Company Address', 'required|max_length[1000]|xss_clean');

	$this->form_validation->set_rules('companyphone', 'Company Phone', 'required|is_unique[company.phone_number]|min_length[10]|max_length[15]|xss_clean');

	$this->form_validation->set_rules('abnumber', 'AB Number', 'required|max_length[50]|xss_clean');

	$this->form_validation->set_rules('acnumber', 'AC Number', 'required|max_length[50]|xss_clean');

	$this->form_validation->set_rules('companydescription', 'Company Description', 'required|max_length[1000]|xss_clean');

     if($this->form_validation->run() == FALSE)

     return validation_errors();

	 else

	 {

	        $data=array('name'=>$this->input->post('companyname'),'email'=>$this->input->post('companyemail'),'address'=>$this->input->post('companyaddress'),'phone_number'=>$this->input->post('companyphone'),'ab_number'=>$this->input->post('abnumber'),'ac_number'=>$this->input->post('acnumber'),'description'=>$this->input->post('companydescription'));

			$this->user_model->data_insert('company',$data);

			$this->displaycompany();

	 }

	 	

	}

    private function adminlog()

	{



	      $this->form_validation->set_rules('lemail', 'Email', 'required|valid_email|xss_clean');

		  $this->form_validation->set_rules('lpassword', 'Password', 'required|sha1|xss_clean');

          if($this->form_validation->run() == FALSE)

          return validation_errors();

		  else

		  {

			$data=array('email'=>$this->input->post('lemail'),'password'=>$this->input->post('lpassword'));

			$count=$this->user_model->has_record('admin',$data);

            if($count==0)

			return "Enter valid email address and password";

			else

			$this->session->set_userdata('adminid', $count);

		  }

    }

	public function roles_name()

	{

	   $rolename=$this->input->post("rolename");

	   $roleid=$this->input->post("roleid");

       $result=$this->user_model->countresult(array("role_id!="=>$roleid,"lower(name)"=>strtolower($rolename)),"roles");

	  if($result==0)

	  {

	  return true;

	  }

	  else

	  {

	   $this->form_validation->set_message('roles_name', 'The %s name allready exist');

       return FALSE;

	  }

		

	}

	private function editrolelog()

	{

	      	  $this->form_validation->set_rules('rolename', 'Roll Name', 'required|callback_roles_name|min_length[3]|max_length[100]|xss_clean');

			  $this->form_validation->set_rules('role_amount', 'Roll Amount', 'required|decimal|max_length[10]|xss_clean');

	 if($this->form_validation->run() === FALSE)

      {

	   return validation_errors();

	  }

	  else

	  {

	  $data=array("name"=>$this->input->post("rolename"),"company_id"=>$this->input->post("company"),"shift_time"=>$this->input->post("shifttime"),"occupation"=>$this->input->post("useroccupations"),"amount"=>$this->input->post("role_amount"));

	  $roleid=$this->input->post("roleid");

	  $this->user_model->update_info('roles','role_id',$roleid,$data);

      redirect('/admin/displayrole','refresh');

	  }    

	}

	private function rolelog()

	{

	  $this->form_validation->set_rules('rolename', 'Roll Name', 'required|is_unique[roles.name]|min_length[3]|max_length[100]|xss_clean');

	   $this->form_validation->set_rules('role_amount', 'Roll Amount', 'required|decimal|max_length[10]|xss_clean');

	  if($this->form_validation->run() === FALSE)

      {

	  return validation_errors();

	  }

	  else

	  {

	  $data=array("name"=>$this->input->post("rolename"),"company_id"=>$this->input->post("companyname"),"shift_time"=>$this->input->post("shifttime"),"occupation"=>$this->input->post("useroccupations"),"amount"=>$this->input->post("role_amount"));

	  $this->user_model->data_insert('roles',$data);

      redirect('/admin/displayrole','refresh');

	  }

	}

	private function editassignlog($for)

	{

	    $this->form_validation->set_rules('assigndate', 'Assign Date', 'required|xss_clean'); 

	    if($this->form_validation->run() === FALSE)

        {

	    return validation_errors();

	    }

	    else

		{ 

		$hasassign=$this->user_model->countresult(array("role_id"=>$this->input->post("roleinfo"),"assign_date"=>$this->input->post("assigndate"),"user_id="=>$this->input->post("driverorhelpername")),'assign_role_date');



		if(!$hasassign)

		{

$row=$this->user_model->use_query("SELECT `amount` FROM  `roles` where `role_id`=".$this->input->post("roleinfo")."");
		$data=array("user_id"=>$this->input->post("driverorhelpername"),"role_id"=>$this->input->post("roleinfo"),"assign_date"=>$this->input->post("assigndate"),'role_amount'=>$row[0]->amount);

		$this->user_model->update_info('assign_role_date','id',$this->input->post("assigntaskid"),$data);

		}		 

		 if($for=="driver")
         //redirect('/admin/displaydriverassign','refresh');
		 redirect('/admin/weeklyassign','refresh');
         elseif($for=="helper")
         //redirect('/admin/displayhelperassign','refresh');
		 redirect('/admin/weeklyassign','refresh');

	   }

	}

	public function hourlyworkingtask()

	{

	

	    if($this->checksession()==1)
        {

		$getid= $this->session->userdata('adminid');

		$data=array('id'=>$getid);

		$userdata["admininfo"]=$this->user_model->get_info('admin',$data);
        $userdata["name"]=$userdata["admininfo"][0]->name;
		$userdata["activeurl"]="hourlyworkingtask";

	    $this->load->view('admin/header',$userdata);

        if($_POST)
        {
$choosedate=(isset($_POST["prevhidden"])?$this->input->post("prevhidden"):(isset($_POST["nexthidden"])?$this->input->post("nexthidden"):''));
	    }
		if(empty($choosedate))
        {
		$userdata["startenddate"]=$this->user_model->use_query("select DATE_FORMAT( CURDATE( ) - INTERVAL DAYOFWEEK( CURDATE( ) ) -2 DAY ,  '%Y-%m-%d' ) as start_date,DATE_FORMAT( (CURDATE( ) - INTERVAL DAYOFWEEK( CURDATE( ) ) -2 DAY ) + INTERVAL 6 DAY ,  '%Y-%m-%d') as end_date");
        $query=	"select `hourlyjob`.`assign_id`,`user`.`name` as `username`,`hourlyjob`.`start`,`hourlyjob`.`end` as `endtask`,`hourlyjob`.`status` from  `hourlyjob`  inner join `hourly_job_assign` on (`hourlyjob`.`assign_id`=`hourly_job_assign`.`id`) inner join `user` on (`hourly_job_assign`.`user_id`=`user`.`user_id`)  where  DATE_FORMAT(  `hourlyjob`.`start_time` , '%Y-%m-%d' ) between DATE_FORMAT(CURDATE( ) - INTERVAL DAYOFWEEK( CURDATE( ) ) -2 DAY ,  '%Y-%m-%d' ) AND DATE_FORMAT( (CURDATE( ) - INTERVAL DAYOFWEEK( CURDATE( ) ) -2 DAY ) + INTERVAL 6 DAY ,  '%Y-%m-%d')   order by `hourlyjob`.`assigndate` desc,`hourlyjob`.`status`";

		}
		else
        {
	$choosetype=(isset($_POST["prevhidden"])?'prev':(isset($_POST["nexthidden"])?'next':''));
         if($choosetype=="next")
		{
		$userdata["startenddate"]=$this->user_model->use_query("select DATE_FORMAT('".$choosedate."' - INTERVAL DAYOFWEEK('".$choosedate."') -2 DAY ,  '%Y-%m-%d' ) as start_date,DATE_FORMAT( (
'".$choosedate."' - INTERVAL DAYOFWEEK( '".$choosedate."' ) -2 DAY ) + INTERVAL 6 DAY ,  '%Y-%m-%d') as end_date");
	
    $query=	"select `hourlyjob`.`assign_id`,`user`.`name` as `username`,`hourlyjob`.`start`,`hourlyjob`.`end` as `endtask`,`hourlyjob`.`status` from  `hourlyjob`  inner join `hourly_job_assign` on (`hourlyjob`.`assign_id`=`hourly_job_assign`.`id`) inner join `user` on (`hourly_job_assign`.`user_id`=`user`.`user_id`)  where  DATE_FORMAT(  `hourlyjob`.`start_time` , '%Y-%m-%d' ) between DATE_FORMAT('".$choosedate."' - INTERVAL DAYOFWEEK('".$choosedate."') -2 DAY ,  '%Y-%m-%d' ) AND DATE_FORMAT( ('".$choosedate."' - INTERVAL DAYOFWEEK( '".$choosedate."' ) -2 DAY ) + INTERVAL 6 DAY ,  '%Y-%m-%d')  order by `hourlyjob`.`assigndate` desc,`hourlyjob`.`status`";
		}
		else
        {
	 $userdata["startenddate"]=$this->user_model->use_query("select DATE_FORMAT('".$choosedate."' - INTERVAL 6 DAY ,  '%Y-%m-%d' ) as start_date,DATE_FORMAT(('".$choosedate."' - INTERVAL 0 DAY ),  '%Y-%m-%d') as end_date");
	
	$query=	"select `hourlyjob`.`assign_id`,`user`.`name` as `username`,`hourlyjob`.`start`,`hourlyjob`.`end` as `endtask`,`hourlyjob`.`status` from  `hourlyjob`  inner join `hourly_job_assign` on (`hourlyjob`.`assign_id`=`hourly_job_assign`.`id`) inner join `user` on (`hourly_job_assign`.`user_id`=`user`.`user_id`)  where DATE_FORMAT(  `hourlyjob`.`start_time` ,  '%Y-%m-%d' ) between DATE_FORMAT('".$choosedate."' - INTERVAL 6 DAY ,  '%Y-%m-%d' ) AND DATE_FORMAT(('".$choosedate."' - INTERVAL 0 DAY ),  '%Y-%m-%d')  order by `hourlyjob`.`assigndate` desc,`hourlyjob`.`status`";
	
       }
       }

           $userdata["datarows"]=$this->user_model->use_query($query);
           $start_date=	trim($userdata['startenddate'][0]->start_date);

  $end_date=trim($userdata['startenddate'][0]->end_date);

		

		$userdata["nextprevdate"]=$this->user_model->use_query("SELECT STR_TO_DATE('".$start_date."' ,'%Y-%m-%d' ) - INTERVAL 1 

DAY as prevdate,STR_TO_DATE('".$end_date."' ,'%Y-%m-%d' ) + INTERVAL 1 

DAY as nextdate");


		$this->load->view('admin/hourlyworkingtask',$userdata);

		$this->load->view('admin/footer');

		}

		else

		{

		redirect('/admin','refresh');

		}

	

	}

	public function workingtask()
    {
	    if($this->checksession()==1)
         {

		$getid= $this->session->userdata('adminid');

		$data=array('id'=>$getid);

		$userdata["admininfo"]=$this->user_model->get_info('admin',$data);
		$userdata["name"]=$userdata["admininfo"][0]->name;

		

		$userdata["activeurl"]="workingtask";

	    $this->load->view('admin/header',$userdata);

        if($_POST)
        {
$choosedate=(isset($_POST["prevhidden"])?$this->input->post("prevhidden"):(isset($_POST["nexthidden"])?$this->input->post("nexthidden"):''));
	    }
		if(empty($choosedate))
        {
		$userdata["startenddate"]=$this->user_model->use_query("select DATE_FORMAT( CURDATE( ) - INTERVAL DAYOFWEEK( CURDATE( ) ) -2 DAY ,  '%Y-%m-%d' ) as start_date,DATE_FORMAT( (CURDATE( ) - INTERVAL DAYOFWEEK( CURDATE( ) ) -2 DAY ) + INTERVAL 6 DAY ,  '%Y-%m-%d') as end_date");

		$query=	"select `geolocation`.`assign_task_id`,`assign_role_date`.`assign_date`,`user`.`name` as `username`,`geolocation`.`start`,`geolocation`.`end` as `endtask`,`geolocation`.`status`,`roles`.`name` as `rolename` from  `geolocation` inner join `assign_role_date` on (`geolocation`.`assign_task_id`=`assign_role_date`.`id`) inner join `user` on (`assign_role_date`.`user_id`=`user`.`user_id`) inner join `roles` on (`assign_role_date`.`role_id`=`roles`.`role_id`) where  DATE_FORMAT( STR_TO_DATE( `assign_role_date`.`assign_date`,  '%m-%d-%Y'), '%Y-%m-%d' ) between DATE_FORMAT(CURDATE( ) - INTERVAL DAYOFWEEK( CURDATE( ) ) -2 DAY ,  '%Y-%m-%d' ) AND DATE_FORMAT( (CURDATE( ) - INTERVAL DAYOFWEEK( CURDATE( ) ) -2 DAY ) + INTERVAL 6 DAY ,  '%Y-%m-%d')    order by `assign_role_date`.`assign_date` desc,`geolocation`.`status` asc";
		}
		else
        {
	     $choosetype=(isset($_POST["prevhidden"])?'prev':(isset($_POST["nexthidden"])?'next':''));
	     if($choosetype=="next")
		 {
		  $userdata["startenddate"]=$this->user_model->use_query("select DATE_FORMAT('".$choosedate."' - INTERVAL DAYOFWEEK('".$choosedate."') -2 DAY ,  '%Y-%m-%d' ) as start_date,DATE_FORMAT( (
'".$choosedate."' - INTERVAL DAYOFWEEK( '".$choosedate."' ) -2 DAY ) + INTERVAL 6 DAY ,  '%Y-%m-%d') as end_date");
         $query="select `geolocation`.`assign_task_id`,`assign_role_date`.`assign_date`,`user`.`name` as `username`,`geolocation`.`start`,`geolocation`.`end` as `endtask`,`geolocation`.`status`,`roles`.`name` as `rolename` from  `geolocation` inner join `assign_role_date` on (`geolocation`.`assign_task_id`=`assign_role_date`.`id`) inner join `user` on (`assign_role_date`.`user_id`=`user`.`user_id`) inner join `roles` on (`assign_role_date`.`role_id`=`roles`.`role_id`) where  DATE_FORMAT(STR_TO_DATE( `assign_role_date`.`assign_date`,'%m-%d-%Y'), '%Y-%m-%d' ) between DATE_FORMAT('".$choosedate."' - INTERVAL DAYOFWEEK('".$choosedate."') -2 DAY ,  '%Y-%m-%d' ) AND DATE_FORMAT( ('".$choosedate."' - INTERVAL DAYOFWEEK( '".$choosedate."' ) -2 DAY ) + INTERVAL 6 DAY ,  '%Y-%m-%d') order by `assign_role_date`.`assign_date` desc,`geolocation`.`status` asc";
    	}
		else
        {
		$userdata["startenddate"]=$this->user_model->use_query("select DATE_FORMAT('".$choosedate."' - INTERVAL 6 DAY ,  '%Y-%m-%d' ) as start_date,DATE_FORMAT(('".$choosedate."' - INTERVAL 0 DAY ),  '%Y-%m-%d') as end_date");
		$query="select `geolocation`.`assign_task_id`,`assign_role_date`.`assign_date`,`user`.`name` as `username`,`geolocation`.`start`,`geolocation`.`end` as `endtask`,`geolocation`.`status`,`roles`.`name` as `rolename` from  `geolocation` inner join `assign_role_date` on (`geolocation`.`assign_task_id`=`assign_role_date`.`id`) inner join `user` on (`assign_role_date`.`user_id`=`user`.`user_id`) inner join `roles` on (`assign_role_date`.`role_id`=`roles`.`role_id`) where  DATE_FORMAT(STR_TO_DATE( `assign_role_date`.`assign_date`,'%m-%d-%Y'), '%Y-%m-%d' ) between DATE_FORMAT('".$choosedate."' - INTERVAL 6 DAY ,  '%Y-%m-%d' ) AND DATE_FORMAT(('".$choosedate."' - INTERVAL 0 DAY ),  '%Y-%m-%d') order by `assign_role_date`.`assign_date` desc,`geolocation`.`status` asc";
		
		}
		}		
	$userdata["datarows"]=$this->user_model->use_query($query);
    $start_date=trim($userdata['startenddate'][0]->start_date);
    $end_date=trim($userdata['startenddate'][0]->end_date);
$userdata["nextprevdate"]=$this->user_model->use_query("SELECT STR_TO_DATE('".$start_date."' ,'%Y-%m-%d' ) - INTERVAL 1 DAY as prevdate,STR_TO_DATE('".$end_date."' ,'%Y-%m-%d' ) + INTERVAL 1 DAY as nextdate");

        $this->load->view('admin/workingtask',$userdata);

		$this->load->view('admin/footer');

		}

		else

		{

		redirect('/admin','refresh');

		}

	

	

	

	

	

	

	}

	public function testlocation()

	{

	    if($this->checksession()==1)

		{

		$getid= $this->session->userdata('adminid');

		$data=array('id'=>$getid);

		$userdata["admininfo"]=$this->user_model->get_info('admin',$data);

        $userdata["name"]=$userdata["admininfo"][0]->name;

		$userdata["activeurl"]="workingtask";

		

		

		$this->load->library('googlemaps');



		//$config['center'] = '37.4419, -122.1419';

		$config['zoom'] = 'auto';

		$config['trafficOverlay'] = TRUE;

		//$config['cluster'] = TRUE;

		

		$this->googlemaps->initialize($config);

		

		$marker = array();

		$marker['position'] = '37.429, -122.1519';

		$marker['infowindow_content'] = '1 - Hello World!';

		$marker['icon'] = 'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=A|9999FF|000000';

		$this->googlemaps->add_marker($marker);

		

		$marker = array();

		$marker['position'] = '37.409, -122.1319';

		//$marker['draggable'] = TRUE;

		//$marker['animation'] = 'DROP';

		$marker['onclick'] = "dispalypopup();";

		$this->googlemaps->add_marker($marker);

		

		$marker = array();

		$marker['position'] = '37.449, -122.1419';

		$marker['onclick'] = 'alert("You just clicked me!!")';

		$this->googlemaps->add_marker($marker);

		

		$polyline = array();

        $polyline['points'] = array('37.429, -122.1519','37.409, -122.1319','37.449, -122.1419');

        $this->googlemaps->add_polyline($polyline);

		

		$userdata['map'] = $this->googlemaps->create_map();

		

		

		

		

		$this->load->view('admin/header',$userdata);

		$this->load->view('admin/displaylocation',$userdata);

	    $this->load->view('admin/footer');

		}

		else

		{

     	redirect('/admin','refresh');

		}

	

	}

	public function hourlyjoblocation($assignid)

	{

	    if($this->checksession()==1)

		{

		$getid= $this->session->userdata('adminid');

		$data=array('id'=>$getid);

		$userdata["admininfo"]=$this->user_model->get_info('admin',$data);



		$userdata["name"]=$userdata["admininfo"][0]->name;

		

		$userdata["activeurl"]="hourlyworkingtask";

	   $getdata= $this->user_model->getdatawithcondition("`hourlyjob`.`start` as `userstart`,`hourlyjob`.`break` as `userbreak`,`hourlyjob`.`end` as `userend`","`hourlyjob`","`hourlyjob`.`assign_id`=".$assignid."");

		

		$statcode=(array)json_decode($getdata[0]->userstart);

		

		$this->load->library('googlemaps');

		//$config['center'] = ''.$statcode["currentlatitude"].','.$statcode["currentlongitude"].'';

		$config['zoom'] = 'auto';

		$config['trafficOverlay'] = TRUE;

		$this->googlemaps->initialize($config);



		$marker = array();

$marker['position'] =''.$statcode["currentlatitude"].','.$statcode["currentlongitude"].'';

		$linepoints[]=$marker['position'];



//$marker['infowindow_content'] = 'Start Location';

//$marker['icon'] = 'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=A|9999FF|000000';

$marker['onclick'] = "dispalypopup('Start task at ".$statcode['startdatetime']."');";

$this->googlemaps->add_marker($marker);

if(!empty($getdata[0]->userbreak))

{

    $breakcode=explode('#@#',$getdata[0]->userbreak);

    foreach($breakcode as $key=>$breakvalue)

	{

	

	   $breakpont= (array)json_decode($breakvalue);

	   $marker = array();

$marker['position'] =''.$breakpont["currentlatitude"].','.$breakpont["currentlongitude"].'';

$linepoints[]=$marker['position'];

$marker['onclick'] = "dispalypopup('Take Brake at ".$statcode['startdatetime']."');";

$marker['icon'] = 'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=A|9999FF|000000';

$this->googlemaps->add_marker($marker);

	}

}

if(!empty($getdata[0]->userend))

{

    $statcode=(array)json_decode($getdata[0]->userend);



    $marker = array();

    $marker['position'] =''.$statcode["currentlatitude"].','.$statcode["currentlongitude"].'';

	$linepoints[]=$marker['position'];



    $marker['onclick'] = "dispalypopup('End task at ".$statcode['enddatetime']."');";

    $this->googlemaps->add_marker($marker);

}

$polyline=array();

$polyline['points']=$linepoints;

        $this->googlemaps->add_polyline($polyline);

		$userdata['map'] = $this->googlemaps->create_map();



		$this->load->view('admin/header',$userdata);

		

		$this->load->view('admin/displaylocation',$userdata);

	    $this->load->view('admin/footer');

	    }

		else

		{

		redirect('/admin','refresh');

		}

	

	}

	public function userlocation($userid)

	{

	    if($this->checksession()==1)

		{

		$getid= $this->session->userdata('adminid');

		$data=array('id'=>$getid);

		$userdata["admininfo"]=$this->user_model->get_info('admin',$data);



		$userdata["name"]=$userdata["admininfo"][0]->name;

		

		$userdata["activeurl"]="workingtask";

	   

		$getdata= $this->user_model->preventdata("select `geolocation`.`start` as `userstart`,`geolocation`.`break` as `userbreak`,`geolocation`.`end` as `userend` from `geolocation` where `geolocation`.`assign_task_id`=?",array($userid));

		if(!count($getdata))

		{

		redirect('/admin/workingtask','refresh');

		}

		$statcode=(array)json_decode($getdata[0]->userstart);

		

		$this->load->library('googlemaps');

		//$config['center'] = ''.$statcode["currentlatitude"].','.$statcode["currentlongitude"].'';

		$config['zoom'] = 'auto';

		$config['trafficOverlay'] = TRUE;

		$this->googlemaps->initialize($config);



		$marker = array();

$marker['position'] =''.$statcode["currentlatitude"].','.$statcode["currentlongitude"].'';

		$linepoints[]=$marker['position'];



//$marker['infowindow_content'] = 'Start Location';

//$marker['icon'] = 'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=A|9999FF|000000';

$marker['onclick'] = "dispalypopup('Start task at ".$statcode['startdatetime']."');";

$this->googlemaps->add_marker($marker);

if(!empty($getdata[0]->userbreak))

{

    $breakcode=explode('#@#',$getdata[0]->userbreak);

    foreach($breakcode as $key=>$breakvalue)

	{

	

	   $breakpont= (array)json_decode($breakvalue);

	   $marker = array();

$marker['position'] =''.$breakpont["currentlatitude"].','.$breakpont["currentlongitude"].'';

$linepoints[]=$marker['position'];

$marker['onclick'] = "dispalypopup('Take Brake at ".$statcode['startdatetime']."');";

$marker['icon'] = 'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=A|9999FF|000000';

$this->googlemaps->add_marker($marker);

	}

}

if(!empty($getdata[0]->userend))

{

    $statcode=(array)json_decode($getdata[0]->userend);



    $marker = array();

    $marker['position'] =''.$statcode["currentlatitude"].','.$statcode["currentlongitude"].'';

	$linepoints[]=$marker['position'];



    $marker['onclick'] = "dispalypopup('End task at ".$statcode['enddatetime']."');";

    $this->googlemaps->add_marker($marker);

}

$polyline=array();

$polyline['points']=$linepoints;

        $this->googlemaps->add_polyline($polyline);

		$userdata['map'] = $this->googlemaps->create_map();



		$this->load->view('admin/header',$userdata);

		

		$this->load->view('admin/displaylocation',$userdata);

	    $this->load->view('admin/footer');

	    }

		else

		{

		redirect('/admin','refresh');

		}

	

	}

	private function assignlog($for)

	{

	

	  $this->form_validation->set_rules('assigndate', 'Assign Date', 'required|xss_clean'); 

	  if($this->form_validation->run() === FALSE)

      {

	   if($for=="driver")

	   $this->load->view('admin/driverassign');

	   elseif($for=="helper")

	   $this->load->view('admin/helperassign');

	  }

	  else

	  {
		$datedata= explode(',',$this->input->post("assigndate"));
	 foreach($datedata as $date)
      {
		if($for=="driver")
        {

		$hasassign=$this->user_model->countresult(array("role_id"=>$this->input->post("roleinfo"),"user_id"=>$this->input->post("drivername"),"assign_date"=>$date),'assign_role_date');

		if($hasassign)

		{

		$data['assignerror']="<div class='col-lg-12'><div class='alert alert-info'>This role allready assign  at ".$date." date</div></div>";

		$data["userinfo"]=$this->user_model->getdatawithcondition("user.user_id,user.name","user","user.occupation='driver'");      

		$data["roleinfo"]=$this->user_model->getdatawithcondition("roles.role_id,roles.name","roles","roles.occupation= 'driver'");

		$this->load->view('admin/driverassign',$data);

		continue;

		}

		else
        {
      $row=$this->user_model->use_query("SELECT `amount` FROM  `roles` where `role_id`=".$this->input->post("roleinfo")."");

	 $data=array("user_id"=>$this->input->post("drivername"),"role_id"=>$this->input->post("roleinfo"),"assign_date"=>$date,"role_amount"=>$row[0]->amount);

	     $this->user_model->data_insert('assign_role_date',$data);
         $autoassignid= $this->db->insert_id();
		 $assign_id_date_array[$autoassignid]=$date;
		 $assign_user_id=$this->input->post("drivername");
		 $assign_role_id=$this->input->post("roleinfo");
	    }

		}

	    elseif($for=="helper")

		{

		$hasassign=$this->user_model->countresult(array("role_id"=>$this->input->post("roleinfo"),"user_id"=>$this->input->post("helpername"),"assign_date"=>$date),'assign_role_date');

		 if($hasassign)

		 {

		 

		 $data['assignerror']="<div class='col-lg-12'><div class='alert alert-info'>This role assign at ".$date." date</div></div>";

		 $data["userinfo"]=$this->user_model->getdatawithcondition("user.user_id,user.name","user","user.occupation='helper'");      

		 $data["roleinfo"]=$this->user_model->getdatawithcondition("roles.role_id,roles.name","roles","roles.occupation= 'helper'");

		 $this->load->view('admin/helperassign',$data);

		 

		 	continue;

		 }

		 else

		 {

		 $data=array("user_id"=>$this->input->post("helpername"),"role_id"=>$this->input->post("roleinfo"),"assign_date"=>$date);

	     $this->user_model->data_insert('assign_role_date',$data);
         $autoassignid= $this->db->insert_id();
         $assign_id_date_array[$autoassignid]=$date;
         $assign_user_id=$this->input->post("helpername");
		 $assign_role_id=$this->input->post("roleinfo");
		 }

		}

		

		}
        
		if(!empty($assign_id_date_array))
		$this->puss_notification($assign_id_date_array,$assign_user_id,$assign_role_id);
           
		if($for=="driver")
		{
		$this->session->set_flashdata('message_name', '<div class="col-lg-12"><div class="alert alert-info">Role has been assign driver</div></div>');
        redirect('/admin/driverassign','refresh');
        }
	    elseif($for=="helper")
		{
		$this->session->set_flashdata('message_name', '<div class="col-lg-12"><div class="alert alert-info">Role has been assign helper</div></div>');
        redirect('/admin/helperassign','refresh');
		}

	  }

	}
    private function puss_notification($assign_id_date_array,$userid,$roleid)
	{
	
	 
	 $result=array();
	 $userinfo= $this->user_model->use_query("select `email` from `user` where `user_id`=".$userid."");
	 $useremail=$userinfo[0]->email;	  
	 
     $roleinfo=$this->user_model->use_query("SELECT `name` 
FROM  `roles` where `role_id`=".$roleid."");

	$rolename=$roleinfo[0]->name;	  
		 foreach($assign_id_date_array as $keyassign_id=>$rowdate)
		 {
		      $date=$rowdate;
		      $currentdayno=date('N');
			 
		     if($currentdayno==1)
		     {
			 
		      $startweekday=date('m-d-Y');
			  $n_date=date('d-m-Y');
		      $endweekday=date('m-d-Y', strtotime('+6 days', strtotime($n_date)));
			  
		     }
		     else
		     {
			
		  $currentdayno=$currentdayno-1;
		  $n_date=date('d-m-Y');
		  $startweekday=date('m-d-Y', strtotime('-'.$currentdayno.' days', strtotime($n_date)));
		  $n_date=date('d-m-Y', strtotime('-'.$currentdayno.' days', strtotime($n_date)));
          $endweekday=date('m-d-Y', strtotime('+6 days', strtotime($n_date)));
		     }

		     if (($date >= $startweekday) && ($date <= $endweekday))
             {
	             $holddata["assign_id"]=$keyassign_id;
				 $holddata["email"]=$useremail;
				 $holddata["role"]=$rolename;
				 $holddata["date"]=$date;
				 $dr=explode('-',$date);
				 $date=$dr[2].'-'.$dr[0].'-'.$dr[1];
				 $holddata["day"]=date('l',strtotime($date));
                 $result["message"][]=$holddata;     
             }
             		 
		 
		 }

		     if(count($result))
			 {
			    
			/*	$msg_payload = array 
	                          (
		                    'mtitle' => 'New Job',
		                    'mdesc' => $result["message"],
	                          );
	
	// For Android
	$regId = 'APA91bHdOmMHiRo5jJRM1jvxmGqhComcpVFDqBcPfLVvaieHeFI9WVrwoDeVVD1nPZ82rV2DxcyVv-oMMl5CJPhVXnLrzKiacR99eQ_irrYogy7typHQDb5sg4NB8zn6rFpiBuikNuwDQzr-2abV6Gl_VWDZlJOf4w';
	// For iOS
	$deviceToken = 'FE66489F304DC75B8D6E8200DFF8A456E8DAEACEC428B427E9518741C92C6660';
	*/
	
	// Replace the above variable values
	 $this->load->model('push_model');

	 //$regId ='dOe7vPtzca4:APA91bFQp_Z4Tugtj_55xJ7cz7IQFtbfXBbxC2pacnkX0QKUKC-DKjI-nGnrTK-HsyOVRBUj2rAggeyk8hN4cJe_s56gZYdtwMDK8XKRw4EcvTXhfhcpvOpxW4QhQ4ml6KKnpL3QeEZv';
	 $userinfo= $this->user_model->use_query("select `devicetoken` from `user` where `user_id`=".$userid."");
	 $regId=$userinfo[0]->devicetoken;

	if(!empty($regId))
	$this->push_model->sendPushNotification($regId,'New Job',$result["message"]) ;
    //$this->push_model->android($msg_payload, $regId);
    	
    //$this->push_model->iOS($msg_payload, $deviceToken);
	
	 
			 }

	       
		
		
	}
	
	public function checkemail()

	{

	$email=$this->input->post("useremail");

	$userid=$this->input->post("userid");

    $result=$this->user_model->countresult(array("user_id!="=>$userid,"lower(email)"=>strtolower($email)),"user");

	

	if($result==0)

	{

	return true;

	}

	else

	{

	 

	 $this->form_validation->set_message('checkemail', 'The %s email allready exist');

     return FALSE;

	}

	}

	private function edituserlog()

	{

	

	  $this->form_validation->set_rules('username', 'Name', 'required|min_length[3]|max_length[100]|xss_clean');

	  $this->form_validation->set_rules('useremail', 'Email', 'required|valid_email|callback_checkemail|xss_clean');

	  $this->form_validation->set_rules('userlincese', 'Lincese', 'trim|required|min_length[5]|max_length[100]|xss_clean');

	  $this->form_validation->set_rules('usermobile', 'Mobile', 'trim|required|min_length[10]|max_length[15]|xss_clean');

	  $this->form_validation->set_rules('userbsb', 'Account number 1', 'trim|required|alpha_dash|max_length[100]|xss_clean');

	  $this->form_validation->set_rules('useracc', 'Account number 2', 'trim|alpha_dash|max_length[100]|xss_clean');

      if($this->form_validation->run() === FALSE)

      {

	  return validation_errors();

	  }

	  else

	  {

	  $userid=$this->input->post("userid");


/*
	  $data=array("name"=>$this->input->post("username"),"email"=>$this->input->post("useremail"),"license_number"=>$this->input->post("userlincese"),"mobile"=>$this->input->post("usermobile"),"occupation"=>$this->input->post("useroccupations"),"bsb"=>$this->input->post("userbsb"),"acc"=>$this->input->post("useracc"),"type"=>$this->input->post("usertype"),"fix_amount"=>$this->input->post("assignfixamount"));
*/
  $data=array("name"=>$this->input->post("username"),"email"=>$this->input->post("useremail"),"license_number"=>$this->input->post("userlincese"),"mobile"=>$this->input->post("usermobile"),"occupation"=>$this->input->post("useroccupations"),"bsb"=>$this->input->post("userbsb"),"acc"=>$this->input->post("useracc"),"fix_amount"=>$this->input->post("assignfixamount"));
	  

	  $this->user_model->update_info('user','user_id',$userid,$data);

	  

	  redirect('/admin/displayusers','refresh');

	  }



	

	}

	private function userlog()

	{

	  $this->form_validation->set_rules('username', 'Name', 'trim|required|min_length[3]|max_length[100]|xss_clean');

	  $this->form_validation->set_rules('useremail', 'Email', 'trim|required|valid_email|is_unique[user.email]|xss_clean');

	  $this->form_validation->set_rules('userlincese', 'Lincese', 'trim|required|is_unique[user.license_number]|min_length[5]|max_length[100]|xss_clean');

	  $this->form_validation->set_rules('usermobile', 'Mobile', 'trim|required|min_length[10]|max_length[15]|xss_clean');

	  $this->form_validation->set_rules('userpassword', 'Password', 'trim|required|alpha_numeric|min_length[8]|max_length[15]|xss_clean');

	  $this->form_validation->set_rules('userconfirmpassword', 'Confirm Password', 'trim|required|matches[userpassword]|xss_clean');

	  $this->form_validation->set_rules('userbsb', 'Account number 1', 'trim|required|alpha_dash|max_length[100]|xss_clean');

	  $this->form_validation->set_rules('useracc', 'Account number 2', 'trim|alpha_dash|max_length[100]|xss_clean');

	  if($this->form_validation->run() === FALSE)

      {

	  $this->load->view('admin/adduser');

	  }

	  else

	  {

	/*  $data=array("name"=>$this->input->post("username"),"email"=>$this->input->post("useremail"),"password"=>sha1($this->input->post("password")),"license_number"=>$this->input->post("userlincese"),"mobile"=>$this->input->post("usermobile"),"occupation"=>$this->input->post("useroccupations"),"bsb"=>$this->input->post("userbsb"),"acc"=>$this->input->post("useracc"),"type"=>$this->input->post("usertype"),"fix_amount"=>$this->input->post("assignfixamount"),"random_num"=>sha1(uniqid()));
*/
  $data=array("name"=>$this->input->post("username"),"email"=>$this->input->post("useremail"),"password"=>sha1($this->input->post("password")),"license_number"=>$this->input->post("userlincese"),"mobile"=>$this->input->post("usermobile"),"occupation"=>$this->input->post("useroccupations"),"bsb"=>$this->input->post("userbsb"),"acc"=>$this->input->post("useracc"),"fix_amount"=>$this->input->post("assignfixamount"),"random_num"=>sha1(uniqid()));
	  $this->user_model->data_insert('user',$data);

	  

	  redirect('/admin/displayusers','refresh');

	  }

	  

	}



    public function pagination($hit_url,$table,$num_page,$condition=null,$conditiontype=null)

	{

	

	   $config = array();

	   $config['full_tag_open'] = '<ul class="pagination">';

       $config['full_tag_close'] = '</ul>';

       $config['prev_link'] = '&lt;';

       $config['prev_tag_open'] = '<li>';

       $config['prev_tag_close'] = '</li>';

       $config['next_link'] = '&gt;';

       $config['next_tag_open'] = '<li>';

       $config['next_tag_close'] = '</li>';

       $config['cur_tag_open'] = '<li class="current"><a href="#">';

       $config['cur_tag_close'] = '</a></li>';

       $config['num_tag_open'] = '<li>';

       $config['num_tag_close'] = '</li>';

 

       $config['first_tag_open'] = '<li>';

       $config['first_tag_close'] = '</li>';

       $config['last_tag_open'] = '<li>';

       $config['last_tag_close'] = '</li>';

 

       $config['first_link'] = '&lt;&lt;';

       $config['last_link'] = '&gt;&gt;';

       $config["base_url"] = base_url() . $hit_url;

	   if(is_null($condition)){

       $config["total_rows"] = $this->user_model->countresult(NULL,$table);
	   }

	   else{

	    if($conditiontype=="like")

		{

	     $config["total_rows"] = $this->user_model->countresultuselike($condition,$table);

		}

	    elseif($conditiontype=="join")

		{

		$config["total_rows"] = $this->user_model->gettotalfromquery($condition);

		}

		else

		{

		$config["total_rows"] = $this->user_model->countresult($condition,$table);

		}

	   }



       $config["per_page"] = $num_page;

       $config["uri_segment"] = 3;

	   

	   $this->pagination->initialize($config);

	   return $this->pagination->create_links();

	}

	public function account_active($id,$token)

	{

	     

		 $count=$this->user_model->countresult(array("user_id"=>$id,"random_num"=>$token),"user");



		 if($count)

		 {

		 $this->user_model->update_info("user","user_id",$id,array('active'=>'1',"random_num"=>""));		

	     $data["message"]="Your account has been actived. You can login by app.";

	     }

		 else

		 {

		 $data["message"]="Account active error";

		 }

		$this->load->view('admin/accountactive',$data); 

	}

	public function deletedata($id,$tablename)

	{

	   if($tablename=="user")

	   {

	   $this->user_model->row_delete_with_othertable("user",array('user_id'=>$id));

	   redirect('/admin/displayusers','refresh');

	   }

	   else if($tablename=="helperassign")

	   {

       	

		$this->user_model->row_delete_with_othertable("assign_role_date",array('id'=>$id));

	   redirect('/admin/displayhelperassign','refresh');

	   }

	   else if($tablename=="driverassign")

	   {

       	

	   $this->user_model->row_delete_with_othertable("assign_role_date",array('id'=>$id));

	   redirect('/admin/displaydriverassign','refresh');

	   }

	   else if($tablename=="role")

	   {

	   $this->user_model->row_delete_with_othertable("roles",array('role_id'=>$id));

       redirect('/admin/displayrole','refresh');

	   }

	   else if($tablename=="truck_fault")

	   {

	   $this->user_model->row_delete_with_othertable("truck_fault",array('id'=>$id));

       redirect('/admin/truckinfo','refresh');

	   }

	   else if($tablename=="hourly_prices")

	   {

	   $this->user_model->row_delete_with_othertable("hourly_prices",array('id'=>$id));

       redirect('/admin/displayhourlyamount','refresh');

	   }

	   else if($tablename=="truck_info")

	   {

	   $this->user_model->row_delete_with_othertable("truck_info",array('id'=>$id));

	   redirect('/admin/displaytruck','refresh');

	   }else if($tablename=="truckrole")

	   {

	   $this->user_model->row_delete_with_othertable("truckrole",array('id'=>$id));

	   redirect('/admin/truckrole','refresh');

	   }else if($tablename=="hourly_job_assign")

	   {

	   $this->user_model->row_delete_with_othertable("hourly_job_assign",array('id'=>$id));

	   redirect('/admin/displayhourlyjob','refresh');

	   }

	}



	public function displaydriverassign()

	{

	    if($this->checksession()==1)

		{

		$getpaginationlink=$this->pagination("admin/displaydriverassign","assign_role_date",50,"select count(*) as total from assign_role_date inner join user on assign_role_date.user_id=user.user_id inner join roles on assign_role_date.role_id=roles.role_id 

where user.occupation='driver'","join");

		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

		$getid= $this->session->userdata('adminid');

		$data=array('id'=>$getid);

		$userdata["admininfo"]=$this->user_model->get_info('admin',$data);



		$userdata["name"]=$userdata["admininfo"][0]->name;

		$userdata["activeurl"]="displaydriverassign";

	    $this->load->view('admin/header',$userdata);

	$data["assign"]=$this->user_model->three_table_join_with_condition("`assign_role_date`.`id`,`assign_role_date`.`assign_date` as assigndate,STR_TO_DATE(`assign_role_date`.`assign_date`,'%m-%d-%Y') as formatdate,`user`.`name` as username,`roles`.`name` as rolename","`assign_role_date`","`user`","`roles`","`assign_role_date`.`user_id`=`user`.`user_id`","inner","`assign_role_date`.`role_id`=`roles`.`role_id`","inner","`user`.`occupation`='driver'","formatdate","desc",50, $page);		

		$data["links"] = $getpaginationlink;

		$this->load->view('admin/displaydriverassign',$data);



		$this->load->view('admin/footer');

		}

		else

		{

		redirect('/admin','refresh');

		}

	

	}

	public function displayhelperassign()

	{

	    if($this->checksession()==1)

		{

				$getpaginationlink=$this->pagination("admin/displayhelperassign","assign_role_date",50,"select count(*) as total from assign_role_date inner join user on assign_role_date.user_id=user.user_id inner join roles on assign_role_date.role_id=roles.role_id 

where user.occupation='helper'","join");

$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

		$getid= $this->session->userdata('adminid');

		$data=array('id'=>$getid);

		$userdata["admininfo"]=$this->user_model->get_info('admin',$data);



		$userdata["name"]=$userdata["admininfo"][0]->name;

		$userdata["activeurl"]="displayhelperassign";

	    $this->load->view('admin/header',$userdata);

		

	$data["assign"]=$this->user_model->three_table_join_with_condition("`assign_role_date`.`id`,`assign_role_date`.`assign_date` as assigndate,STR_TO_DATE(`assign_role_date`.`assign_date`,'%m-%d-%Y') as formatdate,`user`.`name` as username,`roles`.`name` as rolename","`assign_role_date`","`user`","`roles`","`assign_role_date`.`user_id`=`user`.`user_id`","inner","`assign_role_date`.`role_id`=`roles`.`role_id`","inner","`user`.`occupation`='helper'","formatdate","desc",50, $page);		

		$data["links"] = $getpaginationlink;

		$this->load->view('admin/displayhelperassign',$data);



		$this->load->view('admin/footer');

		}

		else

		{

		redirect('/admin','refresh');

		}

	

	}

	public function edithelpertask($id=NULL)

	{

	

	   $getid= $this->session->userdata('adminid');

		$data=array('id'=>$getid);

		$userdata["admininfo"]=$this->user_model->get_info('admin',$data);

        $userdata["name"]=$userdata["admininfo"][0]->name;

		$this->load->view('admin/header',$userdata);

       		

	   if($_POST)

	   {

          $this->editassignlog("helper");	   

		  $data["taskid"]=$_POST["assigntaskid"];

	   }

	   else

	   {

	   $data["taskid"]=$id;

	   }

		$data["assigntask"]=$this->user_model->getdatawithcondition("user_id,role_id,assign_date","assign_role_date","id=".$id."");

		$data["userinfo"]=$this->user_model->getdatawithcondition("user.user_id,user.name","user","user.occupation='helper'");      $data["roleinfo"]=$this->user_model->getdatawithcondition("roles.role_id,roles.name","roles","roles.occupation= 'helper'");



		$this->load->view('admin/edithelpertask',$data);

		$this->load->view('admin/footer');



	

	

	}

	public function editdrivertask($id=NULL)

	{

	    $getid= $this->session->userdata('adminid');

		$data=array('id'=>$getid);

		$userdata["admininfo"]=$this->user_model->get_info('admin',$data);

        $userdata["name"]=$userdata["admininfo"][0]->name;

		$this->load->view('admin/header',$userdata);

       		

	   if($_POST)

	   {

          $this->editassignlog("driver");	   

		  $data["taskid"]=$_POST["assigntaskid"];

	   }

	   else

	   {

	   $data["taskid"]=$id;

	   }

		$data["assigntask"]=$this->user_model->getdatawithcondition("user_id,role_id,assign_date","assign_role_date","id=".$id."");

		$data["userinfo"]=$this->user_model->getdatawithcondition("user.user_id,user.name","user","user.occupation='driver'");      $data["roleinfo"]=$this->user_model->getdatawithcondition("roles.role_id,roles.name","roles","roles.occupation= 'driver'");



		$this->load->view('admin/editdrivertask',$data);

		$this->load->view('admin/footer');

	

	}

	public function driverassign()

	{

			

	    if($this->checksession()==1)
        {
           
		   
		$getid= $this->session->userdata('adminid');

		$data=array('id'=>$getid);

		$userdata["admininfo"]=$this->user_model->get_info('admin',$data);



		$userdata["name"]=$userdata["admininfo"][0]->name;

		

		$userdata["activeurl"]="driverassign";

	    $this->load->view('admin/header',$userdata);

		if($_POST)

		{

		$this->assignlog('driver');

		}

		else

		{

		$totalhelper=$this->user_model->countresult("user.occupation='driver'","user");

		if($totalhelper==0)

		{

		$this->session->set_flashdata('message', '<div class="alert alert-info">No driver exist. First add driver.</div>');

		redirect('/admin/adduser','refresh');

		}else
		{
       $data["userinfo"]=$this->user_model->getdatawithconditionwithorder("user.name,user.user_id","user","user.occupation='driver'","user.name", "asc");
		}

		 $totalhelper=$this->user_model->countresult("roles.occupation='driver'","roles");

		 if($totalhelper==0)

		 {

		 $this->session->set_flashdata('message', '<div class="alert alert-info">No role exist for driver. First add role for driver.</div>');

		 redirect('/admin/addrole','refresh');

		 }

		 else

		 {

        $data["roleinfo"]=$this->user_model->getdatawithcondition("roles.role_id,roles.name","roles","roles.occupation= 'driver'");

         }

		$this->load->view('admin/driverassign',$data);

		}

		$this->load->view('admin/footer');

		}

		else

		{

		redirect('/admin','refresh');

		}

	

	}

	public function helperassign()
    {

	    if($this->checksession()==1)

		{

		$getid= $this->session->userdata('adminid');

		$data=array('id'=>$getid);

		$userdata["admininfo"]=$this->user_model->get_info('admin',$data);



		$userdata["name"]=$userdata["admininfo"][0]->name;

		$userdata["activeurl"]="helperassign";

	    $this->load->view('admin/header',$userdata);

		if($_POST)

		{

		$this->assignlog('helper');

		}

		else

		{

		$totalhelper=$this->user_model->countresult("user.occupation='helper'","user");

		if($totalhelper==0)

		{

		$this->session->set_flashdata('message', '<div class="alert alert-info">No helper exist. First add helper.</div>');

		redirect('/admin/adduser','refresh');

		}else

		{

	$data["userinfo"]=$this->user_model->getdatawithcondition("user.user_id,user.name","user","user.occupation='helper'");

		}

	    $totalroles=$this->user_model->countresult("roles.occupation='helper'","roles");	

		if($totalroles==0)

		{

		$this->session->set_flashdata('message', '<div class="alert alert-info">No role exist for helper. First add role for helper.</div>');

		redirect('/admin/addrole','refresh');

		}

		else

		{

        $data["roleinfo"]=$this->user_model->getdatawithcondition("roles.role_id,roles.name","roles","roles.occupation= 'helper'");

        }

		$this->load->view('admin/helperassign',$data);

		}

		$this->load->view('admin/footer');

		}

		else

		{

		redirect('/admin','refresh');

		}

	

	}

	public function addrole()

	{

	   if($this->checksession()==1)

		{

		$getid= $this->session->userdata('adminid');

		$data=array('id'=>$getid);

		$userdata["admininfo"]=$this->user_model->get_info('admin',$data);



		$userdata["name"]=$userdata["admininfo"][0]->name;

		$userdata["activeurl"]="addrole";

	    $this->load->view('admin/header',$userdata);

		if($_POST)

		{

		$this->rolelog();

		}

		$comapnyname=$this->user_model->getalldatawithorderby("id,name","company","name","asc");

		$comapny=[];

		foreach($comapnyname as $row){$comapny[$row->id]=$row->name;}

        $data["company"]=$comapny;

		$this->load->view('admin/addrole',$data);

		

		$this->load->view('admin/footer');

		}

		else

		{

		redirect('/admin','refresh');

		}

	

	}



	public function displaycompany()
    {

	  if($this->checksession()==1)

		{

		$getpaginationlink=$this->pagination("admin/displaycompany","roles",50);

		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

		$getid= $this->session->userdata('adminid');

		$data=array('id'=>$getid);

		$userdata["admininfo"]=$this->user_model->get_info('admin',$data);



		$userdata["name"]=$userdata["admininfo"][0]->name;

		$userdata["activeurl"]="displaycompany";

	    $this->load->view('admin/header',$userdata);

		$data["company"]=$this->user_model->getalldata('id,name,email,address,phone_number,ab_number,ac_number,description','company',50,$page);

		$data["links"] = $getpaginationlink;

		$this->load->view('admin/displaycompany',$data);

		$this->load->view('admin/footer');

		}

		else

		{

        redirect('/admin','refresh');		

		}

 	}

	public function displayrole()

	{

	    if($this->checksession()==1)

		{

		$getpaginationlink=$this->pagination("admin/displayrole","roles",50);

		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

		$getid= $this->session->userdata('adminid');

		$data=array('id'=>$getid);

		$userdata["admininfo"]=$this->user_model->get_info('admin',$data);



		$userdata["name"]=$userdata["admininfo"][0]->name;

		$userdata["activeurl"]="displayrole";

	    $this->load->view('admin/header',$userdata);

		$data["roles"]=$this->user_model->getalldatawithorder('role_id,name,shift_time,occupation,amount','roles','name','asc',50,$page);



		$data["links"] = $getpaginationlink;

		$this->load->view('admin/displayrole',$data);

		$this->load->view('admin/footer');

		}

		else

		{

        redirect('/admin','refresh');		

		}

       	

	}

	

public function datacurrentweek()

{
if(empty($_POST["choosedate"]))

{

       //$result=$this->user_model->use_query("select DAYOFWEEK( CURDATE( )) as daynum,CURDATE( )");
	   
		    $day_of_week = date('N', strtotime(date('d-m-Y')));
		
			
			//if($result[0]->daynum==1)
			if($day_of_week==7)
			{

$result=	$this->user_model->leftright_join_with_limit("`assign_role_date`.`id`,`user`.`occupation`,`assign_role_date`.`role_id`,`user`.`name`,lower(DATE_FORMAT( STR_TO_DATE(  `assign_role_date`.`assign_date` ,  '%m-%d-%Y' ) ,  '%a' )) as dayname","`assign_role_date`","`user`","`assign_role_date`.`user_id`=`user`.`user_id`","inner","DATE_FORMAT( STR_TO_DATE(  `assign_role_date`.`assign_date` , '%m-%d-%Y' ) ,  '%m-%d-%Y' ) between

DATE_FORMAT( CURDATE( ) - INTERVAL 7 -1

DAY ,  '%m-%d-%Y' ) and  

DATE_FORMAT( (

CURDATE( ) - INTERVAL 7 -1

DAY ) + INTERVAL 6 

DAY ,  '%m-%d-%Y'

)",0,100);
			
			}
			else
			{

$result=	$this->user_model->leftright_join_with_limit("`assign_role_date`.`id`,`user`.`occupation`,`assign_role_date`.`role_id`,`user`.`name`,lower(DATE_FORMAT( STR_TO_DATE(  `assign_role_date`.`assign_date` ,  '%m-%d-%Y' ) ,  '%a' )) as dayname","`assign_role_date`","`user`","`assign_role_date`.`user_id`=`user`.`user_id`","inner","DATE_FORMAT( STR_TO_DATE(  `assign_role_date`.`assign_date` , '%m-%d-%Y' ) ,  '%m-%d-%Y' ) between

DATE_FORMAT( CURDATE( ) - INTERVAL DAYOFWEEK( CURDATE( ) ) -2

DAY ,  '%m-%d-%Y' ) and  

DATE_FORMAT( (

CURDATE( ) - INTERVAL DAYOFWEEK( CURDATE( ) ) -2

DAY ) + INTERVAL 7 

DAY ,  '%m-%d-%Y'

)",0,100);
       }
//echo $this->db->last_query();
}

else

{

   $data["start"]= $_POST["choosetype"];



   if($_POST["choosetype"]=="next")

   {

$result=	$this->user_model->leftright_join_with_limit("`assign_role_date`.`id`,`user`.`occupation`,`assign_role_date`.`role_id`,`user`.`name`,lower(DATE_FORMAT( STR_TO_DATE(  `assign_role_date`.`assign_date` ,  '%m-%d-%Y' ) ,  '%a' )) as dayname","`assign_role_date`","`user`","`assign_role_date`.`user_id`=`user`.`user_id`","inner","DATE_FORMAT( STR_TO_DATE(  `assign_role_date`.`assign_date` , '%m-%d-%Y' ) ,  '%m-%d-%Y' ) between

DATE_FORMAT('".$_POST['choosedate']."' - INTERVAL DAYOFWEEK('".$_POST['choosedate']."') -2

DAY ,  '%m-%d-%Y' ) and  

DATE_FORMAT(('".$_POST['choosedate']."' - INTERVAL DAYOFWEEK('".$_POST['choosedate']."') -2

DAY ) + INTERVAL 7 

DAY ,  '%m-%d-%Y'

)",0,100);

   }

   else

   {

$result=	$this->user_model->leftright_join_with_limit("`assign_role_date`.`id`,`user`.`occupation`,`assign_role_date`.`role_id`,`user`.`name`,lower(DATE_FORMAT( STR_TO_DATE(  `assign_role_date`.`assign_date` ,  '%m-%d-%Y' ) ,  '%a' )) as dayname","`assign_role_date`","`user`","`assign_role_date`.`user_id`=`user`.`user_id`","inner","DATE_FORMAT( STR_TO_DATE(  `assign_role_date`.`assign_date` , '%m-%d-%Y' ) ,  '%m-%d-%Y' ) between

DATE_FORMAT('".$_POST['choosedate']."' - INTERVAL 6

DAY,  '%m-%d-%Y' ) and  

DATE_FORMAT(('".$_POST['choosedate']."' + INTERVAL 0

DAY ),  '%m-%d-%Y')",0,100);

  }

}

$data=array();

 foreach($result as $row)

 {

 if($row->occupation=="driver")

 {

	 if(isset($data[$row->dayname."_".$row->role_id]))

	 {

	 $data[$row->dayname."_".$row->role_id]=$data[$row->dayname."_".$row->role_id].","."<br/><a href='".site_url('admin/editdrivertask/'.$row->id.'')."'>".$row->name."</a>";

	 }

	 else

	 {

	 $data[$row->dayname."_".$row->role_id]="<a href='".site_url('admin/editdrivertask/'.$row->id.'')."'>".$row->name."</a>";

	 }

 }

 else if($row->occupation=="helper")

 {

     if(isset($data[$row->dayname."_".$row->role_id]))

	 { 

     $data[$row->dayname."_".$row->role_id]=$data[$row->dayname."_".$row->role_id].","."<br/><a href='".site_url('admin/edithelpertask/'.$row->id.'')."'>".$row->name."</a>";    

	 }

	 else

	 {

	$data[$row->dayname."_".$row->role_id]="<a href='".site_url('admin/edithelpertask/'.$row->id.'')."'>".$row->name."</a>";

	 }

 }

 }

 echo json_encode($data);

 die;

	}

   private function weeklyhourlyamount($userid)

   {

            

			

			if($_POST)

			{

$choosedate=(isset($_POST["prevhidden"])?$this->input->post("prevhidden"):(isset($_POST["nexthidden"])?$this->input->post("nexthidden"):''));

			$choosetype=(isset($_POST["prevhidden"])?"prev":(isset($_POST["nexthidden"])?"next":''));

            }

			if(empty($choosedate))

			{

			

$getdata=$this->user_model->use_query("SELECT (`hourly_job_assign`.`per_hour`/60) as `amount`,COUNT(`hourly_job_assign`.`user_id`) AS weeklyhourlyjob, `hourlyjob`.`assign_id` , sum(ABS( TIMESTAMPDIFF( 

MINUTE ,  `hourlyjob`.`start_time` ,  `hourlyjob`.`end_time` ) )*(`hourly_job_assign`.`per_hour`/60)) AS TOTAL_AMOUNT, SUM( ABS( TIMESTAMPDIFF( 

MINUTE ,  `hourlyjob`.`start_time` ,  `hourlyjob`.`end_time` ) ) ) 

DIV 60 AS HOUR , SUM( ABS( TIMESTAMPDIFF( 

MINUTE ,  `hourlyjob`.`start_time` ,  `hourlyjob`.`end_time` ) ) ) MOD 60 AS MINUTES

FROM  `hourlyjob` inner join `hourly_job_assign` on `hourly_job_assign`.`id`=`hourlyjob`.`assign_id`

WHERE DATE_FORMAT(  `hourlyjob`.`start_time` ,  '%m-%d-%Y' ) 

BETWEEN DATE_FORMAT( CURDATE( ) - INTERVAL DAYOFWEEK( CURDATE( ) ) -2

DAY ,  '%m-%d-%Y' ) 

AND DATE_FORMAT( (

CURDATE( ) - INTERVAL DAYOFWEEK( CURDATE( ) ) -2

DAY ) + INTERVAL 6 

DAY ,  '%m-%d-%Y'

) and `hourly_job_assign`.`user_id`=".$userid." GROUP BY `hourly_job_assign`.`user_id`");

             return $getdata;

			}

			else

			{

			   if($choosetype=="next")

               {

			   $getdata=	$this->user_model->use_query("SELECT (`hourly_job_assign`.`per_hour`/60) as `amount`, COUNT(`hourly_job_assign`.`user_id`) AS weeklyhourlyjob, `hourlyjob`.`assign_id` , sum(ABS( TIMESTAMPDIFF( 

MINUTE ,  `hourlyjob`.`start_time` ,  `hourlyjob`.`end_time` ) )*(`hourly_job_assign`.`per_hour`/60)) AS TOTAL_AMOUNT,SUM( ABS( TIMESTAMPDIFF( 

MINUTE ,  `hourlyjob`.`start_time` ,  `hourlyjob`.`end_time`) ) ) 

DIV 60 AS HOUR , SUM( ABS( TIMESTAMPDIFF( 

MINUTE ,  `hourlyjob`.`start_time` ,  `hourlyjob`.`end_time` ) ) ) MOD 60 AS MINUTES

FROM   `hourlyjob` inner join `hourly_job_assign` on `hourly_job_assign`.`id`=`hourlyjob`.`assign_id`

WHERE DATE_FORMAT(`hourlyjob`.`start_time` ,'%m-%d-%Y' ) 

BETWEEN 

DATE_FORMAT( '".$choosedate."' - INTERVAL 0 DAY,  '%m-%d-%Y' ) and  

DATE_FORMAT('".$choosedate."'  + INTERVAL 6 DAY ,  '%m-%d-%Y') and `hourly_job_assign`.`user_id`=".$userid." GROUP BY `hourly_job_assign`.`user_id`");

               

			   return $getdata;

			   }

			   else if($choosetype=="prev")

			   {

$getdata=	$this->user_model->use_query("SELECT (`hourly_job_assign`.`per_hour`/60) as `amount`, COUNT(`hourly_job_assign`.`user_id`) AS weeklyhourlyjob, `hourlyjob`.`assign_id` , sum(ABS( TIMESTAMPDIFF( 

MINUTE ,  `hourlyjob`.`start_time` ,  `hourlyjob`.`end_time` ) )*(`hourly_job_assign`.`per_hour`/60)) AS TOTAL_AMOUNT, SUM( ABS( TIMESTAMPDIFF( 

MINUTE ,  `hourlyjob`.`start_time` ,  `hourlyjob`.`end_time`) ) ) 

DIV 60 AS HOUR , SUM( ABS( TIMESTAMPDIFF( 

MINUTE ,  `hourlyjob`.`start_time` ,  `hourlyjob`.`end_time` ) ) ) MOD 60 AS MINUTES FROM

`hourlyjob` inner join `hourly_job_assign` on `hourly_job_assign`.`id`=`hourlyjob`.`assign_id`

WHERE DATE_FORMAT(`hourlyjob`.`start_time` ,  '%m-%d-%Y' ) 

BETWEEN DATE_FORMAT('".$choosedate."' - INTERVAL 6 DAY, '%m-%d-%Y') and  DATE_FORMAT('".$choosedate."' + INTERVAL 0 DAY,'%m-%d-%Y') and `hourly_job_assign`.`user_id`=".$userid." GROUP BY `hourly_job_assign`.`user_id`");



               return $getdata;

			   }

			

			}

   }

public function getuserweeklyamount()

{
if($_POST)
{
     $query="select `assign_role_date`.`assign_date`,`geolocation`.`break` as `getbreak`,`geolocation`.`start` as `startdate`,`geolocation`.`upadtedatetime` as `enddate`, `user`.`name`,`roles`.`name` as rolename,`assign_role_date`.`role_amount` as amount from `assign_role_date` inner join `user` on `assign_role_date`.`user_id`=`user`.`user_id` inner join `roles` on `assign_role_date`.`role_id`=`roles`.`role_id` inner join `geolocation` on `assign_role_date`.`id`=`geolocation`.`assign_task_id` where `geolocation`.`status`='done' and DATE_FORMAT( STR_TO_DATE(  `assign_role_date`.`assign_date` , '%m-%d-%Y' ) ,  '%m-%d-%Y' ) between

DATE_FORMAT(STR_TO_DATE('".$_POST['startdate']."','%m-%d-%Y') + INTERVAL 0 DAY ,  '%m-%d-%Y' ) and  

DATE_FORMAT( STR_TO_DATE('".$_POST['enddate']."','%m-%d-%Y') + INTERVAL 0 DAY ,  '%m-%d-%Y') and `user`.`user_id`=".$_POST['user_id']."  order by `assign_role_date`.`assign_date` asc";



    $fixedresult=$this->user_model->use_query($query);

	

	if(count($fixedresult))

	{

     echo "<div><div><h4>Fixed Job</4></div><table class='table'><thead><th>Name</th><th>Date</th><th>Role Name</th><th>Total Time(hh:mm:ss)</th><th>Total Break</th><th>Amount</th></thead><tbody>";

    foreach($fixedresult as $row)
    {
	   $getbreak=$row->getbreak;
	   
	   $getbreak=explode('#@#',$getbreak);
	   $totalbreak=0;
	   foreach($getbreak as $breakrow)
	   {
	     $break=json_decode($breakrow);
	     if(isset($break->startdatetime))
		 {
		  $totalbreak++;
		 }
	   }
	    
	   
      $object=json_decode($row->startdate);
	  $startdatetime=$object->startdatetime;
	  
	  $enddatetime=$row->enddate;
	  
	  $datearray=explode(' ',$startdatetime);
      $datetimearray=explode('-',$datearray[0]);
	  
	  
	  $startdatetime= $datetimearray[2]."-".$datetimearray[0]."-".$datetimearray[1]." ".$datearray[1];
	  
	  $datearray=explode(' ',$enddatetime);
      $datetimearray=explode('-',$datearray[0]);
	  
	  
	  $enddatetime= $datetimearray[2]."-".$datetimearray[0]."-".$datetimearray[1]." ".$datearray[1];
	  
	  $date_a = new DateTime($startdatetime);
	  
	  
      $date_b = new DateTime($enddatetime);

      $interval = date_diff($date_a,$date_b);
 
 echo "<tr><td>".$row->name."</td><td>".$row->assign_date."</td><td>".$row->rolename."</td><td>".$interval->format('%h:%i:%s')."</td><td>".$totalbreak."</td><td>".$row->amount."</td></tr>";

     }

    echo "</tbody></table></div>";

	}

	

$query="SELECT `user`.`name`,`user`.`occupation`,`hourly_job_assign`.`per_hour` as amountperhour, `hourlyjob`.`start_time`, ABS( TIMESTAMPDIFF( 

MINUTE , `hourlyjob`.`start_time` ,  `hourlyjob`.`end_time` ) ) AS MINUTESDIFF, concat( ABS( TIMESTAMPDIFF( 

MINUTE ,  `hourlyjob`.`start_time` ,  `hourlyjob`.`end_time` ) )  

DIV 60  ,':', ABS( TIMESTAMPDIFF( 

MINUTE ,  `hourlyjob`.`start_time` ,  `hourlyjob`.`end_time` ) )  MOD 60) AS total_time_taken

FROM  `hourlyjob` INNER JOIN `hourly_job_assign` ON

`hourly_job_assign`.`id`=`hourlyjob`.`assign_id` INNER JOIN `user` on `hourly_job_assign`.`user_id`=`user`.`user_id`  

WHERE DATE_FORMAT(  `hourlyjob`.`start_time` ,  '%m-%d-%Y' ) 

BETWEEN 

DATE_FORMAT(STR_TO_DATE('".$_POST['startdate']."','%m-%d-%Y') + INTERVAL 0 DAY ,  '%m-%d-%Y' ) and  

DATE_FORMAT( STR_TO_DATE('".$_POST['enddate']."','%m-%d-%Y') + INTERVAL 0 DAY ,  '%m-%d-%Y') and `user`.`user_id`=".$_POST['user_id']." order by `hourlyjob`.`start_time` asc";



   $hourlyresult=$this->user_model->use_query($query);



	if(count($hourlyresult))

	{

     echo "<div><div><h4>Hourly Job</4></div><table class='table'><thead><th>Name</th><th>Date</th><th>Role</th><th>Hourly Amount</th><th>Total time</th><th>Amount</th></thead><tbody>";

    foreach($hourlyresult as $row)

     {

	 $gettotalprice=round($row->MINUTESDIFF*($row->amountperhour/60),2);

	 

    echo "<tr><td>".$row->name."</td><td>".$row->start_time."</td><td>".$row->occupation."</td><td>".$row->amountperhour."</td><td>".$row->total_time_taken."</td><td>".$gettotalprice."</td></tr>";

     }

    echo "</tbody></table></div>";

	}

   }

   

  }
  public function getsearch()
  {
       if($this->checksession()==1)
       {
	        $getid= $this->session->userdata('adminid');

		    $data=array('id'=>$getid);
			$fixedresult=array();
			$getdata=array();
            $userdata["admininfo"]=$this->user_model->get_info('admin',$data);
		   if($_POST)
		   {
$query="select `roles`.`name` as rolename,`assign_role_date`.`assign_date`,`geolocation`.`start` as  `startdate`,`geolocation`.`end` as `enddate`, `user`.`name`,`assign_role_date`.`role_amount`  from `assign_role_date` inner join `user` on `assign_role_date`.`user_id`=`user`.`user_id` inner join `roles` on `assign_role_date`.`role_id`=`roles`.`role_id` inner join `geolocation` on `assign_role_date`.`id`=`geolocation`.`assign_task_id` where `geolocation`.`status`='done' and `user`.`user_id`=".$_POST["user_name"]."  order by `user`.`name` asc";

$fixedresult=$this->user_model->use_query($query);
$getdata=$this->user_model->use_query("SELECT (`hourly_job_assign`.`per_hour`/60) as `amount`,`hourly_job_assign`.`per_hour`,`hourlyjob`.`start_time`,`hourlyjob`.`end_time`,COUNT(`hourly_job_assign`.`user_id`) AS weeklyhourlyjob, `hourlyjob`.`assign_id` , ABS( TIMESTAMPDIFF( 

MINUTE ,  `hourlyjob`.`start_time` ,  `hourlyjob`.`end_time` ) )*(`hourly_job_assign`.`per_hour`/60) AS AMOUNT,  ABS( TIMESTAMPDIFF( 

MINUTE ,  `hourlyjob`.`start_time` ,  `hourlyjob`.`end_time` ) )  

DIV 60 AS HOUR , ABS( TIMESTAMPDIFF( 

MINUTE ,  `hourlyjob`.`start_time` ,  `hourlyjob`.`end_time` ) )  MOD 60 AS MINUTES,`user`.`name`

FROM  `hourlyjob` inner join `hourly_job_assign` on `hourly_job_assign`.`id`=`hourlyjob`.`assign_id`
inner join `user` on `user`.`user_id`=`hourly_job_assign`.`user_id` 
WHERE `hourly_job_assign`.`user_id`=".$_POST["user_name"]." ");

}

        
        $userdata["activeurl"]="deliveryfixedamount";
		    $username= $this->user_model->use_query("select user_id,name,email from user");
			$getname=array();
			foreach($username as $row){$getname[$row->user_id]=$row->name;}
			$userdata["username"]=$getname;
$userdata["fixedresult"]=$fixedresult;
$userdata["hourlyresult"]=$getdata;
        $this->load->view('admin/header',$userdata); 
        $this->load->view('admin/getsearch',$userdata);
 
        
	   }else
	   {
	    redirect('/admin','refresh');
	   }
  
  }

	public function weeklyfixedamount()
    {

	  if($this->checksession()==1)

	  {

		    $getid= $this->session->userdata('adminid');

		    $data=array('id'=>$getid);

		    $userdata["admininfo"]=$this->user_model->get_info('admin',$data);



		    $userdata["name"]=$userdata["admininfo"][0]->name;

			$userdata["activeurl"]="deliveryfixedamount";

			$this->load->view('admin/header',$userdata); 

            $choosedate='';

			if($_POST)

			{



			$choosedate=(isset($_POST["prevhidden"])?$this->input->post("prevhidden"):(isset($_POST["nexthidden"])?$this->input->post("nexthidden"):''));

			$choosetype=(isset($_POST["prevhidden"])?"prev":(isset($_POST["nexthidden"])?"next":''));

			

			}

			if(empty($choosedate))

			{

			$data["startenddate"]=$this->user_model->use_query("select DATE_FORMAT( CURDATE( ) - INTERVAL DAYOFWEEK( CURDATE( ) ) -2

DAY ,  '%m-%d-%Y' ) as start_date,DATE_FORMAT( (

CURDATE( ) - INTERVAL DAYOFWEEK( CURDATE( ) ) -2

DAY ) + INTERVAL 6 

DAY ,  '%m-%d-%Y'

) as end_date");



$users="select `user`.`name`,`user`.`user_id`,`user`.`occupation` from `user` order by `user`.`name` asc";

$userresult=$this->user_model->use_query($users);

   

				foreach($userresult as $userrow)
                {
$query="select count(`assign_role_date`.`user_id`) as fixedjob,`geolocation`.`start` as  `startdate`,`geolocation`.`end` as `enddate`, `user`.`name`,sum(`assign_role_date`.`role_amount`) as total_amount from `assign_role_date` inner join `user` on `assign_role_date`.`user_id`=`user`.`user_id` inner join `roles` on `assign_role_date`.`role_id`=`roles`.`role_id` inner join `geolocation` on `assign_role_date`.`id`=`geolocation`.`assign_task_id` where `geolocation`.`status`='done' and DATE_FORMAT( STR_TO_DATE(  `assign_role_date`.`assign_date` , '%m-%d-%Y' ) ,  '%m-%d-%Y' ) between

DATE_FORMAT( CURDATE( ) - INTERVAL DAYOFWEEK( CURDATE( ) ) -2

DAY ,  '%m-%d-%Y' ) and  

DATE_FORMAT( (

CURDATE( ) - INTERVAL DAYOFWEEK( CURDATE( ) ) -2

DAY ) + INTERVAL 6 

DAY ,  '%m-%d-%Y'

) and `user`.`user_id`=".$userrow->user_id." group by `assign_role_date`.`user_id` order by `user`.`name` asc";



$fixedresult=$this->user_model->use_query($query);

$weeklyuserid=$userrow->user_id;

if(count($fixedresult))
{
   $object= json_decode($fixedresult[0]->startdate);

   $startdatetime=$object->startdatetime;
   $object= json_decode($fixedresult[0]->enddate);
   $enddatetime=$object->enddatetime;
   $weeklyusername=$fixedresult[0]->name;

   $totalfixedjob=$fixedresult[0]->fixedjob;

   $weeklyusertotal_fixed_amount=round($fixedresult[0]->total_amount,2);

   $weeklyuserfixedamount=round($fixedresult[0]->total_amount,2);

}

else

{

   $weeklyusername=$userrow->name;

   $totalfixedjob=0;

   $weeklyusertotal_fixed_amount="00.00";

   $weeklyuserfixedamount="00.00";

}

   $hourlyresult=$this->weeklyhourlyamount($userrow->user_id);

   

    if(count($hourlyresult))

    {



    //$gethourlyamout=$this->user_model->use_query("select (prices/60) as amount from hourly_prices where user_type='".$userrow->occupation."'");

	$totalhourlyjob=$hourlyresult[0]->weeklyhourlyjob;

	$totalhourlytime=$hourlyresult[0]->HOUR.":".$hourlyresult[0]->MINUTES;

    $weeklyusertotal_hourly_amount=round(($hourlyresult[0]->TOTAL_AMOUNT),2);

    $weeklyusertotal_amount=round(($weeklyusertotal_hourly_amount+$weeklyuserfixedamount),2);

   }else

   {

        $weeklyusertotal_hourly_amount="00.00";

	    $totalhourlyjob=0;

		$totalhourlytime="00:00";

    $weeklyusertotal_amount=round(($weeklyusertotal_hourly_amount+$weeklyuserfixedamount),2);

   }				

				

$result[]=array("user_id"=>$weeklyuserid,"user_name"=>$weeklyusername,"totalfixedjob"=>$totalfixedjob,"total_fixed_amount"=>$weeklyusertotal_fixed_amount,"totalhourlyjob"=>$totalhourlyjob,"totaltime"=>$totalhourlytime,"total_hourly_amount"=>$weeklyusertotal_hourly_amount,"total_amount"=>$weeklyusertotal_amount);				

    }

				

     }

	else

	{

if($choosetype=="next")

{

            $data["startenddate"]=$this->user_model->use_query("select DATE_FORMAT('".$choosedate."', '%m-%d-%Y' ) as start_date,DATE_FORMAT( 

'".$choosedate."' + INTERVAL 6 

DAY ,  '%m-%d-%Y'

) as end_date");



        $users="select `user`.`name`,`user`.`user_id`,`user`.`occupation` from `user`";

        $userresult=$this->user_model->use_query($users);

foreach($userresult as $userrow)

{

      $query="select count(`assign_role_date`.`user_id`) as fixedjob,`user`.`name`,sum(`assign_role_date`.`role_amount`) as total_amount from `assign_role_date` inner join `user` on `assign_role_date`.`user_id`=`user`.`user_id` inner join `roles` on `assign_role_date`.`role_id`=`roles`.`role_id` inner join `geolocation` on `assign_role_date`.`id`=`geolocation`.`assign_task_id` where `geolocation`.`status`='done' and DATE_FORMAT( STR_TO_DATE(  `assign_role_date`.`assign_date` , '%m-%d-%Y' ) ,  '%m-%d-%Y' ) between

DATE_FORMAT( '".$choosedate."' - INTERVAL 0 DAY,  '%m-%d-%Y' ) and  

DATE_FORMAT('".$choosedate."'  + INTERVAL 6 DAY ,  '%m-%d-%Y') and `user`.`user_id`=".$userrow->user_id." group by `assign_role_date`.`user_id` order by `user`.`name` asc limit 0,100";





$fixedresult=$this->user_model->use_query($query);

$weeklyuserid=$userrow->user_id;

if(count($fixedresult))

{

   $weeklyusername=$fixedresult[0]->name;

   $totalfixedjob=$fixedresult[0]->fixedjob;

   $weeklyusertotal_fixed_amount=round($fixedresult[0]->total_amount,2);

   $weeklyuserfixedamount=round($fixedresult[0]->total_amount,2);

}

else

{

   $weeklyusername=$userrow->name;

   $totalfixedjob=0;

   $weeklyusertotal_fixed_amount="00.00";

   $weeklyuserfixedamount="00.00";

}

   $hourlyresult=$this->weeklyhourlyamount($userrow->user_id);



   if(count($hourlyresult))

   {



    //$gethourlyamout=$this->user_model->use_query("select (prices/60) as amount from hourly_prices where user_type='".$userrow->occupation."'");

    $weeklyusertotal_hourly_amount=round($hourlyresult[0]->TOTAL_AMOUNT,2);

    $weeklyusertotal_amount=round(($weeklyusertotal_hourly_amount+$weeklyuserfixedamount),2);

	$totalhourlyjob=$hourlyresult[0]->weeklyhourlyjob;

	$totalhourlytime=$hourlyresult[0]->HOUR.":".$hourlyresult[0]->MINUTES;

   }else

   {

    $weeklyusertotal_hourly_amount="00.00";

    $totalhourlyjob=0;

	$totalhourlytime="00:00";

    $weeklyusertotal_amount=round(($weeklyusertotal_hourly_amount+$weeklyuserfixedamount),2);

   }				

				

$result[]=array("user_id"=>$weeklyuserid,"user_name"=>$weeklyusername,"totalfixedjob"=>$totalfixedjob,"total_fixed_amount"=>$weeklyusertotal_fixed_amount,"totalhourlyjob"=>$totalhourlyjob,"totaltime"=>$totalhourlytime,"total_hourly_amount"=>$weeklyusertotal_hourly_amount,"total_amount"=>$weeklyusertotal_amount);				

  }

}

else if($choosetype=="prev")

{

$data["startenddate"]=$this->user_model->use_query("select DATE_FORMAT( 

'".$choosedate."' - INTERVAL 6 

DAY ,  '%m-%d-%Y'

) as start_date,DATE_FORMAT('".$choosedate."', '%m-%d-%Y' ) as end_date");



       $users="select `user`.`name`,`user`.`user_id`,`user`.`occupation` from `user` order by `user`.`name` asc";

        $userresult=$this->user_model->use_query($users);

    foreach($userresult as $userrow)

    {



      $query="select count(`assign_role_date`.`user_id`) as fixedjob,`user`.`name`,sum(`assign_role_date`.`role_amount`) as total_amount from `assign_role_date` inner join `user` on `assign_role_date`.`user_id`=`user`.`user_id` inner join `roles` on `assign_role_date`.`role_id`=`roles`.`role_id` inner join `geolocation` on `assign_role_date`.`id`=`geolocation`.`assign_task_id` where `geolocation`.`status`='done' and DATE_FORMAT( STR_TO_DATE(  `assign_role_date`.`assign_date`, '%m-%d-%Y' ), '%m-%d-%Y' ) between

DATE_FORMAT('".$choosedate."' - INTERVAL 6 DAY, '%m-%d-%Y') and  DATE_FORMAT('".$choosedate."' + INTERVAL 0 DAY,'%m-%d-%Y') and `user`.`user_id`=".$userrow->user_id." group by `assign_role_date`.`user_id`  order by `user`.`name` asc limit 0,100";



	$fixedresult=$this->user_model->use_query($query);

	

	$weeklyuserid=$userrow->user_id;

	if(count($fixedresult))

	{

	   $weeklyusername=$fixedresult[0]->name;

	   $totalfixedjob=$fixedresult[0]->fixedjob;

	   $weeklyusertotal_fixed_amount=round($fixedresult[0]->total_amount,2);

	   $weeklyuserfixedamount=round($fixedresult[0]->total_amount,2);

	}

	else

	{

	   $weeklyusername=$userrow->name;

	   $totalfixedjob=0;

	   $weeklyusertotal_fixed_amount="00.00";

	   $weeklyuserfixedamount="00.00";

	}

   $hourlyresult=$this->weeklyhourlyamount($userrow->user_id);

   

   if(count($hourlyresult))

   {



    //$gethourlyamout=$this->user_model->use_query("select (prices/60) as amount from hourly_prices where user_type='".$userrow->occupation."'");

	

	$totalhourlyjob=$hourlyresult[0]->weeklyhourlyjob;

	$totalhourlytime=$hourlyresult[0]->HOUR.":".$hourlyresult[0]->MINUTES;

    $weeklyusertotal_hourly_amount=round($hourlyresult[0]->TOTAL_AMOUNT,2);

    $weeklyusertotal_amount=round(($weeklyusertotal_hourly_amount+$weeklyuserfixedamount),2);

   }else

   {

    $weeklyusertotal_hourly_amount="00.00";

	    $totalhourlyjob=0;

	$totalhourlytime="00:00";

    $weeklyusertotal_amount=round(($weeklyusertotal_hourly_amount+$weeklyuserfixedamount),2);

   }				

				

$result[]=array("user_id"=>$weeklyuserid,"user_name"=>$weeklyusername,"totalfixedjob"=>$totalfixedjob,"total_fixed_amount"=>$weeklyusertotal_fixed_amount,"totalhourlyjob"=>$totalhourlyjob,"totaltime"=>$totalhourlytime,"total_hourly_amount"=>$weeklyusertotal_hourly_amount,"total_amount"=>$weeklyusertotal_amount);				



     }

	     }

}

$start_date=	trim($data['startenddate'][0]->start_date);

$end_date=trim($data['startenddate'][0]->end_date);



$data["nextprevdate"]=$this->user_model->use_query("SELECT STR_TO_DATE('".$start_date."' ,'%m-%d-%Y' ) - INTERVAL 1 

DAY as prevdate,STR_TO_DATE('".$end_date."' ,'%m-%d-%Y' ) + INTERVAL 1 

DAY as nextdate");

            $data["weeklyamount"]=$result;

            $username= $this->user_model->use_query("select user_id,name,email from user");
			$getname=array();
			foreach($username as $row){$getname[$row->user_id]=$row->name;}
			$data["username"]=$getname;
			$this->load->view('admin/weeklyamount',$data); 

			$this->load->view('admin/footer');

      }else

	  {

	  

	       redirect('/admin','refresh');		 

	  }
	}

	public function weeklyassign()

	{

	     if($this->checksession()==1)

		 {

		    $getid= $this->session->userdata('adminid');

		    $data=array('id'=>$getid);

		    $userdata["admininfo"]=$this->user_model->get_info('admin',$data);



		    $userdata["name"]=$userdata["admininfo"][0]->name;

		    $userdata["activeurl"]="weeklyassign";

	        $this->load->view('admin/header',$userdata); 

			$choosedate='';

			$choosetype='';

			if($_POST)

			{

			

$choosedate=(isset($_POST["prevhidden"])?$this->input->post("prevhidden"):(isset($_POST["nexthidden"])?$this->input->post("nexthidden"):''));



			}

			if(empty($choosedate))

			{
//$result=$this->user_model->use_query("select DAYOFWEEK( CURDATE( )) as daynum,CURDATE( )");
//print_r($result);die;
		 $day_of_week = date('N', strtotime(date('d-m-Y')));
		// echo date('d-m-Y')."--".$day_of_week;die;   
			if($day_of_week==7)
			{

			$data["startenddate"]=$this->user_model->use_query("select  DATE_FORMAT( CURDATE( ) - INTERVAL 7 -1

DAY ,  '%m-%d-%Y' ) as start_date,DATE_FORMAT( (

CURDATE( ) - INTERVAL 7 -1

DAY ) + INTERVAL 6 

DAY ,  '%m-%d-%Y'

) as end_date");
			
			}else
			{
			$data["startenddate"]=$this->user_model->use_query("select  DATE_FORMAT( CURDATE( ) - INTERVAL DAYOFWEEK( CURDATE( ) ) -2

DAY ,  '%m-%d-%Y' ) as start_date,DATE_FORMAT( (

CURDATE( ) - INTERVAL DAYOFWEEK( CURDATE( ) ) -2

DAY ) + INTERVAL 6 

DAY ,  '%m-%d-%Y'

) as end_date");
            }
            }

			else

			{

$choosetype=(isset($_POST["prevhidden"])?'prev':(isset($_POST["nexthidden"])?'next':''));

			

			if($choosetype=="next")

			{

			$data["startenddate"]=$this->user_model->use_query("select DATE_FORMAT('".$choosedate."' - INTERVAL DAYOFWEEK('".$choosedate."') -2

DAY ,  '%m-%d-%Y' ) as start_date,DATE_FORMAT( (

'".$choosedate."' - INTERVAL DAYOFWEEK( '".$choosedate."' ) -2

DAY ) + INTERVAL 6 

DAY ,  '%m-%d-%Y'

) as end_date");

			}else

			{

			$data["startenddate"]=$this->user_model->use_query("select DATE_FORMAT('".$choosedate."' - INTERVAL 6

DAY ,  '%m-%d-%Y' ) as start_date,DATE_FORMAT(('".$choosedate."' - INTERVAL 0 DAY ),  '%m-%d-%Y') as end_date");

			

			}

			}

            $data["roles"]=$this->user_model->getalldatawithorderby('`roles`.`role_id`,`roles`.`name`','`roles`','`roles`.`occupation`','asc');

		$start_date=	trim($data['startenddate'][0]->start_date);

		$end_date=trim($data['startenddate'][0]->end_date);

$data["choosedate"]=$choosedate;

$data["choosetype"]=$choosetype;



$data["nextprevdate"]=$this->user_model->use_query("SELECT STR_TO_DATE('".$start_date."' ,'%m-%d-%Y' ) - INTERVAL 1 

DAY as prevdate,STR_TO_DATE('".$end_date."' ,'%m-%d-%Y' ) + INTERVAL 1 

DAY as nextdate");

	        

			$this->load->view('admin/weeklyassign',$data); 

			$this->load->view('admin/footer');

		 }

		 else

		 {

		    redirect('/admin','refresh');		 

		 }

	    

	

	}

	public function companyedit($id=NULL)

	{

	   if($this->checksession()==1)

		{

	     $getid= $this->session->userdata('adminid');

		 $data=array('id'=>$getid);

		 $userdata["admininfo"]=$this->user_model->get_info('admin',$data);

         $userdata["name"]=$userdata["admininfo"][0]->name;

		 $this->load->view('admin/header',$userdata);

		if($_POST)

		{

		 $this->editcomapnylog();

		 $data["companyid"]=$this->input->post('companyid');

		}

		else

		{

		 $data["companyinfo"]=$this->user_model->getdatawithcondition("id,name,email,address,phone_number,ab_number,ac_number,description","company",array("id"=>$id));

		 $data["companyid"]=$id;

		}

		$this->load->view('admin/companyedit',$data);

		

		$this->load->view('admin/footer');

		}

		else

		{

        		redirect('/admin','refresh');		

		}

	}

	public function editrole($id=NULL)

	{

	    

		if($this->checksession()==1)

		{

	     $getid= $this->session->userdata('adminid');

		 $data=array('id'=>$getid);

		 $userdata["admininfo"]=$this->user_model->get_info('admin',$data);

         $userdata["name"]=$userdata["admininfo"][0]->name;

		 $this->load->view('admin/header',$userdata);

		if($_POST)

		{

		 $this->editrolelog();

		 $data["roleid"]=$this->input->post('roleid');

		}

		else

		{

		 $data["roleinfo"]=$this->user_model->getdatawithcondition("role_id,company_id,name,occupation","roles",array("role_id"=>$id));

		 $data["roleid"]=$id;

		}



		$companyname=$this->user_model->getalldatawithorderby("id,name","company","name","asc");

		$company=[];

		foreach($companyname as $row){$comapny[$row->id]=$row->name;}

		$data["company"]=$comapny;

		$this->load->view('admin/editrole',$data);

		

		$this->load->view('admin/footer');

		}

		else

		{

        		redirect('/admin','refresh');		

		}

	

	}

	public function edituser($id=NULL)

	{

	    if($this->checksession()==1)

		{

	     $getid= $this->session->userdata('adminid');

		 $data=array('id'=>$getid);

		 $userdata["admininfo"]=$this->user_model->get_info('admin',$data);

         $userdata["name"]=$userdata["admininfo"][0]->name;

		 $this->load->view('admin/header',$userdata);

		if($_POST)

		{

		 $this->edituserlog();

		 $data["userid"]=$this->input->post('userid');

		}

		else

		{

		 $data["userinfo"]=$this->user_model->getdatawithcondition("user_id,name,license_number,mobile,email,bsb,acc,occupation,fix_amount","user",array("user_id"=>$id));

		 $data["userid"]=$id;

		}

		$this->load->view('admin/edituser',$data);

		

		$this->load->view('admin/footer');

		}

		else

		{

        		redirect('/admin','refresh');		

		}

	

	}

	public function displayusers()

	{

	

	   if($this->checksession()==1)

		{

		$getpaginationlink=$this->pagination("admin/displayusers","user",25);

		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;



		$getid= $this->session->userdata('adminid');

		$data=array('id'=>$getid);

		$userdata["admininfo"]=$this->user_model->get_info('admin',$data);



		$userdata["name"]=$userdata["admininfo"][0]->name;

		$userdata["activeurl"]="displayusers";

	    $this->load->view('admin/header',$userdata);
        
		$data["users"]=$this->user_model->getalldatawithorder('user_id,name,license_number,mobile,email,bsb,acc,occupation,imagename','user','name', 'asc',25, $page);
		
		$data["links"] = $getpaginationlink;

		

		$this->load->view('admin/displayusers',$data);

		$this->load->view('admin/footer');

		}

		else

		{

		redirect('/admin','refresh');

		}

	

	}

    public function index()

    {



	 if($_POST)

	 {

	      if($this->input->post("submitbut")=="Sign In")

		  {

		     $getdata= $this->adminlog();

			 

		     if(!empty($getdata))

			 {

			 $data["logerror"]=$getdata;

             $this->load->view('admin/login',$data);

			 }else

			 {

			 redirect('/admin/dashboard','refresh');



			 }

		  }

	  }

	  else

	  {

		 if($this->checksession()==1)

		 redirect('/admin/dashboard','refresh');

		 else

		 $this->load->view('admin/login');    

		

	  }

   }

  public function checksession()

  {



	  $getid= $this->session->userdata('adminid');

	  return (empty($getid)?0:1);

  }

 public function dashboard()

 {



        if($this->checksession()==1)

		{  

		$getid= $this->session->userdata('adminid');

		$data=array('id'=>$getid);

		$userdata["admininfo"]=$this->user_model->get_info('admin',$data);



		$userdata["name"]=$userdata["admininfo"][0]->name;

	    $this->load->view('admin/header',$userdata);

		$this->load->view('admin/dashboard');

		$this->load->view('admin/footer');

		}

		else

		{

		redirect('/admin','refresh');

		}

 }

 public function adduser()

 {

     if($this->checksession()==1)

		{

		$getid= $this->session->userdata('adminid');

		$data=array('id'=>$getid);

		$userdata["admininfo"]=$this->user_model->get_info('admin',$data);



		$userdata["name"]=$userdata["admininfo"][0]->name;

		$userdata["activeurl"]="user";

	    $this->load->view('admin/header',$userdata);

		if($_POST)

		{

		 $this->userlog();

		}

		else

		{

		

		$this->load->view('admin/adduser');

		}

		$this->load->view('admin/footer');

		

		}else

		{

		redirect('/admin','refresh');

		}

 

 }

 public function addcompany()

	{

      	    if($this->checksession()==1)

		    {

				$getid= $this->session->userdata('adminid');

				$data=array('id'=>$getid);

				$userdata["admininfo"]=$this->user_model->get_info('admin',$data);

		

				$userdata["name"]=$userdata["admininfo"][0]->name;

				$userdata["activeurl"]="addcompany";

				$this->load->view('admin/header',$userdata);

				if($_POST)

				{

				$this->companylog();

				}

				$this->load->view('admin/addcompany');

			    $this->load->view('admin/footer');

            }

			else

			{

			   redirect('/admin','refresh');

			}	  

	  	

	}

}



?>