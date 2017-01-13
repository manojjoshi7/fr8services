<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Test extends CI_Controller 
{

    public function __construct() 
	{
	
	 parent::__construct();
	
    }
	public function uploadimage()
	{
	
      if(isset($_REQUEST['image']) && $_REQUEST['image'])
	  {
        $base=$_REQUEST['image'];
    // Get file name posted from Android App
    $filename = $_REQUEST['filename'];
    // Decode Image
    $binary=base64_decode($base);
    header('Content-Type: image/jpeg');
    // Images will be saved under 'www/imgupload/uplodedimages' folder
    $file = fopen('assets/uploadimage/'.$filename, 'wb');
    // Create File
    fwrite($file, $binary);
    fclose($file);
	$result["status"]=1;
	$result["message"]='Image upload complete';
    }
	else
	{
			   $result["status"]=0;
	           $result["message"]='upload image';
			  
	}
				  header('Content-type: application/json');
              echo json_encode($result);    
	}

}
?>