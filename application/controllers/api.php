<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Api extends CI_Controller 
{
    public function __construct() 
    {
        parent::__construct();
    }
    
    public function Api()
    {
        
    }
    
    public function index()
    {
        $data['title'] = "VulaMobi API";
        
        $this->load->view('templates/header', $data);
        $this->load->view('public/api.php', $data); 
        $this->load->view('templates/footer', $data);
    }
}
?>
