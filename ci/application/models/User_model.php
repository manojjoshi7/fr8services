<?php

 if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model

{

 var $table = "admin";

function __construct() 

{

parent::__construct();



}
/*

public function sendemil($formemail,$toemail,$username,$subject,$message)

{



	 $config = array(

         'protocol' =>'smtp',

         'smtp_host' =>'smtp.googlemail.com',

         'smtp_port' =>'465',

		 'smtp_user' =>'manojjoshi.joshi@gmail.com',

         'smtp_pass' =>'gmail@lee@123',

         'mailtype'  =>'text', 

         'charset'   =>'utf-8');

         $this->load->library('email', $config);

         $this->email->set_newline("\r\n");

         $this->email->set_crlf("\r\n" );

         $this->email->from('manojjoshi.joshi@gmail.com', 'manoj joshi');

         $this->email->to('manojjoshi574@yahoo.in');



         $this->email->subject('Account varification mail');

         $this->email->message('hi manoj'); 





        $result = $this->email->send();

	 //mail('manojjoshi.joshi@gmail.com',"test test","welcome");

	echo $this->email->print_debugger();

		 die;





}*/



public function sendemil($formemail,$toemail,$username,$subject,$message)

{

    

	

	     $config = array(

         'protocol' => 'sendmail',

         'smtp_host' => 'mail.fr8services.com.au',

         'smtp_port' => '25',

         'smtp_user' => 'jagroop@fr8services.com.au',

         'smtp_pass' => 'Jagroop@123',

         'mailtype'  => 'html', 

		 'starttls'  => true,

         'charset'   => 'iso-8859-1',

		 'wordwrap' =>TRUE);

		 

         $this->load->library('email', $config);

         $this->email->set_newline("\r\n");

		 $this->email->set_crlf("\r\n" );

         $this->email->from($formemail, $username);

         $this->email->to($toemail);

		 $this->email->subject($subject);

		 $data["message"]=$message;

         $body=$this->load->view('email/sendemail.php',$data,TRUE);

		 

         $this->email->message($body); 

		 $result = $this->email->send();

		//echo $this->email->print_debugger();

		//echo $result;

		 //die;

}

public function send_active_message($userName,$email,$id,$random_num)

	{

	 $config = array(

         'protocol' => 'sendmail',

         'smtp_host' => 'mail.fr8services.com.au',

         'smtp_port' => '25',

         'smtp_user' => 'jagroop@fr8services.com.au',

         'smtp_pass' => 'Jagroop@123',

         'mailtype'  => 'html', 

         'charset'   => 'iso-8859-1',

		 'wordwrap' =>TRUE);

         $this->load->library('email', $config);

         $this->email->set_newline("\r\n");

         $this->email->from('jagroop1989@fr8services.com.au', 'jagroop');

         $this->email->to($email);

         $data["userName"]=$userName;

		 $data["id"]=$id;

		 

		 $data["token"]=$random_num;

         $this->email->subject('Account varification mail');

		 $body=$this->load->view('email/email_active.php',$data,TRUE);

         $this->email->message($body); 

         $result = $this->email->send();

		 

}

public function send_email_forchangeemail($userName,$email,$id,$random_num)

{

        	 $config = array(

         'protocol' => 'sendmail',

         'smtp_host' => 'mail.fr8services.com.au',

         'smtp_port' => '25',

         'smtp_user' => 'jagroop@fr8services.com.au',

         'smtp_pass' => 'Jagroop@123',

         'mailtype'  => 'html', 

         'charset'   => 'iso-8859-1',

		 'wordwrap' =>TRUE);

         $this->load->library('email', $config);

         $this->email->set_newline("\r\n");

         $this->email->from('jagroop1989@fr8services.com.au', 'jagroop');

         $this->email->to($email);

         $data["userName"]=$userName;

         $data["id"]=$id;

		 $data["token"]=$random_num;

         $this->email->subject('For Email Varification');

		 $body=$this->load->view('email/changeemail.php',$data,TRUE);

         $this->email->message($body); 

         $result = $this->email->send();

		 



}



public function send_email_forgetpassword($userName,$email,$password)

{

         $config = array(

         'protocol' => 'sendmail',

         'smtp_host' => 'mail.fr8services.com.au',

         'smtp_port' => '25',

         'smtp_user' => 'jagroop@fr8services.com.au',

         'smtp_pass' => 'Jagroop@123',

         'mailtype'  => 'html', 

         'charset'   => 'iso-8859-1',

		 'wordwrap' =>TRUE);

         $this->load->library('email', $config);

         $this->email->set_newline("\r\n");

         $this->email->from('jagroop1989@fr8services.com.au', 'jagroop');

		 

		 $this->email->to($email);

         $data["userName"]=$userName;

         $data["password"]=$password;

         $this->email->subject('Forget password mail');

		 $body=$this->load->view('email/forgetpassword.php',$data,TRUE);

         $this->email->message($body); 

         $result = $this->email->send();

		 		

}

public function runquery($query)

{



$qry_res =  $this->db->query($query);

$res = $qry_res->result_array();

$qry_res->next_result();

$qry_res->free_result();

return $res;

}

public function preventdata($query,$condition)

{

return $this->db->query($query,$condition)->result();

}

public function use_query($query)
{
return $this->db->query($query)->result();

}

public function get_max($field_name,$tablename)

{



 $query=  $this->db->select_max($field_name)->get($tablename)->result();

return $query[0]->$field_name;

}

public function getdatawithconditionwith_limit($fieldname,$tablename,$condition,$limit, $start)

{

$result=$this->db->select($fieldname)->from($tablename)->where($condition)->limit($limit, $start)->get()->result();

return $result;

}



public function three_table_join_with_condition($selectdata,$tablename1,$tablename2,$tablename3,$condition1,$type1,$condition2,$type2,$wherecondition,$orderfield, $order,$limit, $start)

{

    $this->db->select($selectdata);

    $this->db->from($tablename1);

	$this->db->join($tablename2, $condition1, $type1);

	if($wherecondition=="null")

	{

    $this->db->join($tablename3, $condition2, $type2)->order_by($orderfield, $order)->limit($limit, $start);

	}

	else

	{

	$this->db->join($tablename3, $condition2, $type2)->where($wherecondition)->order_by($orderfield, $order)->limit($limit, $start);

	}

    $getresult=$this->db->get()->result();

	return $getresult;

}

public function leftright_join_with_limit($selectdata,$tablename1,$tablename2,$condition,$type,$wherecondition,$limit, $start)

{

    $this->db->select($selectdata);

    $this->db->from($tablename1);

    $this->db->join($tablename2, $condition, $type)->where($wherecondition)->limit($limit, $start);

    $getresult=$this->db->get()->result();

	return $getresult;

}



public function leftright_join_without_condition($selectdata,$tablename1,$tablename2,$condition,$type,$limit, $start)

{

    $this->db->select($selectdata);

    $this->db->from($tablename1);

    $this->db->join($tablename2, $condition, $type)->limit($limit, $start);

    $getresult=$this->db->get()->result();

	return $getresult;

}



public function getdatawith_like_limit($fieldname,$tablename,$condition,$limit, $start)

{

$result=$this->db->select($fieldname)->from($tablename)->like($condition)->limit($limit, $start)->get()->result();

return $result;

}

public function getalldata($fieldname,$tablename,$limit, $start)

{

$result=$this->db->select($fieldname)->from($tablename)->limit($limit, $start)->get()->result();

return $result;

}

public function getalldatawithorder($fieldname,$tablename,$orderfield, $order,$limit, $start)

{

$result=$this->db->select($fieldname)->from($tablename)->order_by($orderfield, $order)->limit($limit, $start)->get()->result();

return $result;

}



public function getalldatawithorderby($fieldsname,$tablename,$fieldname,$order)

{

$result=$this->db->select($fieldsname)->from($tablename)->order_by($fieldname, $order)->get()->result();

return $result;

}



public function getdatawithcondition($fieldname,$tablename,$condition)

{

$result=$this->db->select($fieldname)->from($tablename)->where($condition)->get()->result();

return $result;

}
public function getdatawithconditionwithorder($fieldname,$tablename,$condition,$orderfieldname, $order)
{

$result=$this->db->select($fieldname)->from($tablename)->where($condition)->order_by($orderfieldname, $order)->get()->result();

return $result;

}

function data_insert($tablename,$data)
{

$this->db->insert($tablename, $data);

}

public function row_delete_with_othertable($tablename,$condision)

{

   $this->db->where($condision);

   $this->db->delete($tablename); 

}
function row_delete($condision)
{

   $this->db->where($condision);

   $this->db->delete($this->table); 

}

public function countresult($condition,$table)
{

 if(is_null($condition))

 $result = $this->db->count_all_results($table);

 else

 $result = $this->db->where($condition)->count_all_results($table);

 return $result;

}

public function  countresultuselike($condition,$table)
{

$result = $this->db->like($condition)->count_all_results($table);

return $result;

}
function has_record($tablename,$data)
{



    $query = $this->db->get_where($tablename, $data);

	$getresult=$query->result();

	

	return ($query->num_rows()!=0?$getresult[0]->id:0);

}  

public function get_info($tablename,$data)

{



    $query = $this->db->get_where($tablename, $data);

	$getresult=$query->result();

	return $getresult;

}



public function update_info($tablename,$field,$field_value,$data)

{

    $this->db->where($field, $field_value);

    $this->db->update($tablename, $data);

}

public function leftright_join($selectdata,$tablename1,$tablename2,$condition,$type,$fieldname,$fieldvalue)

{

    $this->db->select($selectdata);

    $this->db->from($tablename1);

    $this->db->join($tablename2, $condition, $type)->where($fieldname,$fieldvalue);

    $getresult=$this->db->get()->result();

	return $getresult;

} 

public function insert_data($tablename,$data)

{

   $this->db->insert($tablename,$data);

   $insert_id = $this->db->insert_id();

   return $insert_id;

} 

public function gettotalfromquery($query)

{

 $istotal=$this->db->query($query)->result();

 return $istotal[0]->total;

}

}





?>