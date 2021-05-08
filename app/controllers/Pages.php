<?php 

/**
 * Default controller for pages 
 * 
 * @author Sheng
 */

class Pages extends Controller{
    public function __construct()
    {
        $this->userModel = $this->model('User');
       
    }

    public function index() {
        $user = $this->userModel->getUsers();

        $data = [
            'users' => $user
        ];

        $this->view('pages/index', $data);
    }

    public function about() {
        echo "about";
    }
}


?>