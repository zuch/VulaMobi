<?php

/* Sascha Watermeyer - WTRSAS001
 * VulaMobi CS Honours project
 * sascha.watermeyer@gmail.com */

header('Access-Control-Allow-Origin: *');  

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

    //list directory of '/uploads' for user
    public function dir() 
    {
        $this->login();
        
        $username = $this->session->userdata('username');
        
        //Globals
        $base_url = 'http://people.cs.uct.ac.za/~swatermeyer/VulaMobi/';
        $dir = "uploads/" . $username . "/";
        $upload_path = $base_url . $dir;
        
        if (!is_dir($upload_path))
             mkdir($upload_path, 0777, true);
        if (!is_dir($upload_path . 'thumbs/'))
            mkdir($upload_path . 'thumbs/', 0777, true);
        
        $dh = opendir($dir);
        $files = array();
        
        if (is_dir($dir)) 
        {
            while(($file = readdir($dh)) !== false)
            {
                if($file != '.' AND $file != '..')
                {
                    $path_parts = pathinfo($dir. $file);
                    if(filetype($dir . $file) == 'file' AND ($path_parts['extension'] == 'jpg' OR 
                                                             $path_parts['extension'] == 'JPG')) 
                    {
                        $files[] = array (
                                'name' => $file,
                                'size' => filesize($dir. $file). ' bytes',
                                'date' => date( "F d Y H:i:s", filemtime($dir . $file)),
                                'path' => $base_url. $dir .$file,
                                'thumb'=> $base_url. $dir .'thumbs/thumb_'.$file
                        );
                    }
                }
            }
            closedir($dh);
        
            //output
            $this->output
                ->set_output(json_encode(array('files' => $files)));
        }
    }

    //upload image to uploads/user_id
    public function upload() 
    {
        $this->login();
        
        $username = $this->session->userdata('username');

        $path = getcwd();

        $upload_path = $path . "/uploads/" . $username . "/";

        if (!is_dir($upload_path))
             mkdir($upload_path, 0777, true);
        if (!is_dir($upload_path . 'thumbs/'))
            mkdir($upload_path . 'thumbs/', 0777, true);

        if (isset($_REQUEST['image'])) 
        {
            if ($_REQUEST['image']) 
            {
                //create full image
                $imgData = base64_decode($_REQUEST['image']);
                $filename = date('Ymdgisu') . '.jpg';
                $file = $upload_path . $filename;
                if (file_exists($file)) 
                {
                    unlink($file);
                }
                error_log("Error to check if file exists");
                $fp = fopen($file, 'w');
                fwrite($fp, $imgData); 
                fclose($fp);
                
                //create thumb nail
                $thumb_path = $upload_path . "thumbs/thumb_" . $filename;
                $tn_height = "100"; 
                $tn_width = "100";
                
                $src = @ImageCreateFromJpeg($file); 
                $dst = ImageCreateTrueColor($tn_width,$tn_height);
                list($width, $height) = getimagesize($file);
                ImageCopyResized($dst, $src, 0, 0, 0, 0, $tn_width,$tn_height,$width,$height);
                ImageJpeg($dst,$thumb_path);
                ImageDestroy($src);
                ImageDestroy($dst);
                
                echo "Image Uploaded";
            }
        } 
        else 
        {
            echo "no 'image' POST parameter";
        }    
    }
    
    //login Vula
    public function login() 
    {  
        $username = $this->input->post('username');
        $password = $this->input->post('password');        
        
        $credentials = array
        (
            'username' => $username,
            'password' => $password,
        );
        $this->session->set_userdata($credentials);

        //empty username or password
        if($username==null || $password==null)
        {
            echo "Empty Username or Password";;
            die;
        }

        $auth = array(
            'eid' => $username,
            'pw' => $password,
        );

        $url = "https://vula.uct.ac.za/portal/relogin";
        
        $cookie = tempnam ("/tmp", md5($username . $this->salt()));

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_COOKIEJAR, $cookie);
        curl_setopt($curl, CURLOPT_COOKIEFILE, $cookie);
        curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $auth);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);

        curl_exec($curl);
        $resultStatus = curl_getinfo($curl);

        if ($resultStatus['url'] == "https://vula.uct.ac.za/portal") //if redirected it means its logged in
        {
            $newdata = array(
                  'cookie' => $cookie,
                  'logged_in' => TRUE
              );
            $this->session->set_userdata($newdata);
        }
        else
        {
            echo $username."</br>";
            echo $password."</br>";
            echo "Incorrect Username or Password";
            die;
        } 
    }
    
    //returns random num from 10000 - 99999
    public function salt()
    {
        $found = false;
        while(!$found)
        {
            $x = rand(0, 99999);
            if($x < 10000)
                $x = rand(0, 99999);
            else $found = true;
        }
        return (string)$x;
    }
}

?>
