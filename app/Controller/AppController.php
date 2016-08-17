<?php

App::uses('Controller', 'Controller');

class AppController extends Controller {

    public $components = array('Session','AccentialApi','Cookie');
    
    public function beforeFilter() {
	
		$ssst = split("/", $this->here);
		$sssst2 = array_reverse($ssst);
		
		$xxxt = split("/", $this->here);
		$xxxt2 = array_reverse($xxxt);
		
        if($sssst2 [0] !== "login" && $xxxt2[1] !== "login"){
            if ($this->Session->check("sessionLogado") === false || $this->Session->check("CompanyLoggedIn") === false) {
                $this->redirect(array('controller' => 'Login', 'action' => 'index'));
            }
        } 
    }
    
}
