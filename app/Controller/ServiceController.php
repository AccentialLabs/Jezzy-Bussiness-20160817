<?php

class ServiceController extends AppController {

    public function __construct($request = null, $response = null) {
        $this->layout = 'default_business';
        $this->set('title_for_layout', 'Servicos');
        parent::__construct($request, $response);
    }

    public function beforeFilter() {
        if ($this->Session->read('userLoggedType') != 1 && $this->Session->read('userLoggedType') != 3) {
            $this->render('../Errors/wrong_way');
            //TODO: enviar e-mail para responsavel da empresa avisando da tentativa.
        }
        parent::beforeFilter();
    }

    public function index() {
        $company = $this->Session->read('CompanyLoggedIn');
        $this->set('allServices', $this->getAllServices($company));
		$this->set('allClasses', $this->getAllClasses());
    }

    /**
     * Updade all services, prices, values e users.
     * Its is done line by line.
     */
    public function updateServices() {
        if ($this->request->is('post')) {
            $company = $this->Session->read('CompanyLoggedIn');
            $post = $this->request->data;
            foreach ($post as $postKey => $postValue) {
                if (substr($postKey, -1) != "0") {
				
                    if (!empty($postValue['value']) && !empty($postValue['time']) && count($postValue['user']) > 0) {
                        $resutl = $this->editService($postValue, $company);
                    } else {
                        $resutl = $this->removeService($postValue, $company);
                    }
					
                } else {
                    if (!empty($postValue['value']) && !empty($postValue['time']) && count($postValue['user']) > 0) {
                        $resutl = $this->addService($postValue, $company);
                    }
                }
            }
            if ($resutl) {
                $this->Session->setFlash(__('Informações salvas com sucesso.'));
            } else {
                $this->Session->setFlash(__('Não foi possivel realizar esta requisição no momento.'));
            }
            $this->redirect("index");
        }
    }
	
	public function addSubclass(){
	
		if ($this->request->is('post')) {
		
			$name = $this->request->data['serviceName'];
			$id = $this->request->data['serviceCategory'];
		
			$query = "INSERT INTO subclasses(classe_id, name) VALUES({$id}, '{$name}');";
			
			$params = array(
            'General' => array(
                'query' => $query
            )
        );
			$servicesArr = unserialize(utf8_decode($this->AccentialApi->urlRequestToGetData('General', 'query', $params)));
			
		}
		$this->redirect("index");
	}
	
	public function getServiceByName(){
		
		$this->layout = '';
		
		$name = $this->request->data['searchService'];
		
		$query = "select * from subclasses inner join classes on classes.id = subclasses.classe_id where subclasses.name LIKE '{$name}%';";
			$params = array(
            'General' => array(
                'query' => $query
				)
			);
			$servicesArr = unserialize(utf8_decode($this->AccentialApi->urlRequestToGetData('General', 'query', $params)));
			
			$this->set("services", $servicesArr);
	
	}
	
	public function getServiceByNameForCompany(){
		$this->layout = '';
		
		$company = $this->Session->read('CompanyLoggedIn');
		$name = $this->request->data['searchService'];
		
		$query = "select * from subclasses inner join classes on classes.id = subclasses.classe_id inner join services on services.subclasse_id = subclasses.id where subclasses.name LIKE '{$name}%' and companie_id = {$company['Company']['id']};";
			$params = array(
            'General' => array(
                'query' => $query
				)
			);
			$servicesArr = unserialize(utf8_decode($this->AccentialApi->urlRequestToGetData('General', 'query', $params)));
			
			$this->set("services", $servicesArr);
	}
	
	public function getServiceByNameForCompanySelect(){
		$this->layout = '';
		
		$company = $this->Session->read('CompanyLoggedIn');
		
		$query = "select * from subclasses inner join classes on classes.id = subclasses.classe_id inner join services on services.subclasse_id = subclasses.id where companie_id = {$company['Company']['id']};";
			$params = array(
            'General' => array(
                'query' => $query
				)
			);
			$servicesArr = unserialize(utf8_decode($this->AccentialApi->urlRequestToGetData('General', 'query', $params)));
			
			$this->set("services", $servicesArr);
	}

    // <editor-fold  defaultstate="collapsed" desc="Private Methods">
    /**
     * Gets the return of all services with users and values and time
     * @param type $company
     * @return type
     */
    private function getAllServices($company) {
        $query = "
            SELECT  classes.*, subclasses.*, services.*,service_secondary_users.*,secondary_users.*  
            FROM services
            RIGHT JOIN subclasses 
                ON subclasses.id = services.subclasse_id
                AND services.companie_id = " . $company['Company'] ['id'] . "
            RIGHT JOIN classes
                ON classes.id = subclasses.classe_id
            LEFT JOIN service_secondary_users 
                ON service_secondary_users.service_id = services.id
            LEFT JOIN secondary_users 
                ON service_secondary_users.secondary_user_id = secondary_users.id
            ORDER BY classes.id ASC, subclasses.name ASC, secondary_users.id ASC";
        $params = array(
            'General' => array(
                'query' => $query
            )
        );
        $servicesArr = unserialize(utf8_decode($this->AccentialApi->urlRequestToGetData('General', 'query', $params)));
        $query = "SELECT * FROM secondary_users WHERE company_id = " . $company['Company'] ['id'] . " ORDER BY secondary_users.id ASC";
        $params = array(
            'General' => array(
                'query' => $query
            )
        );
        $usersArr = unserialize(utf8_decode($this->AccentialApi->urlRequestToGetData('General', 'query', $params)));
        return $this->organizeArrayOfServicesAndSecundaryUsers($servicesArr, $usersArr);
    }
	
	private function getAllClasses(){
		$query = "SELECT * FROM classes";
		$params = array(
            'General' => array(
                'query' => $query
            )
        );
        $classesArr = unserialize(utf8_decode($this->AccentialApi->urlRequestToGetData('General', 'query', $params)));
		return $classesArr;
	}

    /**
     * Just organize all the information to be easy to display
     */
    private function organizeArrayOfServicesAndSecundaryUsers($arrayRetorn, $sec_users) {
        $userArr = array();
        $count_services = 1;
        foreach ($sec_users as $user) {
            $userArr[$user['secondary_users']['id']]['id'] = $user['secondary_users']['id'];
            $userArr[$user['secondary_users']['id']]['name'] = $user['secondary_users']['name'];
			$userArr[$user['secondary_users']['id']]['excluded'] = $user['secondary_users']['excluded'];
            $userArr[$user['secondary_users']['id']]['has_service'] = false;
        }
		
        $organize = '';
        foreach ($arrayRetorn as $service) {
//            $organize[$service['classes']['name']]['id'] = $service['classes']['id'];
//            $organize[$service['classes']['name']]['name'] = $service['classes']['name'];
            $organize[$service['classes']['name']][$service['subclasses']['id']]['id'] = $service['subclasses']['id'];
            $organize[$service['classes']['name']][$service['subclasses']['id']]['subcategory_name'] = $service['subclasses']['name'];
            $organize[$service['classes']['name']][$service['subclasses']['id']]['service_id'] = $service['services']['id'] == "" ? $count_services . "_0" : $service['services']['id'];
            $organize[$service['classes']['name']][$service['subclasses']['id']]['service_value'] = $service['services']['value'] == "" ? 0 : $service['services']['value'];
            $organize[$service['classes']['name']][$service['subclasses']['id']]['service_time'] = $service['services']['time'] == "" ? 0 : $service['services']['time'];
            foreach ($userArr as $user) {
                $organize[$service['classes']['name']][$service['subclasses']['id']]['users'][$user['id']]['id'] = $user['id'];
                $organize[$service['classes']['name']][$service['subclasses']['id']]['users'][$user['id']]['name'] = substr($user['name'], 0, 3);
                $organize[$service['classes']['name']][$service['subclasses']['id']]['users'][$user['id']]['name_complete'] = $user['name'];
				$organize[$service['classes']['name']][$service['subclasses']['id']]['users'][$user['id']]['excluded'] = $user['excluded'];
                $organize[$service['classes']['name']][$service['subclasses']['id']]['users'][$user['id']]['has_service'] = false;
                $count_services++;
            }
        }
        reset($arrayRetorn);
        foreach ($arrayRetorn as $service) {
            if (!empty($service['secondary_users']['id'])) {
                $organize[$service['classes']['name']][$service['subclasses']['id']]['users'][$service['secondary_users']['id']]['id'] = $service['secondary_users']['id'];
                $organize[$service['classes']['name']][$service['subclasses']['id']]['users'][$service['secondary_users']['id']]['name'] = substr($service['secondary_users']['name'], 0, 3);
                $organize[$service['classes']['name']][$service['subclasses']['id']]['users'][$service['secondary_users']['id']]['name_complete'] = $service['secondary_users']['name'];
				$organize[$service['classes']['name']][$service['subclasses']['id']]['users'][$service['secondary_users']['id']]['excluded'] = $service['secondary_users']['excluded'];
                $organize[$service['classes']['name']][$service['subclasses']['id']]['users'][$service['secondary_users']['id']]['has_service'] = true;
            }
        }
        return $organize;
    }

    /**
     * Add service to company
     * @param type $serviceinfo
     * @return boo 
     */
    private function addService($serviceinfo, $company) {
        $returnVar = true;
        $query = "INSERT INTO services (
            subclasse_id, 
            companie_id, 
            value, 
            time) VALUES (
            '" . $serviceinfo['subclasses'] . "', 
            '" . $company['Company']['id'] . "', 
            '" . $serviceinfo['value'] . "', 
            '" . $serviceinfo['time'] . "');";
        $params = array(
            'Service' => array(
                'query' => $query
            )
        );
        $return = $this->AccentialApi->urlRequestToGetData('Services', 'query', $params);
        if (empty($return)) {
            $query = "SELECT id FROM services WHERE subclasse_id = '" . $serviceinfo['subclasses'] . "' AND companie_id = '" . $company['Company']['id'] . "'";
            $params = array(
                'Service' => array(
                    'query' => $query
                )
            );
			$servCS = $this->AccentialApi->urlRequestToGetData('Services', 'query', $params);
            $serviceID = $servCS[0]['services']['id'];
            $returnVar = $this->addUsersToServices($serviceinfo['user'], $serviceID);
        } else {
            $returnVar = false;
        }
        return $returnVar;
    }

    /**
     * Edit services on company
     * @param type $serviceinfo
     * @return type
     */
    private function editService($serviceinfo, $company) {
        $query = "UPDATE services SET
            value = '" . $serviceinfo['value'] . "', 
            time = '" . $serviceinfo['time'] . "'
            WHERE companie_id = '" . $company['Company']['id'] . "' AND id = '" . $serviceinfo['id'] . "' ;";
        $params = array(
            'Service' => array(
                'query' => $query
            )
        );
        $return = $this->AccentialApi->urlRequestToGetData('Services', 'query', $params);
        if (empty($return) || $return == true) {
            $query = "DELETE FROM service_secondary_users WHERE service_id = '" . $serviceinfo['id'] . "'";
            $params = array(
                'General' => array(
                    'query' => $query
                )
            );
            $return = $this->AccentialApi->urlRequestToGetData('General', 'query', $params);
            $returnVar = $this->addUsersToServices($serviceinfo['user'], $serviceinfo['id']);
        } else {
            $returnVar = false;
        }
        return $returnVar;
    }

    //TODO: vefificar se vai excluir ou somente deixa como inativo (pois ja pode ter agendamento para ele)
    /**
     * Remove service of company
     * @param type $serviceinfo
     * @return type
     */
    private function removeService($serviceinfo) {
        $query = "DELETE FROM services WHERE id = '" . $serviceinfo['id'] . "'";
        $params = array(
            'General' => array(
                'query' => $query
            )
        );
        $return = $this->AccentialApi->urlRequestToGetData('General', 'query', $params);
        if (empty($return)) {
            $query = "DELETE FROM service_secondary_users WHERE service_id = '" . $serviceinfo['id'] . "'";
            $params = array(
                'General' => array(
                    'query' => $query
                )
            );
            $return = $this->AccentialApi->urlRequestToGetData('General', 'query', $params);
            if (!empty($return)) {
                $returnVar = false;
            }
        } else {
            $returnVar = false;
        }
        return $returnVar;
    }

    /**
     * Add users to services
     * @param type $users
     * @param type $serviceID
     * @return boolean
     */
    private function addUsersToServices($users, $serviceID) {
        $returnVar = true;
        if (is_array($users) && isset($serviceID)) {
            foreach ($users as $user) {
				$expUs = split("-", $user);
                $userid = $expUs[1];
                $query = "INSERT INTO service_secondary_users (
                        service_id, 
                        secondary_user_id) VALUES (
                        '" . $serviceID . "', 
                        '" . $userid . "');";
                $params = array(
                    'General' => array(
                        'query' => $query
                    )
                );
                $this->AccentialApi->urlRequestToGetData('General', 'query', $params);
            }
        } else {
            $returnVar = false;
        }
        return $returnVar;
    }

	
	

    // </editor-fold>
}
