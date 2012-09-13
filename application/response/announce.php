<?php

/* Sascha Watermeyer - WTRSAS001
 * Vulamobi CS Honours project
 * sascha.watermeyer@gmail.com */

header('Access-Control-Allow-Origin: *');  

include_once 'simple_html_dom.php';

class Announce extends CI_Controller 
{
    public function __construct() 
    {
        parent::__construct();
    }
    
    public function Announce() 
    {
        //show_404();
    }
    
    //get grades of User for Course
    public function site($site_id)
    {
        $this->login();
        
        $cookie = $this->session->userdata('cookie');
        $cookiepath = realpath($cookie);

       
        $url_all = "https://vula.uct.ac.za/direct/announcement/user.xml?n=30&d=300";

        //eat cookie..yum
        $curl = curl_init($url_all);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_COOKIEFILE, $cookiepath);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);

        $response = curl_exec($curl);

        $xml = simplexml_load_string($response);

        $announcements = array();
        //$entityTitle = "";
        //$siteTitle = "";
        //$entityId = "";
                
        foreach ($xml->children() as $child) 
        {
            foreach ($child->children() as $minime) 
            {
               
                switch ($t = $minime->getName()) 
                {
                    case 'entityTitle':
                        $entityTitle = $minime;
                        break;
                    case 'entityId':
                        $entityId = $minime;
                        break;
                    case 'siteTitle':
                        $siteTitle = $minime;
                        break;
                    default :
                        break;
                }
            }
            $announcements[] = array('entityTitle' => $entityTitle,
                                     'id' => $entityId,
                                     'siteTitle' => $siteTitle,
                                     'onclick' => "one_announcement('". $entityId ."')");
        }

        //output
        echo json_encode(array('announcements' => $announcements));    
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
            echo "empty";
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
            echo "incorrect";
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
