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
                        $site_id = substr($a->href, 35);//Course id
                        $site = Array($site_id,$a->title);//Course title
                        $active_sites[] = $site;
                    }
                    $count++;
                }
            }
            echo json_encode($active_sites);
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
    public function grade($course_id)
    {
        if($this->session->userdata('logged_in'))
        {
            $site_id_num = $_GET['site'];
            $tool_num = $_GET['tool'];
            $site_title = $_GET['title'];
            $cookie = $_SESSION['cookie'];
            $site_id_name = "site" . $site_id_num;
            $site_id = $_SESSION[$site_id_name];
            $tool_name = "tool" . $tool_num;
            $tool_id = $_SESSION[$tool_name];

            echo "tool_id: " . $tool_id . "</br>";

            //https://vula.uct.ac.za/portal/tool/bd422298-b893-4816-9eaf-b2bb9052be57?panel=Main

            $cookiepath = null;
            $cookiepath = realpath($cookie);

            $url = "https://vula.uct.ac.za/portal/site/" . $site_id . "/page/" . $tool_id;

            //eat cookie..yum
            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_COOKIEFILE, $cookiepath);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);

            $response = curl_exec($curl);

            //create html dom object
            $html_str = "";
            $html_str = str_get_html($response);
            $html = new simple_html_dom($html_str);

            //globals
            $test_names = array();
            $test_dates = array();
            $test_marks = array();


            if (($iframe_url = $html->find('iframe', 0)->src) != null) 
            {
                echo "iframe_url: " . $iframe_url . "</br>";
                curl_setopt($curl, CURLOPT_URL, $iframe_url);
                $result = curl_exec($curl);
                $html = str_get_html($result);

                $td_count = 0;

                if (($results_table = $html->find("#gbForm", 0)->children(3)) != null)
                {
                    echo "results_table: " . $results_table . "</br>";

                    $theData = array();
                    echo "_id_0__hide_division_: " . $results_table->find("#_id_0__hide_division_", 0) . "</br>";

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
        }
        else//NOT logged in
        {
            $this->session->sess_destroy();
            echo 'exit';
        }
    }
    
    //returns array of supported tools for course
    //set "$json = true" if want JSON resposnse else "false"
    public function sup_tools($course_id ,$json)
    {
        if($json == "0")//false
        {
            
        }
        else//$json == "1"
        {
            
        }
    }
}

?>
