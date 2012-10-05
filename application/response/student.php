<?php

/* Sascha Watermeyer - WTRSAS001
 * Vulamobi CS Honours project
 * sascha.watermeyer@gmail.com */

header('Access-Control-Allow-Origin: *'); 

include_once 'simple_html_dom.php';

class Student extends CI_Controller 
{
    public function __construct() 
    {
        parent::__construct();
    }

    public function index() 
    {
        show_404();
    }
    
    public function Student() 
    {
        show_404();
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
        
        $this->output
            ->set_output(json_encode(array('active_sites' => $active_sites)   )   );
    }
    
    //Return name of User e.g Sascha Watermeyer
    public function name()
    {        
        $this->login();
        
        if($this->session->userdata('name'))
        {
            echo $this->session->userdata('name');
        }
        else//session variable not set
        {
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

            $newdata = array(
               'name'  => $loginUser_title
           );

            $this->session->set_userdata($newdata);
            
            $this->output
            ->set_content_type('text/plain')
            ->set_output($loginUser_title);
        }
    }
    
    //Return Student Number of User e.g WTRSAS001
    public function id()
    {
        $this->login();
        
        echo $this->session->userdata('username');
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
