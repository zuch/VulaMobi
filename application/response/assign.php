<?php

/* Sascha Watermeyer - WTRSAS001
 * VulaMobi CS Honours project
 * sascha.watermeyer@gmail.com */

header('Access-Control-Allow-Origin: *');  

include_once 'simple_html_dom.php';

class Assign extends CI_Controller 
{
    public function __construct() 
    {
        parent::__construct();
    }
    
    public function Assign() 
    {
        //show_404();
    }
    
    //-----------------------------------all()----------------------------------
    //return all Assignments for Active Sites
    public function all()
    {
        //globals
        $assignments = array();
        
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
            $Site_assign = $this->site_php($site_id);

            if(isset($Site_assign))
            {
                foreach($Site_assign as $assign)
                {
                    $assignments[] = array('site_title' => $assign['site_title'],
                                           'title' => $assign['title'],
                                           'status' => $assign['status'],
                                           'open' => $assign['open'],
                                           'due' => $assign['due'] ) ;
                }
            }   
        }
        //output
        $this->output
         ->set_output(json_encode(array('assignments_all' => $assignments)));
    }
    
    public function site($site_id)
    {
        $this->login();
        
        //globals
        $tool_id = "";
        $site_title = "";
        $exists = false;
        $assignments = array();

        $cookie = $this->session->userdata('cookie');
        $cookiepath = realpath($cookie);

        //check "assignments" in supported tools for site
        $sup_tools = $this->sup_tools($site_id);
        foreach ($sup_tools as $tool)
        {
            if(array_key_exists('assignments',$tool))
            {
                $exists = true;
                $site_title = $tool['site_title'];
                $tool_id = $tool['tool_id'];
            }
        }

        if($exists)
        {
            $url = "https://vula.uct.ac.za/portal/pda/" . $site_id . "/tool/" . $tool_id;
            
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
            
            //arrays
            $title = array();
            $status = array();
            $open = array();
            $due = array();
            
            // loop over rows
            foreach ($html->find('tr') as $row)
            {
                $td_count = 1;
                $td = $row->find('td');
                foreach ($td as $val)
                {
                    if ($td_count == 2)//Assignment Title
                    {
                        $title[] = $val->children(0)->children(0)->innertext;
                    }
                    if ($td_count == 4)//Status
                    {
                       $status[] = $val->innertext;
                    }
                    if ($td_count == 5)//Open
                    {
                        $open[] = $val->innertext;
                    }
                    if ($td_count == 6)//Due
                    {
                       $due[] = $val->innertext;
                    }
                    $td_count++;
                }
            }
            for($i = 0; $i < count($title); $i++)
            {
                $titl = str_replace("\t", "", $title[$i]);
                $stat = str_replace("\t", "", $status[$i]);
                $op = str_replace("\t", "", $open[$i]);
                $du = str_replace("\t", "", $due[$i]);
                
                $assign = array('site_title' => $site_title,
                                'title' => $titl,
                                'status' => $stat,
                                'open' => $op,
                                'due' => $du );
                $assignments[] = $assign;
            }
            
            $this->output
                ->set_output(json_encode(array('assignments_site' => $assignments))); 
        }
        else
        {
            echo "'assignments' is not a tool for site_id: ". $site_id;
        }
    }
    
    public function site_php($site_id)
    {
        //globals
        $tool_id = "";
        $site_title = "";
        $exists = false;
        $assignments = array();

        $cookie = $this->session->userdata('cookie');
        $cookiepath = realpath($cookie);

        //check "gradebook" in supported tools for site
        $sup_tools = $this->sup_tools($site_id);
        foreach ($sup_tools as $tool)
        {
            if(array_key_exists('assignments',$tool))
            {
                $exists = true;
                $site_title = $tool['site_title'];
                $tool_id = $tool['tool_id'];
            }
        }

        if($exists)
        {
            $url = "https://vula.uct.ac.za/portal/pda/" . $site_id . "/tool/" . $tool_id;
            
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
            
            //arrays
            $title = array();
            $status = array();
            $open = array();
            $due = array();
            
            // loop over rows
            foreach ($html->find('tr') as $row)
            {
                $td_count = 1;
                $td = $row->find('td');
                foreach ($td as $val)
                {
                    if ($td_count == 2)//Assignment Title
                    {
                        $title[] = $val->children(0)->children(0)->innertext;
                    }
                    if ($td_count == 4)//Status
                    {
                       $status[] = $val->innertext;
                    }
                    if ($td_count == 5)//Open
                    {
                        $open[] = $val->innertext;
                    }
                    if ($td_count == 6)//Due
                    {
                       $due[] = $val->innertext;
                    }
                    $td_count++;
                }
            }
            for($i = 0; $i < count($title); $i++)
            {
                $titl = str_replace("\t", "", $title[$i]);
                $stat = str_replace("\t", "", $status[$i]);
                $op = str_replace("\t", "", $open[$i]);
                $du = str_replace("\t", "", $due[$i]);
                
                $assign = array('site_title' => $site_title,
                                'title' => $titl,
                                'status' => $stat,
                                'open' => $op,
                                'due' => $du );
                $assignments[] = $assign;
            }
            return $assignments; 
        }
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
    
    //returns array of supported tools for a site
    public function sup_tools($site_id)              
    {        
        $cookie = $this->session->userdata('cookie');
        $cookiepath = realpath($cookie);

        $url = "https://vula.uct.ac.za/portal/pda/" . $site_id;

        //eat cookie..yum
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_COOKIEFILE, $cookiepath);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);

        $response = curl_exec($curl);
        curl_close($curl);

        //create html dom object
        $html_str = str_get_html($response);
        $html = new simple_html_dom($html_str);
        
        //scrap site title
        $site_title = $html->find('.currentSiteLink', 0)->children(0)->children(0)->innertext;
        
        //scrap tools list
        $tools = array();
        if (($ul = $html->find('#pda-portlet-page-menu', 0)) != null)
        {
            $li = $ul->find('li');
            foreach($li as $val)
            {
               $tools[] = $val->children(0)->children(0);// find <a>
            }
        }

        //Check for supported tools
        $sup_tools = array();
        foreach ($tools as $a) 
        {
            switch ($a->class) 
            { 
                case 'icon-sakai-announcements'://announcements
                    $temp_replace = "https://vula.uct.ac.za/portal/pda/" . $site_id . "/tool-reset/";
                    $tool_id = str_replace($temp_replace, "", $a->href);
                    $tool = array('announcements' => 'announcements',
                                  'site_title' => $site_title,
                                  'tool_id' => $tool_id);
                    $sup_tools[] = $tool;
                    break;
                case 'icon-sakai-chat'://chatroom
                    $temp_replace = "https://vula.uct.ac.za/portal/pda/" . $site_id . "/tool-reset/";
                    $tool_id = str_replace($temp_replace, "", $a->href);
                    $tool = array('chatroom' => 'chatroom',
                                  'site_title' => $site_title,
                                  'tool_id' => $tool_id);
                    $sup_tools[] = $tool;
                    break;
                case 'icon-sakai-gradebook-tool'://gradebook
                    $temp_replace = "https://vula.uct.ac.za/portal/pda/" . $site_id . "/tool-reset/";
                    $tool_id = str_replace($temp_replace, "", $a->href);
                    $tool = array('gradebook' => 'gradebook',
                                  'site_title' => $site_title,
                                  'tool_id' => $tool_id);
                    $sup_tools[] = $tool;
                    break;
                case 'icon-sakai-site-roster'://participants
                    $temp_replace = "https://vula.uct.ac.za/portal/pda/" . $site_id . "/tool-reset/";
                    $tool_id = str_replace($temp_replace, "", $a->href);
                    $tool = array('participants' => 'participants',
                                  'site_title' => $site_title,
                                  'tool_id' => $tool_id);
                    $sup_tools[] = $tool;
                    break;
                case 'icon-sakai-resources'://resources
                    $temp_replace = "https://vula.uct.ac.za/portal/pda/" . $site_id . "/tool-reset/";
                    $tool_id = str_replace($temp_replace, "", $a->href);
                    $tool = array('resources' => 'resources',
                                  'site_title' => $site_title,
                                  'tool_id' => $tool_id);
                    $sup_tools[] = $tool;
                    break;
                case 'icon-sakai-assignment-grades'://assignments
                    $temp_replace = "https://vula.uct.ac.za/portal/pda/" . $site_id . "/tool-reset/";
                    $tool_id = str_replace($temp_replace, "", $a->href);
                    $tool = array('assignments' => 'assignments',
                                  'site_title' => $site_title,
                                  'tool_id' => $tool_id);
                    $sup_tools[] = $tool;
                    break;
                default:
                    break;
            }
        }
        return $sup_tools;
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