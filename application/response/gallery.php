<?php

/* Sascha Watermeyer - WTRSAS001
 * Vulamobi CS Honours project
 * sascha.watermeyer@gmail.com */

include_once 'simple_html_dom.php';

class Gallery extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function Gallery() {
        //show_404();
    }

    public function dir() {
        if ($this->session->userdata('logged_in')) {
            $username = $this->session->userdata('username');

            //Globals
            //$base_url = "http://people.cs.uct.ac.za/~swatermeyer/VulaMobi/uploads/";
            $dir = "./uploads/" . $username . "/";
            $files = array();


            if (is_dir($dir)) {
                $dh = opendir($dir);
                $files = array();

                while (($file = readdir($dh)) !== false) {
                    if ($file != '.' AND $file != '..') {
                        if (filetype($dir . $file) == 'file') {
                            $files[] = array(
                                'name' => $file,
                                'size' => filesize($dir . $file) . ' bytes',
                                'date' => date("F d Y H:i:s", filemtime($dir . $file)),
                                'path' => $dir . $file,
                            );
                        }
                    }
                }
            } else {
                echo "path doesn't exist";
            }
            closedir($dh);

            echo json_encode(array('files' => $files));
        } else {//NOT logged in
            $this->session->sess_destroy();
            echo 'logged_out';
        }
    }

    //upload image to uploads/user_id
    public function upload() 
    {
        if ($this->session->userdata('logged_in')) 
        {
            $username = $this->session->userdata('username');

            //$path = getcwd();

            $upload_path = "./uploads/" . $username . "/";

            //create path for user if not initialised
            if (!is_dir($upload_path)) 
            {
                mkdir($upload_path, 0700);
            }
                
            if (isset($_REQUEST['image'])) 
            {
                if ($_REQUEST['image']) 
                {
                    $imgData = base64_decode($_REQUEST['image']);

                    $file = $upload_path . date('Ymdgisu') . '.jpg';
                    if (file_exists($file)) 
                    {
                        unlink($file);
                    }
                    error_log("Error to check if file exists");
                    $fp = fopen($file, 'w');
                    fwrite($fp, $imgData);
                    fclose($fp);
                    echo "done";
                }
            } 
            else 
            {
                echo "</br>";
                echo "not_set";
            }
        } 
        else 
        {//NOT logged in
            $this->session->sess_destroy();
            echo 'logged_out';
        }
    }

}

?>
