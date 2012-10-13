<?php

/* Sascha Watermeyer - WTRSAS001
 * VulaMobi CS Honours project
 * saschawatermeyer@gmail.com */

header('Access-Control-Allow-Origin: *');  

include_once 'simple_html_dom.php';

class Role extends CI_Controller 
{
    public function __construct() 
    {
        parent::__construct();
    }
    
    public function Role() 
    {
        //show_404();
    }
    
    //get roster for a Course
    public function roster($site_id)
    {
        $this->login();
        
        $exists = false;
        $users = array();
                
        //globals
        $tool_id = "";

        $cookie = $this->session->userdata('cookie');
        $cookiepath = realpath($cookie);

        //check "participants" in supported tools for site
        $sup_tools = $this->sup_tools($site_id, 0);
        foreach ($sup_tools as $tool) 
        {
            if(array_key_exists('participants',$tool))
            {
                $exists = true;
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

            //globals
            $name = array();
            $id = array();
            $email = array();
            $role = array();
            
            if (($results_table = $html->find('form#roster_form', 0)->children(4)) != null)
            {
                // loop over rows
                foreach ($results_table->find('tr') as $row) 
                {
                    $td_count = 1;
                    $td = $row->find('td');
                    foreach ($td as $val) 
                    {
                        if ($td_count == 1)//name
                        {
                            $str = $val->find('a',0)->innertext;
                            $name[] = $str;
                        }
                        if ($td_count == 2)//student number 
                        {
                            $id[] = $val->innertext;
                        }
                        if ($td_count == 3)//email
                        {
                            $str = $val->find('a',0)->innertext;
                            $email[] = $str;
                        }
                        if ($td_count == 4)//role
                        {
                            $role[] = $val->innertext;
                        }
                        $td_count++;
                    }
                }
            }
         

            for($i = 0; $i < count($name); $i++)
            {
                $user = array('name' => $name[$i],
                                'id' => $id[$i],
                                'email' => $email[$i],
                                'role' => $role[$i]);
                $users[] = $user;
            }

            $this->output
            ->set_output(json_encode(array('roster' => $users)));
        }
        else//404
        {
             echo "'participants' is not a tool for site_id: ". $site_id;
        }
    }
    
    //get Role for user of Course
    public function site($site_id)
    {
        $this->login();
        
        //globals
        $tool_id = "";
        $exists = false;
        
        $username = $this->session->userdata('username');  
        $cookie = $this->session->userdata('cookie');
        $cookiepath = realpath($cookie);

        //check "participants" in supported tools for site
        $sup_tools = $this->sup_tools($site_id);
        foreach ($sup_tools as $tool) 
        {
            if(array_key_exists('participants',$tool))
            {
                $exists = true;
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

            //globals
            $id = array();
            
            if (($results_table = $html->find('form#roster_form', 0)->children(4)) != null)
            {
                // loop over rows
                foreach ($results_table->find('tr') as $row) 
                {
                    $found = false;
                    $td_count = 1;
                    $td = $row->find('td');
                    foreach ($td as $val) 
                    {
                        if ($td_count == 2)//username 
                        {
                            $id = $val->innertext;
                            if($id == $username)
                            {
                                $found = true;
                            }
                        }
                        if ($td_count == 4 && ($found))//role 
                        {
                            $this->output
                            ->set_output($val->innertext);
                        }
                        $td_count++;
                    }
                }
            }
        }
        else//404
        {
            echo "you are not part of this site";
        }
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
?>
