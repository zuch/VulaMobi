<?php

/* Sascha Watermeyer - WTRSAS001
 * VulaMobi CS Honours project
 * sascha.watermeyer@gmail.com */

header('Access-Control-Allow-Origin: *');  

include_once 'simple_html_dom.php';

class Announce extends CI_Controller 
{
    public function __construct() 
    {
        parent::__construct();
    }
    
    //Get the body of an Announcement
    public function body($announce_id)
    {
        $this->login();
        
        $cookie = $this->session->userdata('cookie');
        $cookiepath = realpath($cookie);
        
        //extract site_id & announcement_id
        list($site_id, $announcement_id) = explode("&", $announce_id);
        
        //get last 100 announcements in the past 300 days for user
        $url = "https://vula.uct.ac.za/direct/announcement/site/" . $site_id . ".xml?n=100&d=300";

        //eat cookie..yum
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_COOKIEFILE, $cookiepath);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);

        $response = curl_exec($curl);

        $xml = simplexml_load_string($response);

        //globals
        $announcements = array();
        $attachments = "";
        $body = "";
        $id = "";

        //parse XML
        foreach ($xml->children() as $child) 
        {
            foreach ($child->children() as $minime) 
            {
                switch ($t = $minime->getName()) 
                {
                    case 'attachments':
                        $attachments = $minime->children();
                        break;
                    case 'body':
                        $body = $minime;
                        break;
                    case 'id':
                        $id = $minime;
                        break;
                    default :
                        break;
                }
            }
            $announcements[] = array('attachments' => $attachments,
                                     'body' => $body,
                                     'id' => $id );
        }
        
        $found = false;
        $return = "";
        foreach($announcements as $announce)
        {
            if($announcement_id == $announce['id'])
            {
                $return = $announce['body'];
                $found = true;
            }
        }
        
        //output
        if($found)
        {
            $this->output
                ->set_output($return);
        }
        else
        {
            echo "announcement not found";
        }
    }
    
    //get grades of User for Course
    public function all()
    {
        //globals
        $sites = array();
        $announcements = array();
        $exists = false;
        $announce_count = 1;
        
        //login
        $this->login();
        
        //get Active Site id's
        $active[] = $this->sites();
        foreach($active as $site)
        {
            foreach($site as $val)
            {
                $sites[] = $val['site_id'];
            }
        }
        
        //Scrap Announcements of each Active Site
        foreach($sites as $site_id)
        {
            $site_xml = $this->site_php($site_id);
            foreach ($site_xml as $announcement)
            { 
                $announcements[] = array(//'attachments' => $announcement['attachments'],
                                         'createdByDisplayName' => $announcement['createdByDisplayName'],
                                         'createdOn' => $announcement['createdOn'],
                                         'title' => $announcement['title'],
                                         'siteTitle' => $announcement['siteTitle'],
                                         'announce_id' => $announcement['announce_id']);
                $announce_count++;
            }
        }
        
        //output
        $this->output
         ->set_output(json_encode(array('announcements_all' => $announcements)));
    }
    
    public function site($site_id)
    {
        $this->login();
        
        $cookie = $this->session->userdata('cookie');
        $cookiepath = realpath($cookie);
        
        $url_tool = "https://vula.uct.ac.za/direct/announcement/site/" . $site_id . ".xml?n=100&d=300";

        //eat cookie..yum
        $curl = curl_init($url_tool);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_COOKIEFILE, $cookiepath);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);

        $response = curl_exec($curl);

        $xml = simplexml_load_string($response);

        $announcements = array();
        $createdByDisplayName = "";
        $createdOn = "";
        $id = "";
        $siteTitle = "";
        $title = "";
        $entityURL = "";

        foreach ($xml->children() as $child) 
        {
            foreach ($child->children() as $minime) 
            {
                switch ($t = $minime->getName()) 
                {
                    /*case 'attachments':
                        $attachments = $minime->children();
                        break;*/
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
                    case 'id':
                        $id = $minime;
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
            $announcements[] = array('createdByDisplayName' => $createdByDisplayName,
                                     'createdOn' => $createdOn,
                                     'title' => $title,
                                     'siteTitle' => $siteTitle,
                                     'announce_id' => $site_id . "&" . $id);
        }
        
        //output
        $this->output
            ->set_output(json_encode(array('announcements_site' => $announcements)));
    }
    
    public function site_php($site_id)
    {
        $this->login();
        
        $cookie = $this->session->userdata('cookie');
        $cookiepath = realpath($cookie);
        
        $url_tool = "https://vula.uct.ac.za/direct/announcement/site/" . $site_id . ".xml?n=100&d=300";

        //eat cookie..yum
        $curl = curl_init($url_tool);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_COOKIEFILE, $cookiepath);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);

        $response = curl_exec($curl);

        $xml = simplexml_load_string($response);

        $announcements = array();
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
                    case 'id':
                        $id = $minime;
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
            $announcements[] = array('createdByDisplayName' => $createdByDisplayName,
                                     'createdOn' => $createdOn,
                                     'title' => $title,
                                     'siteTitle' => $siteTitle,
                                     'announce_id' => $site_id . "&" . $id);
        }
        return $announcements;
    }
    
    //Return active sites of User
    public function sites() 
    {
        $this->login();
        
        $cookie = $this->session->userdata('cookie');
        $cookiepath = realpath($cookie);

        $url = "https://vula.uct.ac.za/portal/pda/";

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
        $html_str = str_get_html($response);
        $html = new simple_html_dom($html_str);

        //Get User's Active Sites
        $active_sites = array();
        $count = 0;
        if (($ul = $html->find('#pda-portlet-site-menu', 0)) != null)
        {
            $li = $ul->find('li');
            foreach($li as $val)
            {
                if ($count > 0)//skip workspace link  
                {
                    $href = $val->children(0)->children(0)->href;
                    $title = $val->children(0)->children(0)->title;
                    $site_id = substr($href, 34);
                    $site = array('title' => $title,
                                  'site_id' => $site_id);
                    $active_sites[] = $site;
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
