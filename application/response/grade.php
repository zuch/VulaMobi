<?php

/* Sascha Watermeyer - WTRSAS001
* VulaMobi CS Honours project
* sascha.watermeyer@gmail.com */

header('Access-Control-Allow-Origin: *');

include_once 'simple_html_dom.php';

class Grade extends CI_Controller
{
    //-----------------------------_construct()---------------------------------
    public function __construct()
    {
        parent::__construct();
    }
    
    //----------------------------------Grade()---------------------------------
    public function Grade()
    {
        //show_404();
    }
    
    //----------------------------------site()----------------------------------
    //get grades of User for Course
    public function site($site_id)
    {
        $this->login();
        
        //globals
        $tool_id = "";
        $exists = false;
        $grades = array();

        $cookie = $this->session->userdata('cookie');
        $cookiepath = realpath($cookie);

        //check "gradebook" in supported tools for site
        $sup_tools = $this->sup_tools($site_id);
        foreach ($sup_tools as $tool)
        {
            if(array_key_exists('gradebook',$tool))
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
            $test_names = array();
            $test_dates = array();
            $test_marks = array();

            if (($results_table = $html->find("#gbForm", 0)->children(3)) != null)
            {
                // loop over rows
                foreach ($results_table->find('tr') as $row)
                {
                    $td_count = 1;
                    $td = $row->find('td');
                    foreach ($td as $val)
                    {
                        if ($td_count == 1)
                        {
                            $test_names[] = $val->innertext;
                        }
                        if ($td_count == 2)
                        {
                            $test_dates[] = $val->innertext;
                        }
                        if ($td_count == 3)//test marks
                        {
                            //parse for Don
                            $mark = $val->innertext;
                            if (strpos($mark,'/') !== false)
                            {
                                $top = strstr($mark, '/', true);
                                $bottom = strstr($mark, '/');
                                $substr = substr($bottom, 1);
                                $result = ($top/$substr)*100;
                                $test_marks[] = $result . '%';
                            }
                            else
                            {
                                $test_marks[] = $mark;
                            }
                        }
                        $td_count++;
                    }
                }
            }
            
            for($i = 0; $i < count($test_names); $i++)
            {
                $grade = array('name' => $test_names[$i],
                               'date' => $test_dates[$i],
                               'mark' => $test_marks[$i]);
            $grades[] = $grade;
            }
            
            $this->output
                ->set_output(json_encode(array('grades' => $grades)));
        }
        else
        {
            echo "'gradebook' is not a tool for ". $site_title;
        }
    }
    
    //----------------------------------site_php()----------------------------------
    public function site_php($site_id)
    {
        $this->login();
        
        //globals
        $tool_id = "";
        $site_title = "";
        $exists = false;
        $grades = array();

        $cookie = $this->session->userdata('cookie');
        $cookiepath = realpath($cookie);

        //check "gradebook" in supported tools for site
        $sup_tools = $this->sup_tools($site_id);
        foreach ($sup_tools as $tool)
        {
            if(array_key_exists('gradebook',$tool))
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

            //globals
            $test_names = array();
            $test_dates = array();
            $test_marks = array();

            if (($results_table = $html->find("#gbForm", 0)->children(3)) != null)
            {
                // loop over rows
                foreach ($results_table->find('tr') as $row)
                {
                    $td_count = 1;
                    $td = $row->find('td');
                    foreach ($td as $val)
                    {
                        if ($td_count == 1)
                        {
                            $test_names[] = $val->innertext;
                        }
                        if ($td_count == 2)
                        {
                            $test_dates[] = $val->innertext;
                        }
                        if ($td_count == 3)//test marks
                        {
                            //parse for Don
                            $mark = $val->innertext;
                            if (strpos($mark,'/') !== false)
                            {
                                $top = strstr($mark, '/', true);
                                $bottom = strstr($mark, '/');
                                $substr = substr($bottom, 1);
                                $result = ($top/$substr)*100;
                                $test_marks[] = $result . '%';
                            }
                            else
                            {
                                $test_marks[] = $mark;
                            }
                        }
                        $td_count++;
                    }
                }
            }
            
            for($i = 0; $i < count($test_names); $i++)
            {
                $grade = array('site_title' => $site_title,
                               'name' => $test_names[$i],
                               'date' => $test_dates[$i],
                               'mark' => $test_marks[$i]);
            $grades[] = $grade;
            }
            return $grades;
        }
    }
    
    //-----------------------------------all()----------------------------------
    //return all Grades for Active Sites
    public function all()
    {
        $grades = array();
        
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
            $Site_grades = $this->site_php($site_id);

            if(isset($Site_grades))
            {
                foreach($Site_grades as $grade)
                {
                    $grades[] = array('site_title' => $grade['site_title'],
                                      'name' => $grade['name'],
                                      'date' => $grade['date'],
                                      'mark' => $grade['mark'] ) ;
                }
            }   
        }
        
        //output
        $this->output
         ->set_output(json_encode(array('grades_all' => $grades)));
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
        $this->login();
        
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
        //$username = $this->input->post('username');
        //$password = $this->input->post('password');
         $username = "wtrsas001";
         $password = "honours";
        
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