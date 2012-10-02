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
        //array_slice($active_sites,1,count($active_sites)-1);
        //$temp = '[{"title":"CS Honours, 2012","site_id":"fa532f3e-a2e1-48ec-9d78-3d5722e8b60d"},{"title":"Major Project","site_id":"43271a70-b78e-460b-a5b8-8356d0989a85"},{"title":"CS agents","site_id":"69e9386d-a772-47c6-8842-4d1d14a7650c"},{"title":"DBS","site_id":"0fecefa0-3afb-4504-a888-4bb4b48523a3"},{"title":"CSC3002F,2011","site_id":"e193c143-9d00-402b-811b-58ae999498c9"},{"title":"- more sites -","site_id":false}]';
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
