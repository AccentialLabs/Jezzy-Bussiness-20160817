<?php 

class LoginMobileController extends AppController {

    public function __construct($request = null, $response = null) {
        $this->layout = '';
        parent::__construct($request, $response);
    }
	
	public function beforeFilter() {
        if ($this->action !== "logout") {
            
        }
    }
	
	public function autoLogin(){
		$this->autoRender = false;
		
		$data['dado1'] = "dado1";
		$data['dado2'] = "dado2";
		$data['dado3'] = "dado3";
		$data['dado4'] = "dado4s";
	
		echo json_encode($data);
	}
	
	}