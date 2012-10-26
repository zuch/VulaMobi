<?php

/* Sascha Watermeyer - WTRSAS001
 * VulaMobi CS Honours project
 * saschawatermeyer@gmail.com */

header('Access-Control-Allow-Origin: *');

class Test extends CI_Controller 
{
    public function __construct() 
    {
        parent::__construct();
    }
    
    public function Test() 
    {
        //show_404();
    }
    
    public function t()
    {
        echo "hello from nightmare";
    }
    
    public function json()
    {
        $obj = '[{"Language":"jQuery","ID":"1"},{"Language":"C#","ID":"2"},
                {"Language":"PHP","ID":"3"},{"Language":"Java","ID":"4"},
                {"Language":"Python","ID":"5"},{"Language":"Perl","ID":"6"},
                {"Language":"C++","ID":"7"},{"Language":"ASP","ID":"8"},
                {"Language":"Ruby","ID":"9"}]';
        echo json_encode($obj);
    }
    
    public function request()
    {
        $this->login();
        
        $cookie = $this->session->userdata('cookie');
        $cookiepath = realpath($cookie);
        
        $urls = array('https://vula.uct.ac.za/portal/pda/',
                      'http://people.cs.uct.ac.za/~swatermeyer/VulaMobi/ajax.php?student/sites');
        
        $content = array();
        foreach($urls as $url)
        {
            //POST fields
            $auth = array(
            'username' => "wtrsas001",
            'password' => "honours",
            );
            
            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $auth);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_COOKIEFILE, $cookiepath);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);

            $response = curl_exec($curl);
            
            //getinfo
            $info = curl_getinfo($curl);
            $content[] = array($url,$info['total_time'],$info['size_upload'],$info['size_download'],$info['speed_upload'],$info['speed_download']);
            
            echo "+++++++++++++++++++++++++++++++++++++++++++++++++++++</br>";
            echo "url: " . $url. "</br>";
            echo "total_time: " . $info['total_time'] . "</br>";
            echo "size_upload: " . $info['size_upload'] . "</br>";
            echo "size_download: " . $info['size_download'] . "</br>";
            echo "speed_upload: " . $info['speed_upload'] . "</br>";
            echo "speed_download: " . $info['speed_download'] . "</br>";
            echo "+++++++++++++++++++++++++++++++++++++++++++++++++++++</br>";
            echo $response."</br>";
            echo "+++++++++++++++++++++++++++++++++++++++++++++++++++++</br>";
            curl_close($curl);
        }
        
        //write csv file
        $fp = fopen('tests/url_test.csv', 'w');
        foreach ($content as $fields) 
        {
            fputcsv($fp, $fields);
        }
        fclose($fp);
    }
    
    //login Vula
    public function login() 
    { 
        $username = "wtrsas001";
        $password = "honours";

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
