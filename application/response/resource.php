<?php

/* Sascha Watermeyer - WTRSAS001
 * VulaMobi CS Honours project
 * saschawatermeyer@gmail.com */

header('Access-Control-Allow-Origin: *');

include_once 'simple_html_dom.php';

class Resource extends CI_Controller {

    // public $global = array();

    public function __construct() {
        parent::__construct();
    }

    public function Resource() {
        echo "yo";
        //show_404();
    }

    //get roster for a Course
    public function site($site_id) 
    {
        //globals
        $files = array();

        $this->login();

        $result = $this->getResource($site_id); //start recursion from root

        foreach ($result as $resource) 
        {
            $file = array('type' => $resource['type'],
                'title' => $resource['title'],
                'href' => $resource['href']);
            $files[] = $file;
        }
        //output
        $this->output
                ->set_output(json_encode(array('resources' => $files)));
    }

    public function getResource($site_id, &$global = array()) 
    {
        $cookie = $this->session->userdata('cookie');
        $cookiepath = realpath($cookie);

        $base = "https://vula.uct.ac.za/access/content/group/";
        $url = $base . $site_id;

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

        if (($li = $html->find('ul li')) != null) 
        {
            foreach ($li as $val) 
            {
                if ($val->class == "folder") 
                {
                    $this->getResource($site_id . "/" . $val->children(0)->href, $global);
                }
                if ($val->class == "file") 
                {
                    $file = array('type' => "file",
                        'title' => $val->children(0)->innertext,
                        'href' => $base . $val->children(0)->href);
                    $global[] = $file;
                }
            }
        }
        return $global;
    }

    public function page($site_id) 
    {
        //echo '<script src="js/vulamobi.js"></script>';
        //echo '<script src="js/jquery.js"></script>';
        $this->login();
        
        //globals
        $tool_id = "";
        $exists = false;
        $resources = array();

        $cookie = $this->session->userdata('cookie');
        $cookiepath = realpath($cookie);

        //check "resources" in supported tools for site
        $sup_tools = $this->sup_tools($site_id);
        foreach ($sup_tools as $tool)
        {
            if(array_key_exists('resources',$tool))
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
            
            //find id's
            $count = 0;
            foreach ($html->find('td[headers=title]') as $element) 
            {
                if($count > 0)
                {
                    $innerhtml = str_get_html($element);
                    if ($innerhtml->find('a', 1)->href == "#")//folder 
                    {
                        $valuearray = explode("'", $innerhtml->find('a', 1)->onclick);
                        $link = "https://vula.uct.ac.za/access/content" . $valuearray[7];
                        $snip = $innerhtml->find('a', 1)->plaintext;
                        $title = str_replace(array(' ', "\n", "\t", "\r"), '', $snip);
                       // $onclick = "folderSelected('" . $link . "')";

                        $folder = array('type' => "folder",
                                        'title' => $title,
                                        'href' => $link);
                        $resources[] = $folder;
                        
                        //echo '<div style="background-color:#C2D1FF; margin-top: 5px; overflow: hidden; padding: 5px;" 
                        //           onclick="'.$onclick.'">'.$title.'</div>';
                    } 
                    else//resource 
                    {
                        $href = $innerhtml->find('a', 1)->href;
                        $snip = $innerhtml->find('a', 1)->plaintext;
                        $title = str_replace(array(' ', "\n", "\t", "\r"), '', $snip);
                        //$onclick = "resourceSelected('" . $href . "')";

                        $item = array('type' => "file",
                                      'title' => $title,
                                      'href' => $href);
                        $resources[] = $item;
                        
                        //echo '<div style="background-color:#439643; margin-top: 5px; overflow: hidden; padding: 5px;" 
                        //           onclick="'.$onclick.'">'.$title.'</div>';
                    }
                }
                $count++;
            }
             $this->output
                ->set_output(json_encode(array('resources' => $resources)));
        }
        else
        {
            echo "'resources' is not a tool for ". $site_id;
        }
    }
    
    //folder selected
    public function folder()
    {
        $this->login();
        
        $folderid = $this->input->post('folderid');
        
        $cookie = $this->session->userdata('cookie');
        $cookiepath = realpath($cookie);

        //globals
        $resources = array();
        
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_COOKIEFILE, $cookiepath);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt ($curl, CURLOPT_URL, $folderid);	
        $result = curl_exec ($curl);
        
        $html = str_get_html($result);

        $position = strripos($folderid,"/",-3);
        $newfolderid = substr($folderid,0,$position);
        $root_href = $newfolderid . "/";
        
        $folder = array('type' => "folder",
                        'title' => "Up One Level",
                        'href' => $root_href);
        $resources[] = $folder;

        if($html == null)
        {
                echo "null";
                die();
        }

        foreach($html->find('li') as $element)
        {
            if($element->class == "folder")
            {	
                $foldername = $folderid . $element->find('a',0)->href;
                $title = $element->find('a',0)->plaintext;

                $folder = array('type' => "folder",
                                'title' => $title,
                                'href' => $foldername);
                $resources[] = $folder;
            }
            if($element->class == "file")
            {
                $filename = $folderid . $element->find('a',0)->href;
                $title = $element->find('a',0)->plaintext;

                $folder = array('type' => "file",
                                'title' => $title,
                                'href' => $filename);
                $resources[] = $folder;
            }
        }
        $this->output
                ->set_output(json_encode(array('resources' => $resources)));
    }
    
    public function item()
    {
        $this->login();
        
        $cookie = $this->session->userdata('cookie');
        $cookiepath = realpath($cookie);
        
        $item = $this->input->post('item');
        
        $path = getcwd();
        $temp_path = $path . "/temp/";
        
        if (!is_dir($temp_path))
                 mkdir($temp_path, 0777, true);
        
        $name = explode("/", $item);
        $newname = end( $name );
        $newname = str_replace(' ', '+', $newname);
        $newname = strtoupper($newname);

        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="'.$newname.'"');
        
        $curl = curl_init();
        curl_setopt ($curl, CURLOPT_BINARYTRANSFER, 1);
        curl_setopt ($curl, CURLOPT_FOLLOWLOCATION, 0);
        curl_setopt ($curl, CURLOPT_RETURNTRANSFER, 0);
        curl_setopt($curl, CURLOPT_COOKIEFILE, $cookiepath);
        curl_setopt ($curl, CURLOPT_URL, $item);

        $result2 = curl_exec($curl);

        $fh = fopen("temp/" . $newname,'w');
        fwrite($fh,$result2);
        fclose($fh);
        
        echo '<a href="'. $path ."/temp/" . $newname .'"></a>';
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
        if ($username == null || $password == null) {
            echo "Empty Username or Password";
            ;
            die;
        }

        $auth = array(
            'eid' => $username,
            'pw' => $password,
        );

        $url = "https://vula.uct.ac.za/portal/relogin";

        $cookie = tempnam("/tmp", md5($username . $this->salt()));

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

        if ($resultStatus['url'] == "https://vula.uct.ac.za/portal") { //if redirected it means its logged in
            $newdata = array(
                'cookie' => $cookie,
                'logged_in' => TRUE
            );
            $this->session->set_userdata($newdata);
        } else {
            echo "Incorrect Username or Password";
            die;
        }
    }

    //returns random num from 10000 - 99999
    public function salt() {
        $found = false;
        while (!$found) {
            $x = rand(0, 99999);
            if ($x < 10000)
                $x = rand(0, 99999);
            else
                $found = true;
        }
        return (string) $x;
    }

}

?>
