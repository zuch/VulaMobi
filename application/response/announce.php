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
                    case 'attachments':
                        $attachments = $minime->children();
                        break;
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
                $announcements[] = array('attachments' => $attachments,
                                     'body' => $body,
                                     'createdByDisplayName' => $createdByDisplayName,
                                     'createdOn' => $createdOn,
                                     'id' => $id,
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
        $attachments = "";
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
                    case 'attachments':
                        $attachments = $minime->children();
                        break;
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
            $announcements[] = array('attachments' => $attachments,
                                     'body' => $body,
                                     'createdByDisplayName' => $createdByDisplayName,
                                     'createdOn' => $createdOn,
                                     'id' => $id,
                                     'siteTitle' => $siteTitle,
                                     'title' => $title, 
                                     'entityURL' => $entityURL);
        }
        
        //output

        $this->output
            ->set_content_type('application/json')
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
        $attachments = "";
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
                    case 'attachments':
                        $attachments = $minime->children();
                        break;
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
            $announcements[] = array('attachments' => $attachments,
                                     'body' => $body,
                                     'createdByDisplayName' => $createdByDisplayName,
                                     'createdOn' => $createdOn,
                                     'id' => $id,
                                     'siteTitle' => $siteTitle,
                                     'title' => $title, 
                                     'entityURL' => $entityURL);
        }
        return $announcements;
    }
    
    public function shumba_all()
    {   
        //globals
        $sites = array();
        $announcements = array();
        $tool_id = "";
        $exists = false;
        $announce_count = 0;
        
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
            //check "announcements" in supported tools for site
            $sup_tools = $this->sup_tools($site_id);
            foreach ($sup_tools as $tool) 
            {
                if(array_key_exists('announcements',$tool))
                {
                    $exists = true;
                    $tool_id = $tool['tool_id'];
                }
            }

            if($exists)
            {
                //get "body" from Vula xml web service
                $site_xml = $this->site_php($site_id);
                foreach ($site_xml as $announcement)
                { 
                    $announcements[] = array('attachments' => $announcement['attachments'],
                                             'body' => $announcement['body'],
                                             'createdByDisplayName' => $announcement['createdByDisplayName'],
                                             'createdOn' => $announcement['createdOn'],
                                             'id' => $announcement['id'],
                                             'siteTitle' => $announcement['siteTitle'],
                                             'title' => $announcement['title'], 
                                             'entityURL' => $announcement['entityURL'] );
                    $announce_count++;
                }
            }
        }
        
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
    
    //returns array of supported tools for a site
    // - name e.g. "CS Honours"
    // - id e.g. "fa532f3e-a2e1-48ec-9d78-3d5722e8b60d"
    //set "$json = 1" if want JSON resposnse else "0"
    public function sup_tools($site_id)
    {
        $this->login();
        
        $cookie = $this->session->userdata('cookie');
        $cookiepath = realpath($cookie);

        $url = "https://vula.uct.ac.za/portal/site/" . $site_id;

        //eat cookie..yum
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_COOKIEFILE, $cookiepath);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);

        $response = curl_exec($curl);
        curl_close($curl);

        //create html dom object
        $html_str = "";
        $html_str = str_get_html($response);
        $html = new simple_html_dom($html_str);

        //scrap tools list
        $tools = array();
        $tools_ul = $html->find('#toolMenu', 0);
        $ul = $tools_ul->children(0);
        foreach ($ul->find('li') as $li) 
        {
            foreach ($li->find('a') as $a)
            {
                $tools[] = $a;
            }
        }

        //Check for supported tools
        $sup_tools = array();
        foreach ($tools as $a) 
        {
            switch ($a->class) 
            {
                case 'icon-sakai-announcements'://announcements
                    $temp_replace = "https://vula.uct.ac.za/portal/site/" . $site_id . "/page/";
                    $tool_id = str_replace($temp_replace, "", $a->href);

                    $tool = array('announcements' => 'announcements'
                                  ,'tool_id' => $tool_id);
                    $sup_tools[] = $tool;
                    break;
                case 'icon-sakai-chat'://chatroom
                    $temp_replace = "https://vula.uct.ac.za/portal/site/" . $site_id . "/page/";
                    $tool_id = str_replace($temp_replace, "", $a->href);

                    $tool = array('chatroom' => 'chatroom'
                                  ,'tool_id' => $tool_id);
                    $sup_tools[] = $tool;
                    break;
                case 'icon-sakai-gradebook-tool'://gradebook
                    $temp_replace = "https://vula.uct.ac.za/portal/site/" . $site_id . "/page/";
                    $tool_id = str_replace($temp_replace, "", $a->href);

                    $tool = array('gradebook' => 'gradebook'
                                  ,'tool_id' => $tool_id);
                    $sup_tools[] = $tool;
                    break;
                case 'icon-sakai-site-roster'://participants
                    $temp_replace = "https://vula.uct.ac.za/portal/site/" . $site_id . "/page/";
                    $tool_id = str_replace($temp_replace, "", $a->href);

                    $tool = array('participants' => 'participants'
                                  ,'tool_id' => $tool_id);
                    $sup_tools[] = $tool;
                    break;
                case 'icon-sakai-resources'://resources
                    $temp_replace = "https://vula.uct.ac.za/portal/site/" . $site_id . "/page/";
                    $tool_id = str_replace($temp_replace, "", $a->href);

                    $tool = array('resources' => 'resources'
                                  ,'tool_id' => $tool_id);
                    $sup_tools[] = $tool;
                    break;
                default:
                    break;
            }
        }
        return $sup_tools;
    }
}
?>
