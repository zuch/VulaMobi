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
        
        if (!is_dir('tests'))
                 mkdir('tests', 0777, true);
        
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
            
            $total_time = array();
            $size_upload = array();
            $size_download = array();
            $speed_upload = array();
            $speed_download = array();
            for($i = 0;$i < 5; $i++)
            {
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
                $total_time[] = $info['total_time'];
                $size_upload[] = $info['size_upload'];
                $size_download[] = $info['size_download'];
                $speed_upload[] = $info['speed_upload'];
                $speed_download[] = $info['speed_download'];
            }
            
            $total = 0;
            foreach($total_time as $val)
                $total += $val;
            
            $total_time_avg = $total/count($total_time);
            
            $total_1 = 0;
            foreach($size_upload as $val)
                $total += $val;
            
            $size_upload_avg = $total_1/count($total_time);
            
            $total_2 = 0;
            foreach($size_download as $val)
                $total_2 += $val;
            
            $size_download_avg = $total_2/count($total_time);
            
            $total_3 = 0;
            foreach($speed_upload as $val)
                $total_3 += $val;
            
            $speed_upload_avg = $total_3/count($total_time);
            
            $total_4 = 0;
            foreach($speed_download as $val)
                $total_4 += $val;
            
            $speed_download_avg = $total_4/count($total_time);
            
            $content[] = array($url,
                               $total_time_avg,
                               $size_upload_avg,
                               $size_download_avg,
                               $speed_upload_avg,
                               $speed_download_avg );
            
            echo "+++++++++++++++++++++++++++++++++++++++++++++++++++++</br>";
            echo "url: " . $url. "</br>";
            echo "total_time: " . $total_time_avg . "</br>";
            echo "size_upload: " . $size_upload_avg . "</br>";
            echo "size_download: " . $size_download_avg . "</br>";
            echo "speed_upload: " . $speed_upload_avg . "</br>";
            echo "speed_download: " . $speed_download_avg . "</br>";
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
