<?php

/* Donovan Thomson
 * VulaMobi CS Honours project
*/

header('Access-Control-Allow-Origin: *');  

include_once 'simple_html_dom.php';

class Understanding extends CI_Controller 
{
    public function __construct() 
    {
        parent::__construct();
    }
    
    public function Understanding() 
    {
        //show_404();
    }
    
    public function update()
    {
    	
    	//gets the JSON Object
    	$understandingsEnc = $this->input->post('Understandings');
    	//decodes it to a standard array
    	$understandings = json_decode($understandingsEnc, true);
    	//gets the student Number
    	$Studentnum = $this->input->post('studentNumber');
    	//gets the course ID
    	$CourseId = $this->input->post('CourseID');
    	
    	$QueryString = 'SELECT * FROM weightingtable WHERE Course = "CSC honours, 2012" AND Year = "2012"';
    	$query = $this->db->query($QueryString);
    	
    	//saves the result to the understanding db
    	
    	//1) Cleans db of all understandings for selected course
    	//$QueryString = 'SELECT * FROM weightingtable';
    //	$QueryString = 'Delete FROM studentunderstanding WHERE CourseID = "'.$CourseId.'" AND Studentnumber = "'.$Studentnum.'"';
    //	$this->db->query($QueryString);
    	//gets weightings from sql database -> think about the ordering later (need to get course name and year but will hardcode for now
    	//$QueryString = 'SELECT * FROM weightingtable WHERE Course = "CSC honours, 2012" AND Year = "2012"';
    //	$query = $this->db->query('SELECT * FROM weightingtable WHERE Course = "CSC honours, 2012" AND Year = "2012"');
    	//2) then loops through the understandings array and adds each compnent
    	
    	$Count =0;

    	
    	foreach ( $understandings as $item )
    	{
    		//$itemstring = "INSERT INTO studentunderstanding (ResourceName,Understanding,StudentNumber,CourseID) VALUES
    		//	('$understandings[$Count][0]',$understandings[$Count][1],'$Studentnum',$CourseId,$submin)";
    		//$query1 = $this->db->query($itemstring);
    		 
    		$Count++;
    	}
     	
    	$this->output->set_output($Count);
    	
    	
   	
        
    }
}

?>
