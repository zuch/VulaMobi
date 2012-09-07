<?php

/* Sascha Watermeyer - WTRSAS001
 * Vulamobi CS Honours project
 * sascha.watermeyer@gmail.com */

include_once 'simple_html_dom.php';

class Gallery extends CI_Controller 
{
    public function __construct() 
    {
        parent::__construct();
    }
    
    public function Gallery() 
    {
        //show_404();
    }
    
    public function dir()
    {
        if($this->session->userdata('logged_in'))
        {
            $username = $this->session->userdata('username');       

            //Globals
            $base_url = "http://people.cs.uct.ac.za/~swatermeyer/VulaMobi/uploads/";
            $dir = "./uploads/" . $username;
            $images = array();
            
            // Open a known directory, and proceed to read its contents
            if (is_dir($dir)) 
            {
                if ($dh = opendir($dir)) 
                {
                    while (($filename = readdir($dh)) !== false) 
                    {
                        //echo "filename: " . $filename ."</br>";
                        if(($filename != ".") && ($filename != ".."))
                        {
                            $image = array('filename' => $filename
                                          ,'url' => $base_url . $filename );
                            $images[] = $image;
                        }
                    }
                    echo json_encode($images);
                    closedir($dh);
                }
            }
            else
            {
                echo "error";
            }
        }
        else//NOT logged in
        {
            $this->session->sess_destroy();
            echo 'logged_out';
        }
    }
    
    //upload image to uploads/user_id
    public function upload()
    {
        if($this->session->userdata('logged_in'))
        {   
            $username = $this->session->userdata('username');
            
            $path = getcwd();

            $upload_path = $path . '/uploads/' . $username . "/";

            echo $upload_path;

            if(isset($_REQUEST['image']))
            {
                if ($_REQUEST['image']) 
                {
                    $imgData = base64_decode($_REQUEST['image']);

                    $file = $upload_path . date('Ymdgisu') . '.jpg';
                    if (file_exists($file))
                    {
                        unlink($file);
                    }
                    error_log("Error to check if file exists");
                    $fp = fopen($file, 'w');
                    fwrite($fp, $imgData);
                    fclose($fp);
                }
            }
            else
            {
                echo "</br>";
                echo "not set";
            }
        }
        else//NOT logged in
        {
            $this->session->sess_destroy();
            echo 'logged_out';
        }
    }
}

?>
