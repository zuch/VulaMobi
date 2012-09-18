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
        $dir = "./uploads/" . $username . "/";
        $files = array();
        
        if (is_dir($dir)) 
        {
            $dh = opendir($dir);
            $files = array();

            while (($file = readdir($dh)) !== false) 
            {
                if ($file != '.' AND $file != '..')
                {
                    if (filetype($dir . $file) == 'file') 
                    {
                        $files[] = array(
                            'name' => $file,
                            'size' => filesize($dir . $file) . ' bytes',
                            'date' => date("F d Y H:i:s", filemtime($dir . $file)),
                            'path' => $dir . $file,
                        );
                    }
                }
            }
        } 
        else 
        {
            echo "empty";
        }
        closedir($dh);

        $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode(array('files' => $files)));
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
                
                echo "complete";
            }
        } 
        else 
        {
            echo "no POST";
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
