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
}
?>
