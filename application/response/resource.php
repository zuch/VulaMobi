<?php

/* Sascha Watermeyer - WTRSAS001
 * Vulamobi CS Honours project
 * sascha.watermeyer@gmail.com */

header('Access-Control-Allow-Origin: *');  

include_once 'simple_html_dom.php';

//globals
$resources = array();

class Resource extends CI_Controller 
{
    public function __construct() 
    {
        parent::__construct();
    }
    
    public function Resource() 
    {
        //show_404();
    }
    
    //get roster for a Course
    public function site($site_id)
    {   
        echo "yo";
        $this->login();

        //$site_id = $this->input->post('site_id');        
        $this->getResource($site_id);

        //output
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(array('resources' => $resources)));  
    }
    
    public function getResource($site_id)
    {
        $cookie = $this->session->userdata('cookie');
        $cookiepath = realpath($cookie);

        $base = "https://vula.uct.ac.za/access/content/group/";
        $url = $base . $site_id;

        //eat cookie..yum
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_COOKIEFILE, $cookiepath);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);

        $response = curl_exec($curl);

        //create html dom object
        $html_str = str_get_html($response);
        $html = new simple_html_dom($html_str);

        if (($li = $html->find('ul li')) != null) 
        {
            foreach($li as $val)
            {
                if($val->class == "folder")
                {
                    $this->getResource($site_id . "/". $val->children(0)->href);
                    /*$folder = array('type' => "folder",
                                    'text' => $val->children(0)->innertext,
                                    'onclick' => "resource('". $site_id ."/". $val->children(0)->href ."');");
                    $resources[] = $folder;*/
                }
                if($val->class == "file")
                {
                    $file= array('type' => "file",
                                 'text' => $val->children(0)->innertext,
                                 'href' => $base . $val->children(0)->href );
                    $resources[] = $file;
                }
            }
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
