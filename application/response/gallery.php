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
        $base_url = 'http://people.cs.uct.ac.za/~swaatermeyer/VulaMobi';
        $dir = "./uploads/" . $username . "/";
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
                                'path' => $base_url.$dir .$file,
                                'thumb'=> $base_url.$dir .'thumbs/thumb_'.$file
                        );
                    }
                }
            }
            closedir($dh);
        
        echo(json_encode(array('files'=> $files)));
        
        } 
        else 
        {
            mkdir($dir, 0700);
        }
    }

    //upload image to uploads/user_id
    public function upload() 
    {
        $this->login();
        
        $username = $this->session->userdata('username');

        //$path = getcwd();

        $upload_path = "./uploads/" . $username . "/";

        //create path for user if not initialised
        if (!is_dir($upload_path)) 
        {
            mkdir($upload_path, 0700);
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
                
                createThumbs($upload_path,$upload_path + "thumbs/",100);
                
                echo "complete";
            }
        } 
        else 
        {
            echo "no POST";
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
