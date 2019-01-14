<?php
/**
 * Created by PhpStorm.
 * User: astro
 * Date: 25-Feb-18
 * Time: 10:24
 */

class MarketplaceSession {
	
	public $loginuser;

	public function __construct($postdata){
		$email = $postdata['email'];
		$password = $postdata['password'];

		if($loginuser = $this->checkpassword($email,$password)){
			if (!$this->checkGlobalGuards($loginuser)){
				die("Global guards failed - should not see this message (403 should have occurred)!");
			}
			if(!$this->createUserSession($loginuser)){
				die("Error creating user session!");
			}
		} else {
			$redirect = new Pages();
			$redirect->view("pages/index",['message' => _('Bad username or password')]);
			exit();
		}
		// everything should be fine!
		$this->loginuser = $loginuser;
	}

	private function checkpassword($email,$password){
		if($loginuser = User::getUserByParam('email',$email)) {
			if ($loginuser->recordObject->password == md5($password)) {
				return $loginuser;
			} else {
				return false;
			}
		}
		// shouldn't get here, but if we do, return false!
		return false;
	}

	private function checkGlobalGuards($loginuser){

		// if the user is 'deleted', redirect to the index as if the account did not exist
		if($loginuser->hasRole('deleted')){
			$redirect = new Pages();
			$redirect->view('pages/index');
		}

		// if the user is locked, 403 and say so
		if($loginuser->hasRole('locked')){
			Core::unauthorized('User account locked');
		}

		// no login at all if maintenance mode is on
		if(MAINTENANCE === true){
			$redirect = new Pages();
			$redirect->view('pages/index',['message' => _('Login disabled in maintenance mode')]);
		}
		// adding a control here so that in devmode only super admins can log in
		$adminroles = array( 'Super administrator' );
		if ( DEVMODE === true && ! $loginuser->hasRole( $adminroles ) ) {
			unset( $loginuser );
			$redirect = new Pages();
			$redirect->view('pages/index',['message' => _('Login restricted in development mode')]);
			exit();
		}
		return true;
	}

	private function createUserSession($loginuser){
		$userRecordObject = $loginuser->recordObject;

		$_SESSION['userid']        = $userRecordObject->uid;
		$_SESSION['status']        = $userRecordObject->status;

		return true;
	}
}