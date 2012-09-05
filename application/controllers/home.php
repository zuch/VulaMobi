<?php
class Home extends CI_Controller 
{
    
    public function index()
    {
        $data['title'] = "VulaMobi"; // Capitalize the first letter
        
        $this->load->view('templates/header', $data);
        $this->load->view('public/index.php', $data); 
        $this->load->view('templates/footer', $data);
    }
}

?>
