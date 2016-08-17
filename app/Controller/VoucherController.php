<?php

/**
 * All action about Products And Sales
 */
require("../Vendor/pusher-http-php-master/lib/Pusher.php");
require("../Vendor/phpmailer/PHPMailerAutoload.php");
require("../Vendor/pushbots/PushBots.class.php");

class VoucherController extends AppController {

    public function __construct($request = null, $response = null) {
          $this->layout = 'default_business';
        $this->set('title_for_layout', 'Vouchers');
        parent::__construct($request, $response);
    }
	
	
	public function index(){
		
		
		$vouchers = $this->getAllVouchers();
		$this->set('vouchers', $vouchers);
	}
	
	public function getAllVouchers(){
	
	$company = $this->Session->read('CompanyLoggedIn');
	
		$sql = "select * from services_vouchers
		inner join offers on offers.id = services_vouchers.offer_id
		inner join users on users.id = services_vouchers.user_id
		inner join services on services.id = services_vouchers.service_id
		inner join subclasses on subclasses.id = services.subclasse_id
		inner join checkouts on checkouts.id = services_vouchers.checkout_id
		where services_vouchers.company_id = {$company['Company']['id']};";
		  $params = array(
            'Service' => array(
                'query' => $sql
            )
        );
        return $this->AccentialApi->urlRequestToGetData('Services', 'query', $params);
		
	}
		
 
}
