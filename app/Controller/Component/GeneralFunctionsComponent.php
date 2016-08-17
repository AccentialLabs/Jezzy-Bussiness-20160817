<?php

App::uses('AccentialApi', 'Controller/Component');

/**
 * General functions for this project
 */
class GeneralFunctionsComponent extends Component {

    public $components = array('Session');

    /**
     * Just to test this class.
     */
    public function generalFunctionsTestMethod() {
        return "Retorno: generalFunctionsTestMethod - CLASS: GeneralFunctionsComponent";
    }

    /**
     * Calculate age give the birthdate
     */
    public function ageBybirthday($data) {
        list ( $dia, $mes, $ano ) = explode('/', $data);
        $hoje = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        $nascimento = mktime(0, 0, 0, $mes, $dia, $ano);
        $idade = floor((((($hoje - $nascimento) / 60) / 60) / 24) / 365.25);
        return $idade;
    }

    /**
     * Generate new random password
     */
    public function generateRandomPassword() {
        $alphabet = "23456789bcdefghijklmnopqrstuwxyzBCDEFGHIJKLMNOPQRSTUWXYZ";
        $pass = array();
        $alphaLength = strlen($alphabet) - 1;
        for ($i = 0; $i < 8; $i ++) {
            $n = rand(0, $alphaLength);
            $pass [] = $alphabet [$n];
        }
        return implode($pass);
    }

    //TODO: arrumar este metodo. Muito connfuso e poucas chances de sucesso assim.
    /**
     * Send e-mail
     */
    public function postEmail($api, $type, $params) {
        $this->CurlRequest = new CurlRequestComponent(new ComponentCollection());
        return $this->CurlRequest->curlRequest("http://localhost/accential/jezzy-sendmail/$api/$type.php", $params);
    }

    /**
     * Set or update the session with social network information
     */
    public function setSocialNetworkSession($companyId) {
        $sqlSocial = "select * from companies_social_networks where company_id = {$companyId};";
        $paramsSocial = array(
            'User' => array(
                'query' => $sqlSocial
            )
        );
        $this->AccentialApi = new AccentialApiComponent(new ComponentCollection());
        $social = $this->AccentialApi->urlRequestToGetData('users', 'query', $paramsSocial);

        $this->Session->write("compSocial", $social[0]);
    }

    /**
     * Convert br date format to database
     */
    public function convertDateBrazilToSQL($brFormatDate) {
        return implode('-', array_reverse(split('/', $brFormatDate)));
    }
    
    /**
     * Return only the number of string
     */
    public function onlyNumbers($str){
        return preg_replace("/[^0-9]/", "", $str);
    }

}
