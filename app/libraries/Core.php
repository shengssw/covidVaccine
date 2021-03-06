<?php
    /**
     * Core App Class for the application
     * 
     * @author Sheng
     */

    class Core {
        protected $currentController = 'Pages';
        protected $currentMethod = 'index';
        protected $params = [];

        public function __construct()
        {
            $url = $this->getUrl();
            //print_r($url);

            // Check if corresponding controller file exists;
           if (file_exists('../app/controllers/'. ucwords($url[0]). '.php')) {
                // Overwrite if exist
                $this->currentController = ucwords($url[0]);
                unset($url[0]);
            }

            // Require the controller
            require_once '../app/controllers/' . $this->currentController . '.php';
            $this->currentController = new $this->currentController; 

            // Check the second part of url
            if (isset($url[1])) {
                if (method_exists($this->currentController, $url[1])) {
                    $this->currentMethod = $url[1];
                    unset($url[1]);
                }
            }

            // Get parameters
            $this->params = $url ? array_values($url) : [];

            // Call a callback with array of params
            call_user_func_array([$this->currentController, $this->currentMethod],$this->params);
        }

        public function getUrl() {
            if(isset($_GET['url'])) {
                $url = rtrim($_GET['url'], '/');
                // Not allowing charaters that url should not have
                $url = filter_var($url, FILTER_SANITIZE_URL); 
                // Break url into array (/patient/preference -> [patient, preference])
                $url = explode('/', $url);
                return $url;
            }
        }

    }

?>