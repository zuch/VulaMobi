<?php

/* Sascha Watermeyer - WTRSAS001
 * Vulamobi CS Honours project
 * sascha.watermeyer@gmail.com */

include_once 'simple_html_dom.php';

class User extends CI_Controller 
{
    public function __construct() 
    {
        parent::__construct();
    }

    public function index() 
    {
        show_404();
    }

    //Return active sites of User
    public function sites() 
    {   
        if($this->session->userdata('logged_in'))
        {
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

            //Get User's name
            $temp_replace = '(' . $username . ') |';
            $loginUser_str = $html->find('#loginUser', 0);
            $loginUser = $loginUser_str->innertext;
            $loginUser_title = str_replace($temp_replace, "", $loginUser);

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
                        $site = Array($site_id,$a->title);
                        $active_sites[] = $site;
                    }
                    $count++;
                }
            }
            echo json_encode($active_sites);//return array of JSON objects
        }
        else//NOT logged in
        {
            $this->session->sess_destroy();
            echo 'exit';
        }
    }
    
    //Return name of User e.g Sascha Watermeyer
    public function name()
    {
        if($this->session->userdata('logged_in'))
        {
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

            //Get User's name
            $temp_replace = '(' . $username . ') |';
            $loginUser_str = $html->find('#loginUser', 0);
            $loginUser = $loginUser_str->innertext;
            $loginUser_title = str_replace($temp_replace, "", $loginUser);

            echo $loginUser_title;
        }
        else//NOT logged in
        {
            $this->session->sess_destroy();
            echo 'exit';
        }
    }
    
    //get grades of User for Course
    public function grade($site_id)
    {
        $exists = false;
        
        if($this->session->userdata('logged_in'))
        {
            //globals
            $tool_id = "";
            $exists = false;
            
            $cookie = $this->session->userdata('cookie');
            $cookiepath = realpath($cookie);
            
            //check "gradebook" in supported tools for site
            $sup_tools = $this->sup_tools($site_id, 0);
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
                $url = "https://vula.uct.ac.za/portal/site/" . $site_id . "/page/" . $tool_id;

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

                if (($iframe_url = $html->find('iframe', 0)->src) != null) 
                {
                    //echo "iframe_url: " . $iframe_url . "</br>";

                    curl_setopt($curl, CURLOPT_URL, $iframe_url);
                    $result = curl_exec($curl);
                    curl_close($curl);

                    $html = str_get_html($result);

                    $td_count = 0;

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
                                if ($td_count == 3) {
                                    $test_marks[] = $val->innertext;
                                }
                                $td_count++;
                            }
                        }
                    }
                }
                foreach($test_names as $name)
                {
                     echo $name."</br>";
                }
            }
            else//doesn't exist
            {
                echo "doesn't exist";
            }
        }
        else//NOT logged in
        {
            $this->session->sess_destroy();
            echo 'exit';
        }
    }
    
    //returns array of supported tools for a site
    // - name e.g. "CS Honours"
    // - id e.g. "fa532f3e-a2e1-48ec-9d78-3d5722e8b60d"
    //set "$json = 1" if want JSON resposnse else "0"
    public function sup_tools($site_id ,$json)
    {
        if($this->session->userdata('logged_in'))
        {
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
                    default:
                        break;
                }
            }
            //JSON response check
            if($json == 0)//false
            {
                return $sup_tools;
            }
            else//$json == "1"
            {
                echo json_encode($sup_tools);
            }
        }
        else//NOT logged in
        {
            $this->session->sess_destroy();
            echo 'exit';
        }
    }    
}

?>
