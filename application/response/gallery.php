<?php

/* Sascha Watermeyer - WTRSAS001
 * Vulamobi CS Honours project
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

    public function dir() 
    {
        $this->login();
        
        $username = $this->session->userdata('username');
        
        //Globals
        $base_url = 'http://people.cs.uct.ac.za/~swatermeyer/VulaMobi/';
        $dir = "uploads/" . $username . "/";
        $upload_path = $base_url . $dir;
        
        if (!is_dir($upload_path)) 
        {
             mkdir($upload_path, 0777);
        }
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
            //echo(json_encode(array('files'=> $files)));
        }
    }

    //upload image to uploads/user_id
    public function upload() 
    {
        $this->login();
        
        $username = $this->session->userdata('username');

        $path = getcwd();
        //echo $path;

        $upload_path = $path . "/uploads/" . $username . "/";

        if (!is_dir($upload_path)) 
        {
             mkdir($upload_path, 0777);
        }

        if (isset($_REQUEST['image'])) 
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
                
                //make_thumb($upload_path, $upload_path . "thumb/", 100);
                
                echo "complete";
            }
        } 
        else 
        {
            echo "no POST";
        }
        
        function make_thumb($src, $dest, $desired_width) {

	/* read the source image */
	$source_image = imagecreatefromjpeg($src);
	$width = imagesx($source_image);
	$height = imagesy($source_image);
	
	/* find the "desired height" of this thumbnail, relative to the desired width  */
	$desired_height = floor($height * ($desired_width / $width));
	
	/* create a new, "virtual" image */
	$virtual_image = imagecreatetruecolor($desired_width, $desired_height);
	
	/* copy source image at a resized size */
	imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);
	
	/* create the physical thumbnail image to its destination */
	imagejpeg($virtual_image, $dest);
        }

        /*
                Function createthumb($name,$filename,$new_w,$new_h)
                creates a resized image
                variables:
                $name		Original filename
                $filename	Filename of the resized image
                $new_w		width of resized image
                $new_h		height of resized image
        */	
        function createthumb($name,$filename,$new_w,$new_h)
        {
            $system=explode(".",$name);
            if (preg_match("/jpg|jpeg/",$system[1])){$src_img=imagecreatefromjpeg($name);}
            if (preg_match("/png/",$system[1])){$src_img=imagecreatefrompng($name);}
            $old_x=imageSX($src_img);
            $old_y=imageSY($src_img);
            if ($old_x > $old_y) 
            {
                    $thumb_w=$new_w;
                    $thumb_h=$old_y*($new_h/$old_x);
            }
            if ($old_x < $old_y) 
            {
                    $thumb_w=$old_x*($new_w/$old_y);
                    $thumb_h=$new_h;
            }
            if ($old_x == $old_y) 
            {
                    $thumb_w=$new_w;
                    $thumb_h=$new_h;
            }
            $dst_img=ImageCreateTrueColor($thumb_w,$thumb_h);
            imagecopyresampled($dst_img,$src_img,0,0,0,0,$thumb_w,$thumb_h,$old_x,$old_y); 
            if (preg_match("/png/",$system[1]))
            {
                    imagepng($dst_img,$filename); 
            } else {
                    imagejpeg($dst_img,$filename); 
            }
            imagedestroy($dst_img); 
            imagedestroy($src_img); 
        }
        
        
        function createThumbs( $pathToImages, $pathToThumbs, $thumbWidth )
        {
          // open the directory
          $dir = opendir( $pathToImages );

          // loop through it, looking for any/all JPG files:
          while (false !== ($fname = readdir( $dir ))) {
            // parse path for the extension
            $info = pathinfo($pathToImages . $fname);
            // continue only if this is a JPEG image
            if ( strtolower($info['extension']) == 'jpg' )
            {
              echo "Creating thumbnail for {$fname} <br />";

              // load image and get image size
              $img = imagecreatefromjpeg( "{$pathToImages}{$fname}" );
              $width = imagesx( $img );
              $height = imagesy( $img );

              // calculate thumbnail size
              $new_width = $thumbWidth;
              $new_height = floor( $height * ( $thumbWidth / $width ) );

              // create a new temporary image
              $tmp_img = imagecreatetruecolor( $new_width, $new_height );

              // copy and resize old image into new image
              imagecopyresized( $tmp_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height );

              // save thumbnail into a file
              imagejpeg( $tmp_img, "{$pathToThumbs}{$fname}" );
            }
          }
          // close the directory
          closedir( $dir );
        }        
    }
    
    //login Vula
    public function login() 
    { 
       //$username = urldecode($this->uri->segment(2, 0));
       // $password = urldecode($this->uri->segment(3, 0));
       
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
