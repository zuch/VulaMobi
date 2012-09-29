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
    public function all()
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
        $body = "";
        $createdByDisplayName = "";
        $createdOn = "";
        $siteTitle = "";
        $title = "";
        $entityURL = "";
                
        foreach ($xml->children() as $child) 
        {
            foreach ($child->children() as $minime) 
            {
                
                switch ($t = $minime->getName()) 
                {
                    case 'body':
                        $body = $minime;
                        break;
                    case 'createdByDisplayName'://Saved by
                        $createdByDisplayName = $minime;
                        break;
                    case 'createdOn':
                        foreach($minime[0]->attributes() as $a => $b) 
                        {
                           if($a == "date")
                            $createdOn =  $b;
                        }
                        break;
                    case 'siteTitle'://Site title
                        $siteTitle = $minime;
                        break;
                    case 'title'://subject
                        $title = $minime;
                        break;
                    case 'entityURL':
                        $entityURL = $minime;
                        break;
                    default :
                        break;
                }
                $announcements[] = array('body' => $body,
                                     'createdByDisplayName' => $createdByDisplayName,
                                     'createdOn' => $createdOn,
                                     'siteTitle' => $siteTitle,
                                     'title' => $title, 
                                     'entityURL' => $entityURL);
            }
        }
        //output
        $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode(array('announcements_all' => $announcements)));
    }
    
    public function site($site_id)
    {
        $this->login();
        
        $cookie = $this->session->userdata('cookie');
        $cookiepath = realpath($cookie);
        
        $url_tool = "https://vula.uct.ac.za/direct/announcement/site/" . $site_id . ".xml?n=30&d=300";

        //eat cookie..yum
        $curl = curl_init($url_tool);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_COOKIEFILE, $cookiepath);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);

        $response = curl_exec($curl);

        $xml = simplexml_load_string($response);

        $announcements = array();
        $body = "";
        $createdByDisplayName = "";
        $createdOn = "";
        $siteTitle = "";
        $title = "";
        $entityURL = "";

        foreach ($xml->children() as $child) 
        {
            foreach ($child->children() as $minime) 
            {
                switch ($t = $minime->getName()) 
                {
                    case 'body':
                        $body = $minime;
                        break;
                    case 'createdByDisplayName'://Saved by
                        $createdByDisplayName = $minime;
                        break;
                    case 'createdOn':
                        foreach($minime[0]->attributes() as $a => $b) 
                        {
                           if($a == "date")
                            $createdOn =  $b;
                        }
                        break;
                    case 'siteTitle'://Site title
                        $siteTitle = $minime;
                        break;
                    case 'title'://subject
                        $title = $minime;
                        break;
                    case 'entityURL':
                        $entityURL = $minime;
                        break;
                    default :
                        break;
                }
            }
            $announcements[] = array('body' => $body,
                                     'createdByDisplayName' => $createdByDisplayName,
                                     'createdOn' => $createdOn,
                                     'siteTitle' => $siteTitle,
                                     'title' => $title, 
                                     'entityURL' => $entityURL);
        }
        //output
        $this->output
         ->set_content_type('application/json')
         ->set_output(json_encode(array('announcements_site' => $announcements)));
    }
    
    public function shumba_all()
    {
        //globals
        $sites = array();
        $announcements = array();
        
        $this->login();
        
        $active[] = $this->sites();
        foreach($active as $site)
        {
            foreach($site as $val)
            {
                $sites[] = $val['site_id'];
            }
        }
        
        $count = 0;
        
        foreach($sites as $site_id)
        {
            $cookie = $this->session->userdata('cookie');
            $cookiepath = realpath($cookie);

            $url_tool = "https://vula.uct.ac.za/direct/announcement/site/" . $site_id . ".xml?n=30&d=300";

            //eat cookie..yum
            $curl = curl_init($url_tool);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_COOKIEFILE, $cookiepath);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);

            $response = curl_exec($curl);

            $xml = simplexml_load_string($response);
            
            $body = "";
            $createdByDisplayName = "";
            $createdOn = "";
            $siteTitle = "";
            $title = "";
            $entityURL = "";

            foreach ($xml->children() as $child) 
            {
                foreach ($child->children() as $minime) 
                {
                    switch ($t = $minime->getName()) 
                    {
                        case 'body':
                            $body = $minime;
                            break;
                        case 'createdByDisplayName'://Saved by
                            $createdByDisplayName = $minime;
                            break;
                        case 'createdOn':
                            foreach($minime[0]->attributes() as $a => $b) 
                            {
                               if($a == "date")
                                $createdOn =  $b;
                            }
                            break;
                        case 'siteTitle'://Site title
                            $siteTitle = $minime;
                            break;
                        case 'title'://subject
                            $title = $minime;
                            break;
                        case 'entityURL':
                            $entityURL = $minime;
                            break;
                        default :
                            break;
                    }
                }
                $announcements[] = array('body' => $body,
                                         'createdByDisplayName' => $createdByDisplayName,
                                         'createdOn' => $createdOn,
                                         'siteTitle' => $siteTitle,
                                         'title' => $title, 
                                         'entityURL' => $entityURL);
            }
            $count++;
        }
        //echo $count;
        //output
        $this->output
         ->set_content_type('application/json')
         ->set_output(json_encode(array('shumba_all' => $announcements)));
    }
    
    
    //Return active sites of User
    public function sites() 
    {
        //$this->login();
        
        //CodeIgniter Session Class
        $cookie = $this->session->userdata('cookie');
        $username = $this->session->userdata('username');
        $cookiepath = realpath($cookie);

        $url = "https://vula.uct.ac.za/portal/site/~" . $username;

        //eat cookie..yum
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_COOKIEFILE, $cookiepath);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);

        $response = curl_exec($curl);
        curl_close($curl);

        /* Scrap! */

        //create html dom object
        $html_str = "";
        $html_str = str_get_html($response);
        $html = new simple_html_dom($html_str);

        //Get User's Active Sites
        $count = 0;
        $active_sites = array();
        $ul = $html->find('ul', 0); //first ul tag
        foreach ($ul->find('li') as $li) 
        {
            foreach ($li->find('a') as $a) 
            {
                if ($count > 0)//skip workspace link  
                {
                    $site_id = substr($a->href, 35);
                    if($a->title != "- more sites -")
                    {
                        $site = array('title' => $a->title,
                                  'site_id' => $site_id);
                        $active_sites[] = $site;
                    }
                }
                $count++;
            }
        }
        return $active_sites;
    }
    
    //login Vula
    public function login() 
    {        
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        //$username = "wtrsas001";
        //$password = "honours";

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
