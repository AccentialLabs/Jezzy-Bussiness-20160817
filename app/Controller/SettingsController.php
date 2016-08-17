<?php
/**
 * All action about company settings
 */
class SettingsController extends AppController {

    public function __construct($request = null, $response = null) {
        $this->layout = 'default_business';
        $this->set('title_for_layout', 'Configurações');
        parent::__construct($request, $response);
    }
    
    public function beforeFilter() {
        if($this->Session->read('userLoggedType') != 1){
            $this -> render('../Errors/wrong_way');
            //TODO: enviar e-mail para responsavel da empresa avisando da tentativa.
        }
        parent::beforeFilter();
    }

    public function index() {
	date_default_timezone_set("America/Sao_Paulo");
        if ($this->request->is('post')) {
            $this->saveSocialNetworkCompany($this->request->data);
            $this->savePortageValue($this->request->data);
            $this->saveCompanyInfomation($this->request->data);
			
			//redireciona para dashboard
			$this->redirect(array('controller' => 'dashboard', 'action' => 'index'));
        }
        $this->set('social', $this->Session->read('compSocial.companies_social_networks'));
        $this->set('company', $this->Session->read('CompanyLoggedIn'));
        $this->set('companyPreference', $this->getCompanyPreferences($this->Session->read('CompanyLoggedIn.Company.id')));
		
		
    }
    
    // <editor-fold  defaultstate="collapsed" desc="Private Methods">
    /**
     * Gets company preferences like number of days to send somethig.
     * @param ind $companyId
     * @return Array
     */
    private function getCompanyPreferences($companyId){
        $prefComp = "select * from company_preferences where company_id  = {$companyId};";
        $prefsComp = array(
            'User' => array(
                'query' => $prefComp
            )
        );
        return $this->AccentialApi->urlRequestToGetData('users', 'query', $prefsComp);
    }


    /**
     * Function for save basic information about the company
     * @param Array $post
     * @return boolean
     */
    private function saveCompanyInfomation($post) {
        $params ['Company'] = $post['Company'];
        if(!empty($this->request->data ['Company']['logo']['name'])){
			$compId = $this->Session->read('CompanyLoggedIn.Company.id');
        // $upload = $this->AccentialApi->uploadFileComp('jezzy/uploads/company-'.$compId.'/config', $this->request->data ['Company'] ['logo']);
		//$upload = $this->AccentialApi->uploadFileComp('jezzy/uploads/company-'.$compId.'/config', $this->request->param ['Company'] ['logo'], $compId);
			$upload = $this->AccentialApi->uploadAnyPhotoCompany('jezzy/uploads/company-'.$compId.'/config', $this->request->data ['Company'] ['logo'], $compId);
		$params ['Company'] ['logo'] = $upload;
        }else {
            $params ['Company'] ['logo'] =  $this->Session->read('CompanyLoggedIn.Company.logo');
        }
        $params ['Company'] ['id'] = $this->Session->read('CompanyLoggedIn.Company.id');
        $cadastro = $this->AccentialApi->urlRequestToSaveData('companies', $params);
        if (is_null($cadastro)) {
            $arrayParams = array(
                'Company' => array(
                    'conditions' => array(
                        'Company.id' => $this->Session->read('CompanyLoggedIn.Company.id')
                    )
                )
            );
            $comp = $this->AccentialApi->urlRequestToGetData('companies', 'all', $arrayParams);
            $this->Session->write('CompanyLoggedIn.Company', $comp [0]['Company']);
            return true;
        }
        return false;
    }

    /**
     * Function for save the Portage information
     * @param Array $post
     * @return boolean
     */
    private function savePortageValue($post) {
        $savePortage = false;
        $params ['CompanyPreference'] = $post ['CompanyPreference'];
        $params ['CompanyPreference'] ['id'] = $this->Session->read('CompanyLoggedIn.CompanyPreference.id');
        $cadastro = $this->AccentialApi->urlRequestToSaveData('companies', $params);
        if (is_null($cadastro)) {
            $savePortage = true;
        }
        return $savePortage;
    }

    /**
     * Function for save tje social media information
     * @param Array $post
     * @return boolean
     */
    private function saveSocialNetworkCompany($post) {
        $socialNetworkSave = false;
        extract($post);
        if (!isset($fbkOffers)) {
            $fbkOffers = "INACTIVE";
        }
        if (!isset($twtOffers)) {
            $twtOffers = "INACTIVE";
        }
        if (!isset($gplusOffers)) {
            $gplusOffers = "INACTIVE";
        }
        $face = 'INACTIVE';
        $twt = 'INACTIVE';
        $gplus = 'INACTIVE';
        if (!empty($fbkLink)) {
            $face = 'ACTIVE';
        }
        if (!empty($twtLink)) {
            $twt = 'ACTIVE';
        }
        if (!empty($gplusLink)) {
            $gplus = 'ACTIVE';
        }
		
		$compSocial = $this->Session->read('compSocial.companies_social_networks.id');
        if (empty($compSocial)) {
            $sqlSocial = "insert into companies_social_networks(company_id, facebook, fbk_link, fbk_new_offers, twitter, twitter_link, twitter_new_offers, google_plus, gplus_link, gplus_new_offers) "
                    . "values({$this->Session->read('CompanyLoggedIn.Company.id')}, "
                    . "'{$face}', '{$fbkLink}', '{$fbkOffers}',"
                    . "'{$twt}', '{$twtLink}', '{$twtOffers}', "
                    . "'{$gplus}', '{$gplusLink}', '{$gplusOffers}');";
            $paramsSql = array('User' => array('query' => $sqlSocial));
            $result = $this->AccentialApi->urlRequestToGetData('users', 'query', $paramsSql);
        } else {
            $sqlSocial = "update companies_social_networks set facebook='{$face}', fbk_link='{$fbkLink}', fbk_new_offers='{$fbkOffers}',"
                    . " twitter='{$twt}', twitter_link='{$twtLink}', twitter_new_offers='{$twtOffers}', "
                    . "google_plus='{$gplus}', gplus_link='{$gplusLink}', gplus_new_offers='{$gplusOffers}' "
                    . "where id = {$this->Session->read('compSocial.companies_social_networks.id')};";
            $paramsUp = array('User' => array('query' => $sqlSocial));
            $result = $this->AccentialApi->urlRequestToGetData('users', 'query', $paramsUp);
        }
        $this->GeneralFunctions = $this->Components->load('GeneralFunctions');
        $this->GeneralFunctions->setSocialNetworkSession($this->Session->read('CompanyLoggedIn.Company.id'));
        if (is_null($result)) {
            $socialNetworkSave = true;
        }
        return $socialNetworkSave;
    }
    //</editor-fold>
}
