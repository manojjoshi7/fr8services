<?php
echo "testing";die;
session_start();
if(!isset($_SESSION["userid"]))
{
$_SESSION["userid"]=session_id();
}

if($_POST)
{
  $obj=new db();
  if($_POST["process"]=="start")
  {
  $obj->insertdata($_POST["stepnum"]);
  echo $obj->getFieldInfo($_POST["stepnum"]);
  }
 
}
class db
{
private $con;
public function db()
{
error_reporting(0);
$this->con = new PDO('mysql:host=localhost;dbname=aui;charset=utf8', 'joshi', 'J6RonyAQb6HB');
$this->con->exec("SET CHARACTER SET utf8");      // Sets encoding UTF-8
$this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}  
public function getFieldInfo($form_num)
{
     try
	  {
	  
		 $sql="SELECT `id` as result FROM user_servay WHERE `user_id`= :user_id and form_num=:form_num";
		 
		 $qry = $this->con->prepare($sql);
		 $qry ->bindValue(':user_id', $_SESSION["userid"],PDO::PARAM_STR);
		 $qry ->bindValue(':form_num', $form_num,PDO::PARAM_INT);
		 $qry ->execute();
		 $row = $qry->fetch();
	    return $row["id"];
	  }
	  catch(PDOException $e)
	  {
	        $code = $e->getCode();
            $file = $e->getFile();
            $line = $e->getLine();
            $msg  = $e->getMessage();
            echo "$file:$line ERRNO:$code ERROR:$msg";
	  }


}
public function insertdata($num)
{
      
     try
	  {
	 $statement = $this->con->prepare("INSERT INTO  user_servay(user_id, start_date_time,form_num)
    VALUES(:user_id, :start_date_time,:form_num)");
$statement->execute(array(
    "user_id" => $_SESSION["userid"],
    "start_date_time" =>date('d-m-Y H:i:s'),
	"form_num"=>$num

));
    }
	catch(PDOException $e)
	  {
	        $code = $e->getCode();
            $file = $e->getFile();
            $line = $e->getLine();
            $msg  = $e->getMessage();
            echo "$file:$line ERRNO:$code ERROR:$msg";
	  }
}

}
?>