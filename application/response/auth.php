<?php

/* Sascha Watermeyer - WTRSAS001
 * Vulamobi CS Honours project
 * sascha.watermeyer@gmail.com */

header('Access-Control-Allow-Origin: *');  

class Auth extends CI_Controller 
{

    public function __construct() 
    {
        parent::__construct();
    }

    public function Auth()
    {
        echo "logged_out";
        die;
    }
    
    public function index() 
    {
        echo 'logged_out';
        die;
    }
    
    //login Vula
    public function login() 
    {
        
        //include_once 'login.php';

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
            echo "empty";
            die;
        }

        $auth = array(
            'eid' => $username,
            'pw' => $password,
        );

        $url = "https://vula.uct.ac.za/authn/login";

        //returns random num from 10000 - 99999
        function salt()
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

        $cookie = tempnam ("/tmp", md5($username . salt()));

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
            echo "logged_in";
            die;
        }
        else
        {
            echo "incorrect";
            die;
        }
     
    }
    
    //logout Vula
    public function logout() 
    {
        $this->session->sess_destroy();
        echo 'logged_out';
        die;
    }
}

?>
