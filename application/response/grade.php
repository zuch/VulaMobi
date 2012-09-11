<?php

/* Sascha Watermeyer - WTRSAS001
 * Vulamobi CS Honours project
 * sascha.watermeyer@gmail.com */

include_once 'simple_html_dom.php';

class Grade extends CI_Controller 
{
    public function __construct() 
    {
        parent::__construct();
    }
    
    public function Grade() 
    {
        //show_404();
    }
    
    //get grades of User for Course
    public function site($site_id)
    {
        $exists = false;
        $grades = array();
        
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
                $formatted_marks = array();

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
                                if ($td_count == 3)//test marks 
                                {
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
                }
                
                for($i = 0; $i < count($test_names); $i++)
                {
                    $grade = array('name' => $test_names[$i]
                                ,'date' => $test_dates[$i]
                                ,'mark' => $test_marks[$i]);
                $grades[] = $grade;
                }
                
                //output
                echo json_encode(array('grades' => $grades));
            }
            else//doesn't exist
            {
                show_404();
            }
        }
        else//NOT logged in
        {
            $this->session->sess_destroy();
            echo 'logged_out';
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
                    case 'icon-sakai-site-roster'://participants
                        $temp_replace = "https://vula.uct.ac.za/portal/site/" . $site_id . "/page/";
                        $tool_id = str_replace($temp_replace, "", $a->href);

                        $tool = array('participants' => 'participants'
                                      ,'tool_id' => $tool_id);
                        $sup_tools[] = $tool;
                        break;
                    default:
                        break;
                }
            }
            
            //JSON response check
            if($json == 0)//output PHP
            {
                return $sup_tools;
            }
            else if($json == 1)//output JSON
            {
                echo json_encode($sup_tools);
            }
            else
            {
                show_404();
            }
        }
        else//NOT logged in
        {
            $this->session->sess_destroy();
            echo 'logged_out';
        }
    }
}
?>
