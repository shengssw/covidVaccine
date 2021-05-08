<?php
    /**
     * Load the model and view
     */

     class Controller {
         public function model($model) {
             // require model file
             require_once '../app/models/'. $model . '.php';

             // Instantiate model
             return new $model();
         }

         public function view($view, $data=[]) {
             //check view file
             if (file_exists('../app/views/'. $view. '.php')) {
                 require_once '../app/views/'. $view. '.php';
             } else {
                 die("View does not exist.");
             }
         }
     }

?>