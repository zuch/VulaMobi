<?php

/* Sascha Watermeyer - WTRSAS001
 * VulaMobi CS Honours project
 * saschawatermeyer@gmail.com */

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
    
    public function submit($site_id)
    {
        $this->login();
        
        //globals
        $tool_id = "";
        $exists = false;
        $username = $this->session->userdata('username');
        $password = $this->session->userdata('password');
        $body = $this->input->post('body');

        $cookie = $this->session->userdata('cookie');
        $cookiepath = realpath($cookie);

        //check "chatroom" in supported tools for site
        $sup_tools = $this->sup_tools($site_id, 0);
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
            $url = "https://vula.uct.ac.za/portal/pda/" . $site_id . "/tool/" . $tool_id;   
            
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
            
            if(($channel_id = $html->find('input[id=topForm:chatidhidden]',0)->value) != null)//get Channel ID
            {
                $url = "https://vula.uct.ac.za/direct/chat-message/new";
                $curl = curl_init($url);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($curl, CURLOPT_USERPWD, "$username:$password");
                curl_setopt($curl, CURLOPT_POSTFIELDS, array('chatChannelId' => $channel_id, 'body' => $body));
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
                curl_setopt($curl, CURLOPT_COOKIEFILE, $cookiepath);

                $response = curl_exec($curl);

                $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
                if($http_status == "400")//Invalid Channel ID
                {
                    echo "Invalid Channel ID";
                }
                else
                {
                    echo "Success";
                }
            }
        }
        else//404
        {
            echo "'chatroom' is not a tool for site_id: ". $site_id;
        }
    }
    
    public function site($site_id)
    {   
        $this->login();
        
        //globals
        $tool_id = "";
        $exists = false;

        $cookie = $this->session->userdata('cookie');
        $cookiepath = realpath($cookie);

        //check "chatroom" in supported tools for site
        $sup_tools = $this->sup_tools($site_id);
        
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
            $cookie = $this->session->userdata('cookie');
            $cookiepath = realpath($cookie);

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
            $messages = array();
            $names = array();
            $times = array();

            $chat_messages = "";

            if (($chat_messages = $html->find(".chatList", 0)) != null) 
            {
                if (( $li = $chat_messages->find("li")) != null)
                {
                    foreach($li as $val)
                    {
                        $message = $val->innertext;
                        $msg = str_replace("\\t", "", $message);
                        $messages[] = $msg;
                    }
                }
            }
            
            //reverse order to show latest at top
            $return = array_reverse($messages);
            
            //output
            $this->output
                ->set_output(json_encode(array('chat' => $return)));
        }
        else//404
        {
            echo "'chatroom' is not a tool for site_id: ". $site_id;
        }
    }
    
    //http://bit.ly/Tbk1g7
    public function removeTag($content, $tagName) 
    {
        $dom = new DOMDocument();
        $dom->loadXML($content);

        $nodes = $dom->getElementsByTagName($tagName);

        while ($node = $nodes->item(0)) {
            $replacement = $dom->createDocumentFragment();
            while ($inner = $node->childNodes->item(0)) {
                $replacement->appendChild($inner);
            }
            $node->parentNode->replaceChild($replacement, $node);
        }

        return $dom->saveHTML();
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
