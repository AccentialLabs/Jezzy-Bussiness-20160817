<?php
/**
 * All action about Sales Report
 */
class SaleReportController extends AppController {

    public function __construct($request = null, $response = null) {
        $this->layout = 'default_business';
        $this->set('title_for_layout', 'Rel.Vendas');
        parent::__construct($request, $response);
    }

    /**
     * Show populated view
     */
    public function index() {
        $company = $this->Session->read('CompanyLoggedIn');
        $this->set('allSales', $this->getAllSales($company));
        $this->set('allSalesDone', $this->getAllSalesDone($company));
        $this->set('allSalesPending', $this->getAllSalesPending($company));
		$this->set('allSalesCommissioned', $this->getAllSalesByComission($company));
    }

    /**
     * Get the information to generate the tag for shipping
     * @return boolean or json with information
     */
    public function getTagInfomation() {
        $this->autoRender = false;
        if ($this->request->is('post') && isset($this->request->data['Checkout']['id'])) {
            $params = array(
            'Checkout' => array(
                'conditions' => array(
                    'Checkout.id' => $this->request->data['Checkout']['id']
                ),
                'order' => array(
                    'Checkout.id' => 'DESC'
                ),
            ),
            'PaymentState',
            'Offer',
            'User',
            'OffersUser'
        );
        $todasCompras = $this->AccentialApi->urlRequestToGetData('payments', 'all', $params);
            if(!empty($todasCompras)){
                return json_encode($todasCompras);
            }
        } 
        return false;
    }

    // <editor-fold  defaultstate="collapsed" desc="Private Methods">
    /**
     * Gets all sales for this company
     * @param type $company
     * @return array whith all checkout products
     */
    private function getAllSales($company) {
        $params = array(
            'Checkout' => array(
                'conditions' => array(
                    'Checkout.company_id' => $company['Company'] ['id']
                ),
                'order' => array(
                    'Checkout.id' => 'DESC'
                ),
            ),
            'PaymentState',
            'Offer',
            'User',
            'OffersUser'
        );
        $todasCompras = $this->AccentialApi->urlRequestToGetData('payments', 'all', $params);
        $todasWithComment = '';
		if(!empty($todasCompras)){
        foreach ($todasCompras as $compra) {
            $arrayParams = array(
                'OffersComment' =>
                array(
                    'conditions' => array(
                        'OffersComment.offer_id' => $compra['Offer']['id'],
                        'OffersComment.user_id' => $compra['User']['id']
                    )),
            );
            $comentario = $this->AccentialApi->urlRequestToGetData('offers', 'first', $arrayParams);
            $compra['OffersComment'] = $comentario['OffersComment'];
            $todasWithComment[] = $compra;
        }}
        return $todasWithComment;
    }

    /**
     * Gets all sales done for this company
     * @param type $company
     * @return array whith all checkout products status done
     */
    private function getAllSalesDone($company) {
        $params = array(
            'Checkout' => array(
                'conditions' => array(
                    'Checkout.company_id' => $company['Company'] ['id'],
                    'Checkout.payment_state_id' => 4
                ),
                'order' => array(
                    'Checkout.id' => 'DESC'
                ),
                'limit' => 5
            ),
            'PaymentState',
            'Offer',
            'User',
            'OffersUser'
        );
        $finalizadas = $this->AccentialApi->urlRequestToGetData('payments', 'all', $params);
        $finalizadasWithComment = '';
		if(!empty($finalizadas)){
        foreach ($finalizadas as $compra) {
            $arrayParams = array(
                'OffersComment' =>
                array(
                    'conditions' => array(
                        'OffersComment.offer_id' => $compra['Offer']['id'],
                        'OffersComment.user_id' => $compra['User']['id']
                    )),
            );
            $comentario = $this->AccentialApi->urlRequestToGetData('offers', 'first', $arrayParams);
            $compra['OffersComment'] = $comentario['OffersComment'];
            $finalizadasWithComment[] = $compra;
        }}
        return $finalizadasWithComment;
    }

    /**
     * Gets all sales pending for this company
     * @param type $company
     * @return array whith all checkout products status Pending
     */
    private function getAllSalesPending($company) {
        $params = array(
            'Checkout' => array(
                'conditions' => array(
                    'Checkout.company_id' => $company['Company'] ['id'],
                    'Checkout.payment_state_id <> ' => 4,
                    'NOT' => array(
                        'Checkout.payment_state_id' => array(
                            '999'
                        )
                    )
                ),
                'order' => array(
                    'Checkout.id' => 'DESC'
                ),
                'limit' => 5
            ),
            'PaymentState',
            'Offer',
            'User',
            'OffersUser'
        );
        $pendentes = $this->AccentialApi->urlRequestToGetData('payments', 'all', $params);
        $pendentesWithComment = '';
		if(!empty($pendentes)){
        foreach ($pendentes as $compra) {
            $arrayParams = array(
                'OffersComment' =>
                array(
                    'conditions' => array(
                        'OffersComment.offer_id' => $compra['Offer']['id'],
                        'OffersComment.user_id' => $compra['User']['id']
                    )),
            );
            $comentario = $this->AccentialApi->urlRequestToGetData('offers', 'first', $arrayParams);
            $compra['OffersComment'] = $comentario['OffersComment'];
            $pendentesWithComment[] = $compra;
        }}
        return $pendentesWithComment;
    }
	
	   
    public function getCheckoutDetail() {
	   $this->layout = '';
	   $id = $this->request->data['checkoutId'];
	   $query = "select * from checkouts inner join users on users.id = checkouts.user_id inner join payment_states on payment_states.id = checkouts.payment_state_id inner join payments_methods on payments_methods.id = checkouts.payment_method_id where checkouts.id = {$id};";
		$id = $this->request->data['checkoutId'];
	   
        $params = array(
            'User' => array(
                'query' => $query
            )
        );
        $todasCompras = $this->AccentialApi->urlRequestToGetData('users', 'query', $params);
		
	   $queryOffer = "select * from offers where id = {$todasCompras[0]['checkouts']['offer_id']};";
        $paramsOffer = array(
            'User' => array(
                'query' => $queryOffer
            )
        );
        $offer = $this->AccentialApi->urlRequestToGetData('users', 'query', $paramsOffer);
		
		
            
       $this->set('checkout', $todasCompras);
	    $this->set('offer', $offer);
    }
	
	public function getAllSalesByComission($company){

		$sql = "select * from checkouts inner join offers on offers.id = checkouts.offer_id where commissioned_company_id = {$company['Company'] ['id']}; ";
		$params = array(
            'User' => array(
                'query' => $sql
            )
        );
        $checkouts = $this->AccentialApi->urlRequestToGetData('users', 'query', $params);
		return $checkouts;
	
	}
	
	public function getAllSalesByMonth(){
	$this->layout = "";	
	
	$month = $this->request->data['month'];
	$company = $this->Session->read('CompanyLoggedIn');
		$params = array(
            'Checkout' => array(
                'conditions' => array(
                    'Checkout.company_id' => $company['Company'] ['id'],
					'MONTH(Checkout.date)' => $month
                ),
                'order' => array(
                    'Checkout.id' => 'DESC'
                ),
            ),
            'PaymentState',
            'Offer',
            'User',
            'OffersUser'
        );
        $todasCompras = $this->AccentialApi->urlRequestToGetData('payments', 'all', $params);
        $todasWithComment = '';
		if(!empty($todasCompras)){
        foreach ($todasCompras as $compra) {
            $arrayParams = array(
                'OffersComment' =>
                array(
                    'conditions' => array(
                        'OffersComment.offer_id' => $compra['Offer']['id'],
                        'OffersComment.user_id' => $compra['User']['id']
                    )),
            );
            $comentario = $this->AccentialApi->urlRequestToGetData('offers', 'first', $arrayParams);
            $compra['OffersComment'] = $comentario['OffersComment'];
            $todasWithComment[] = $compra;
        }}

		 $this->set('allSales', $todasWithComment); 
	}

    // </editor-fold>
}
