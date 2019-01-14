<?php


class Controller {

	public $loggedInUser;

	public function __construct() {
		/*
		 * In the controller constructor we will create the $loggedInUser object
		 * to always be available to all controllers.
		 */
		// if(isset($_SESSION['userid'])){
		// 	$this->loggedInUser = new User($_SESSION['userid']);
		// } else {
		// 	unset($this->loggedInUser);
		// }
	}

	public function model($model){

		require_once('../app/models/'. $model . '.php');

		return new $model();

	}

	public function view($view, $data = []){

		if(file_exists('../app/views/'. $view . '.php')){

			require_once '../app/views/'. $view . '.php';

		}else{
			Core::notfound("Page Not Found ($view)");
		}

	}

}


?>