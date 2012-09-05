<?php

/* Sascha Watermeyer - WTRSAS001
 * Vulamobi CS Honours project
 * sascha.watermeyer@gmail.com */

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

    //Return active sites of a user
    public function sites() 
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
        echo json_encode($active_sites);
    }
    
    //Return Name of User e.g Sascha Watermeyer
    public function username()
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
}

?>
