<?php

class Core{


	protected $currentController = 'Pages';
	protected $currentMethod = 'index';
	protected $params  = [];

	public function __construct(){

		if(!$url = $this->getUrl()){
			$url = array("pages","index");
		}
     

        if(file_exists('../app/controllers/'.ucwords($url[0]).'.php')){
            
            $this->currentController = ucwords($url[0]);
            unset($url[0]); 
        } else {
			$this->notfound("Couldn't find a matching controller.");
		}

          
         require_once '../app/controllers/'.$this->currentController.'.php';

         $this->currentController = new $this->currentController();

		 if(isset($url[1])){
			// Check to see if method exists in controller
			if(method_exists($this->currentController, $url[1])){
			  $this->currentMethod = $url[1];
			  // Unset 1 index
			  unset($url[1]);
			} else {
                $this->notfound("Couldn't find a matching method in a controller.");
            }
		  }

		  $this->params = $url ? array_values($url) : [];
		 // Call a callback with array of params
		  call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
	}

	public function getUrl(){

	    // NOTE: checking $_REQUEST['url'] instead of $_GET because we need to route POST and other methods also
		if(isset($_REQUEST['url']) && trim($_REQUEST['url']) != ''){

		$url = rtrim($_GET['url'], '/');
		$url = filter_var($url, FILTER_SANITIZE_URL);

		return explode('/', $url);
	    }
	}

	public static function notfound($message = null){

	    $url = $_REQUEST['url'];

	    if (!isset($message)){
	        $message = _("We're sorry, $url could not be found.");
        }

        $message .= " (HTTP 404 - $url)";

        header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found", true, 404);
	    echo $message;
	    exit();
    }

	public static function unauthorized($message = null){

		$url = $_REQUEST['url'];

		if (!isset($message)){
			$message = _("We're sorry, you don't have permission to access $url.");
		}

		$message .= " (HTTP 403 - Unauthorized)";

		header($_SERVER["SERVER_PROTOCOL"]." 403 Unauthorized", true, 403);
		echo $message;
		exit();
	}
}



?>