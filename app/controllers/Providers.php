<?php 

/**
 * Default controller for provider
 * 
 * @author Sheng
 */

class Providers extends Controller{
    public function __construct()
    {
        //$this->userModel = $this->model('User');

    }

    public function Dashboard() {
        
        $this->view('providers/Dashboard');
    }

    public function addapps(){
        $this->view('providers/addapps');
    } 

   

}


?>