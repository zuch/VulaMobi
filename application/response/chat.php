<?php

/* Sascha Watermeyer - WTRSAS001
 * Vulamobi CS Honours project
 * sascha.watermeyer@gmail.com */

header('Access-Control-Allow-Origin: *');  

include_once 'simple_html_dom.php';

class Chat extends CI_Controller 
{
    public function __construct() 
    {
        parent::__construct();
    }
    
    public function Chat() 
    {
        //show_404();
    }
    
    public function site($site_id)
    {   
        $this->login();
        
        //globals
        $tool_id = "";
        $exists = false;
        $links = array();

        $cookie = $this->session->userdata('cookie');
        $cookiepath = realpath($cookie);

        //check "resources" in supported tools for site
        $sup_tools = /*include_once 'sup_tools.php'*/$this->sup_tools($site_id);
        
        foreach ($sup_tools as $tool) 
        {
            if(array_key_exists('chatroom',$tool))
            {
                $exists = true;
                $tool_id = $tool['tool_id'];
            }
        }

        if($exists)
        {
            //  include_once 'login.php';
        
            //CodeIgniter Session Class
            //$username = $this->session->userdata('username');
            $cookie = $this->session->userdata('cookie');
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
            $html_str = str_get_html($response);
            $html = new simple_html_dom($html_str);

            //globals
            $messages = array();

            if (($iframe_url = $html->find('iframe', 0)->src) != null) 
            {
                //echo "iframe_url: " . $iframe_url . "</br>";

                curl_setopt($curl, CURLOPT_URL, $iframe_url);
                $result = curl_exec($curl);
                $html = str_get_html($result);

                $chat_messages = "";

                if (($chat_messages = $html->find(".chatList", 0)) != null) 
                {
                    if (( $li = $chat_messages->find("li")) != null)
                    {
                        foreach($li as $val)
                        {
                            $messages[] = $val->innertext;
                        }
                    }
                }
            }//END iframe
            echo json_encode(array('chat' => $messages));
        }
        else//404
        {
            echo "you are not part of this site";
        }
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
            echo "empty";
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
            echo "incorrect";
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
