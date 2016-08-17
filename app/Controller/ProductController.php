			<?php

			/**
			 * All action about Products And Sales
			 */
			class ProductController extends AppController {

				public function __construct($request = null, $response = null) {
					$this->layout = 'default_business';
					$this->set('title_for_layout', 'Produtos');
					parent::__construct($request, $response);
				}

				/**
				 * Show populated view
				 */
				public function index() {
				date_default_timezone_set("America/Sao_Paulo");
					$company = $this->Session->read('CompanyLoggedIn');
					$this->set('allOffers', $this->getAllOffers($company));
					$this->set('allOffersActive', $this->getAllOffersActive($company));
					$this->set('allOffersInactive', $this->gelAllOffersInactive($company));
				}

				//to be removed
				public function add($offerId = null) {
					$company = $this->Session->read('CompanyLoggedIn');
					$this->set('offerFiltersData', $this->loadOfferFilters($company['Company'] ['id']));
					$this->set('categorias', $this->getCompanysCategory());
					$this->set('atributos', $this->getOfferAtributes());
					if ($offerId != null) {
						
					}
				}

				/**
				 * Add end edit product/offer
				 * @param Offer id $offerId
				 */
				public function productManipulation($offerId = null) {

					$userId = $_SESSION['offerByUserId'];
					
					$this->set("userId", $userId);
					$company = $this->Session->read('CompanyLoggedIn');
					$this->set('atributes', $this->getOfferAtributes());
					$this->set('categories', $this->getCompanysCategory());
					$this->set('filters', $this->getAllFilters());
					$this->set('company', $company);			


					if ($offerId != null && isset($offerId)) {
						
						//$this->insertOffersUsersByOffer($offerId);
						
						$this->GeneralFunctions = $this->Components->load('GeneralFunctions');
						$offer = $this->getOfferInformation($company, $this->GeneralFunctions->onlyNumbers($offerId));
						$this->set('offerInformation', $offer);
						$this->set('offerExtra', $this->getOfferExtraInformation($offerId));
						$this->set('offerImages', $this->getAllImagesForOffer($offerId));
						$this->set('offerFilters', $this->getOfferFilters($offerId));
					}
				}

				/**
				 * Functio responsible to add and edit basic offer information
				 * @return offer
				 */
				public function addEditBasicOfferInformation() {
					$this->autoRender = false;
					if ($this->request->is('post')) {
						$company = $this->Session->read('CompanyLoggedIn');
						$this->GeneralFunctions = $this->Components->load('GeneralFunctions');
						extract($this->request->data);
						if (!empty($offer_id)) {
							$param['Offer']['id'] = $offer_id;
							$newOffer = false;
						} else {
							$newOffer = true;
						}
						// => Basic filds
						$param['Offer']['company_id'] = $company['Company']['id'];
						$param['Offer']['title'] = $title;
						$param['Offer']['resume'] = $resume;
						$param['Offer']['value'] = $price;
						$param['Offer']['amount_allowed'] = $qtd;
						$param['Offer']['begins_at'] = $this->GeneralFunctions->convertDateBrazilToSQL($begins_at);
						$param['Offer']['parcels'] = $parcels;
						// => Extra Filds
						$param['Offer']['description'] = $description;
						$param['Offer']['specification'] = $specification;
						$param['Offer']['percentage_discount'] = 100 - ($price_offer / $price) * 100;
						$param['Offer']['parcels_impost_value'] = $percentage;
						$param['Offer']['weight'] = $weight == "" ? 0 : $weight;
						$param['Offer']['ends_at'] = $ends_at == "" ? "''" : $this->GeneralFunctions->convertDateBrazilToSQL($ends_at);
						$param['Offer']['metrics'] = "'500ml, 600ml'"; // TODO - 1: o que é este campo
						 $param['Offer']['public'] = "ACTIVE"; // TODO - 1: o que é este campo
						//$param['Offer']['sku'] = $sku;

						$returnAddEdit = $this->AccentialApi->urlRequestToSaveData('offers', $param);

						//INSERI SKU E QUANTIDADE DE PARCELAS PERMITIDAS APÓS INSERÇÃO DA OFERTA
						$sqlSku = "update offers set SKU = '{$sku}', parcels_quantity = {$parcels_quantity} where id = {$returnAddEdit['data']['Offer']['id']};";
						$skuParams = array('User' => array('query' => $sqlSku));
						$this->AccentialApi->urlRequestToGetData('users', 'query', $skuParams);
						
						$sqlStatistics = "insert into offers_statistics(`offer_id`, `details_click`, `checkouts_click`, `purchased_billet`, `purchased_card`)
						VALUES(
						{$returnAddEdit['data']['Offer']['id']},
						0,
						0,
						0,
						0);";
						 $statisParams = array('User' => array('query' => $sqlStatistics));
						$this->AccentialApi->urlRequestToGetData('users', 'query', $statisParams);

						/**
						* caso seja uma oferta de serviço, deve-se criar um registro na tabela offers_services relacionando ambos
						*/
						if($newOffer == true){
						
							//if(!empty($selectedServiceId)){
						
								$insertOffersServices = "INSERT INTO offers_services(`offer_id`, `service_id`) VALUES({$returnAddEdit['data']['Offer']['id']}, {$selectedServiceId});";
								$offersServicesParam = array('User' => array('query' => $insertOffersServices));
								$this->AccentialApi->urlRequestToGetData('users', 'query', $offersServicesParam);
							//}
							
						}
						
						//Criando registros no OffersUsers/ Para usuários que seguem a empresa
						$this->insertOffersUsersByOffer($returnAddEdit['data']['Offer']['id']);
						//
						
						//VERIFICANDO SE OFERTA TERÁ PERFIL
						if (!empty($_SESSION['offerByProfile'])) {
							$offerByUser = $_SESSION['offerByProfile'];
						}

						if (!empty($offerByUser)) {

							$paramOfferByUser['OffersFilter']['offer_id'] = $returnAddEdit['data']['Offer']['id'];
							$paramOfferByUser['OffersFilter']['gender'] = $offerByUser['facebook_profiles']['gender'];
							$paramOfferByUser['OffersFilter']['religion'] = $offerByUser['facebook_profiles']['religion'];
							$paramOfferByUser['OffersFilter']['political'] = $offerByUser['facebook_profiles']['political'];
							$paramOfferByUser['OffersFilter']['age_group'] = $offerByUser['facebook_profiles']['birthday'];
							$paramOfferByUser['OffersFilter']['location'] = $offerByUser['facebook_profiles']['location'];
							$paramOfferByUser['OffersFilter']['relationship_status'] = $offerByUser['facebook_profiles']['relationship_status'];

							$this->AccentialApi->urlRequestToSaveData('offers', $paramOfferByUser);
							$_SESSION['offerByProfile'] = null;
						}else{
							
							$paramOfferByUser['OffersFilter']['offer_id'] = $returnAddEdit['data']['Offer']['id'];
							$paramOfferByUser['OffersFilter']['gender'] = '';
							$paramOfferByUser['OffersFilter']['religion'] = '';
							$paramOfferByUser['OffersFilter']['political'] = '';
							$paramOfferByUser['OffersFilter']['age_group'] = '';
							$paramOfferByUser['OffersFilter']['location'] = '';
							$paramOfferByUser['OffersFilter']['relationship_status'] = '';

							$this->AccentialApi->urlRequestToSaveData('offers', $paramOfferByUser);
							
						}

						//VERIFICANDO SE OFERTA É ESPECIFICA PARA ALGUM USUARIO
						$offerByUserId = $_SESSION['offerByUserId'];
						if ($offerByUserId) {

							$paramOfferByUserId['OffersUser']['offer_id'] = $returnAddEdit['data']['Offer']['id'];
							$paramOfferByUserId['OffersUser']['user_id'] = $offerByUserId;
							$paramOfferByUserId['OffersUser']['date_register'] = date('Y/m/d');
							$paramOfferByUserId['OffersUser']['target'] = 'portal';

							$this->AccentialApi->urlRequestToSaveData('offers', $paramOfferByUserId);
							$_SESSION['offerByUserId'] = null;
						}

						if (isset($returnAddEdit['data']['Offer']['id'])) {
							$this->editDeliveryInformation($returnAddEdit['data']['Offer']['id'], $newOffer, $offer_type, $delivery_dealine, $delivery_value, $use_correios_api);
						}

						

						//Criando registro na tabela de notificações para usuários que seguem a empresa
						$sqlCompaniesUsers = "select * from companies_users where company_id = {$company['Company']['id']};";
						$companiesUsersParams = array('User' => array('query' => $sqlCompaniesUsers));
						$companiesUsersRegisters = $this->AccentialApi->urlRequestToGetData('users', 'query', $companiesUsersParams);

						if(!empty($companiesUsersRegisters)){
						foreach ($companiesUsersRegisters as $companyUser) {

							$insertNotify = "INSERT INTO notifications_company(`description`, `date_notification`,`company_id`, `offer_id`, `user_id`, `status`, `horario`, `data`, `peso`)"
									. "values('NOVA OFERTA ADICIONADA', "
									. "'" . date("Y-m-d") . "', "
									. "{$company['Company']['id']},"
									. " {$returnAddEdit['data']['Offer']['id']}, "
									. "{$companyUser['companies_users']['user_id']},"
									. "1,"
									. "'00:00:00',"
									. "0000-00-00,"
									. "1)";

							$insertNotiFyParams = array('User' => array('query' => $insertNotify));
							$this->AccentialApi->urlRequestToGetData('users', 'query', $insertNotiFyParams);
						}
						}
						
						
						
						return json_encode($returnAddEdit);
					}
				}

				/**
				 * Uploads the image on server and gets the URL back
				 * @return string
				 */
				public function uploadOfferImage() {
					$this->autoRender = false;
					$company = $this->Session->read('CompanyLoggedIn');
					//CHAMAR FUNÇÃO uploadAnyPhoto PARA TESTE 


					if ($this->request->is('post')) {
						if (isset($this->request['data']['offerId']) && !empty($this->request['data']['offerId'])) {
							if (isset($this->request->params['form']['sendImage']) && !empty($this->request->params['form']['sendImage'])) {
								//$offersExtraPhotos = $this->AccentialApi->uploadFileOffer('offers', $this->request->params['form']['sendImage']);
								//$offersExtraPhotos = $this->AccentialApi->uploadAnyPhoto('jezzyuploads/company-119/offers', $this->request->params['form']['sendImage']);
								$offersExtraPhotos = $this->AccentialApi->uploadAnyPhotos('uploads/company-' . $company['Company']['id'] . '/offers', $this->request->params['form']['sendImage'], $company['Company']['id']);
								if (!empty($offersExtraPhotos) && substr($offersExtraPhotos, 0, 4) == "http") {
									$saveDatabase = $this->saveImageUrl($this->request['data']['offerId'], $offersExtraPhotos, false, $this->request['data']['photo_id']);
									if (empty($saveDatabase)) {
										return "true";
									}
								}
							} else {
								if (isset($this->request->params['form']['sendImageFirst']) && !empty($this->request->params['form']['sendImageFirst'])) {
									// $offersExtraPhotos = $this->AccentialApi->uploadFileOffer('offers', $this->request->params['form']['sendImageFirst']);
									//$offersExtraPhotos = $this->AccentialApi->uploadAnyPhoto('jezzyuploads/company-119/offers', $this->request->params['form']['sendImageFirst']);
									$offersExtraPhotos = $this->AccentialApi->uploadAnyPhotos('uploads/company-' . $company['Company']['id'] . '/offers', $this->request->params['form']['sendImageFirst'], $company['Company']['id']);
									$saveDatabase = $this->saveImageUrl($this->request['data']['offerId'], $offersExtraPhotos, true);
									if (empty($saveDatabase)) {
										return "true";
									}
								}
							}
						}
					}
					return "false";
				}

				/**
				 * Remove image line from database. This function dont remove the image from server
				 * @return string
				 */
				public function removeImage() {
					$this->autoRender = false;
					if ($this->request->is('post')) {
						$company = $this->Session->read('CompanyLoggedIn');
						if (!empty($this->request['data']['photo_id'])) {
							$query = "DELETE FROM offers_photos "
									. " WHERE id = " . $this->request['data']['photo_id'] . " "
									. " AND offer_id = " . $this->request['data']['offer_id'] . ";";
						} else {
							$query = "UPDATE offers SET "
									. " photo = '' "
									. " WHERE id = " . $this->request['data']['offer_id'] . ";";
						}
						$paramExtras = array(
							'User' => array(
								'query' => $query
							)
						);
						return $this->AccentialApi->urlRequestToGetData('users', 'query', $paramExtras);
					}
					return "false";
				}

				/**
				 * Save options for offer.
				 */
				public function saveOptions() {
					$this->autoRender = false;
					if ($this->request->is('post')) {
						$post = $this->request['data'];
						$offerId = $post['offerId'];
						unset($post['offerId']);
						$query = "DELETE FROM offers_metrics where offer_id = '" . $offerId . "'";
						$params = array(
							'User' => array(
								'query' => $query
							)
						);
						$delOfferFilter = $this->AccentialApi->urlRequestToGetData('users', 'query', $params);
						foreach ($post as $key => $element) {
							if (substr($key, 0, 4) == "cont") {
								$atribitesArr = explode("-", $key);
								$attrX = $atribitesArr[1];
								$attrY = $atribitesArr[2];
								if ($element == "") {
									$element = 0;
								}
								if ($post["preco-column-" . $attrY] == "") {
									$post["preco-column-" . $attrY] = 0;
								}
								$paramsQuery = array(
									'User' => array(
										'query' => "INSERT INTO offers_metrics("
										. "offer_id, "
										. "offer_metrics_x_id, "
										. "offer_metrics_y_id, "
										. "amount, "
										. "value) VALUES("
										. "" . $offerId . ","
										. "" . $attrX . ","
										. "" . $attrY . ","
										. "" . $element . ","
										. "" . $post["preco-column-" . $attrY] . ");"
									)
								);
								$abc = $this->AccentialApi->urlRequestToGetData('users', 'query', $paramsQuery);
							}
						}
					}
					$this->Session->setFlash(__('Opções do produto salvo com sucesso.'));
					$this->redirect('productManipulation/' . $offerId);
				}

				/**
				 * Save the filters of an offer
				 */
				public function saveFilters() {
					$this->autoRender = false;
					if ($this->request->is('post')) {
						$offerId = $this->request['data']['offerId'];
						$offers_filters_id = $this->request['data']['offers_filters_id'];
						if (isset($this->request['data']['gender'])) {
							$gender = implode(",", $this->request['data']['gender']);
						} else {
							$gender = "";
						}
						if (isset($this->request['data']['religion'])) {
							$religion = implode(",", $this->request['data']['religion']);
						} else {
							$religion = "";
						}
						if (isset($this->request['data']['politics'])) {
							$politics = implode(",", $this->request['data']['politics']);
						} else {
							$politics = "";
						}
						if (isset($this->request['data']['age'])) {
							$age = implode(",", $this->request['data']['age']);
						} else {
							$age = "";
						}
						if (isset($this->request['data']['location'])) {
							$location = implode(",", $this->request['data']['location']);
						} else {
							$location = "";
						}
						if (isset($this->request['data']['relashionship'])) {
							$relashionship = implode(",", $this->request['data']['relashionship']);
						} else {
							$relashionship = "";
						}

						$paramsQuery = array(
							'User' => array(
								'query' => "UPDATE offers SET public = 'INACTIVE' WHERE id = " . $offerId . ";"
							)
						);
						$abc = $this->AccentialApi->urlRequestToGetData('users', 'query', $paramsQuery);
						if ($offers_filters_id == "") {
							$query = "
								INSERT INTO offers_filters
								(gender, religion, political, age_group, location, relationship_status, offer_id)
								VALUES
								('" . $gender . "','" . $religion . "','" . $politics . "','" . $age . "','" . $location . "','" . $relashionship . "', '" . $offerId . "');";
						} else {
							$query = "
								UPDATE offers_filters SET
									gender = '" . $gender . "',
									religion = '" . $religion . "',
									political = '" . $politics . "',
									age_group = '" . $age . "',
									location = '" . $location . "',
									relationship_status = '" . $relashionship . "'
								WHERE id = '" . $offers_filters_id . "'";
						}
						$paramsQuery = array(
							'User' => array(
								'query' => $query
							)
						);
						$abc = $this->AccentialApi->urlRequestToGetData('users', 'query', $paramsQuery);
					}
					
						/**
						* Verficia se oferta tem algum filtro
						* caso não tenha volta para publica
						*/
						$sqlSelectFilter = "select * from offers_filters where offer_id = {$offerId};";
						$paramsMyOffersFilters = array('User' => array('query' => $sqlSelectFilter));
						$myOffersFilters = $this->AccentialApi->urlRequestToGetData('users', 'query', $paramsMyOffersFilters);
						
						if(!empty($myOffersFilters)){
						
							if($myOffersFilters[0]['offers_filters']['gender'] == '' &&
							$myOffersFilters[0]['offers_filters']['religion'] == '' &&
							$myOffersFilters[0]['offers_filters']['age_group'] == '' &&
							$myOffersFilters[0]['offers_filters']['location'] == '' &&
							$myOffersFilters[0]['offers_filters']['relationship_status'] == '' &&
							$myOffersFilters[0]['offers_filters']['religion'] == ''){
								$sqlUpdateOfferToPublic= "update offers set public = 'ACTIVE' where id = {$offerId};";
								$sqlUpdateParams = array('User' => array('query' => $sqlUpdateOfferToPublic));
								$this->AccentialApi->urlRequestToGetData('users', 'query', $sqlUpdateParams);
							}
								
						}
					
					$this->Session->setFlash(__('Opções do produto salvo com sucesso.'));
					$this->redirect('productManipulation/' . $offerId);
				}

				// <editor-fold  defaultstate="collapsed" desc="Ajax Methods">
				/**
				 * Mount the HTML table of product options. 
				 */
				public function productOptionsTable() {
					$this->layout = '';
					if ($this->request->is('post')) {
						if (!empty($this->request->data['col']) and ! empty($this->request->data['line'])) {

							$param['Offer']['id'] = $this->request->data['offerId'];
							$param['Offer']['offer_attribute_x'] = $this->request->data['line'];
							$param['Offer']['offer_attribute_y'] = $this->request->data['col'];
							$param['Offer']['category'] = $this->request->data['category'];
							$returnAddEdit = $this->AccentialApi->urlRequestToSaveData('offers', $param);

							if (isset($this->request->data['offerId']) && !empty($this->request->data['offerId'])) {
								$sqlDTColuna = "select * from offers_metrics inner join offers_domains on offers_metrics.offer_metrics_y_id = offers_domains.id inner join offers_attributes on offers_attributes.id = offers_domains.offer_attribute_id where offers_metrics.offer_id = " . $this->request->data['offerId'] . ";";
								$paramsDTColuna = array(
									'User' => array(
										'query' => $sqlDTColuna
									)
								);
								$editDTColunas = $this->AccentialApi->urlRequestToGetData('users', 'query', $paramsDTColuna);
								$editDTLinhas = $editDTColunas;
							} else {
								$editDTColunas = Array();
								$editDTLinhas = Array();
							}
							// => Gets all domains for that colomn
							$col = $this->request->data['col'];
							$line = $this->request->data['line'];
							$query = "select * from offers_domains where offer_attribute_id = $col;";
							$paramsCol = array(
								'User' => array(
									'query' => $query
								)
							);
							// => Gets all domains for that line
							$cols = $this->AccentialApi->urlRequestToGetData('users', 'query', $paramsCol);
							$query = "select * from offers_domains where offer_attribute_id = $line;";
							$paramsLine = array(
								'User' => array(
									'query' => $query
								)
							);
							$lines = $this->AccentialApi->urlRequestToGetData('users', 'query', $paramsLine);
						}
					}
					$this->set('editDTColunas', $editDTColunas);
					$this->set('editDTLinhas', $editDTLinhas);
					$this->set('cols', $cols);
					$this->set('lines', $lines);
				}

				/**
				 * Change the status of a offer
				 * @return int - 0 for falue and 1 for success
				 */
				public function changeOfferStatus() {
					$this->autoRender = false;
					$up = 0;
					if ($this->request->is('post')) {
						if (isset($this->request->data['Offer']['id']) && isset($this->request->data['Offer']['status'])) {
							$offerId = $this->request->data['Offer']['id'];
							$status = $this->request->data['Offer']['status'];
							if ($status == 'ATIVO') {
								$Q = "update offers set status = 'INACTIVE' where id = " . $offerId . ";";
								$qparams = array(
									'User' => array(
										'query' => $Q
									)
								);
								$up = $this->AccentialApi->urlRequestToGetData('users', 'query', $qparams);
							}
							if ($status == 'INATIVO') {
								$Q = "update offers set status = 'ACTIVE' where id =" . $offerId . ";";
								$qparams = array(
									'User' => array(
										'query' => $Q
									)
								);
								$up = $this->AccentialApi->urlRequestToGetData('users', 'query', $qparams);
							}
						}
					}
					if (is_null($up)) {
						$up = 1;
					}
					return $up;
				}

				// </editor-fold>
				// <editor-fold  defaultstate="collapsed" desc="Private Methods">
				/**
				 * Gets the filters save for the offer
				 * @param offer id $offerId
				 * @return type
				 */
				private function getOfferFilters($offerId) {
					$query = "SELECT * FROM "
							. " offers_filters"
							. " WHERE offer_id = '" . $offerId . "';";
					$paramExtras = array(
						'User' => array(
							'query' => $query
						)
					);
					return $this->AccentialApi->urlRequestToGetData('users', 'query', $paramExtras);
				}

				/**
				 * Mount the array of filters used for target offer
				 * @return Array with filters
				 */
				private function getAllFilters() {
					$company = $this->Session->read('CompanyLoggedIn');
					$return['gender'] = $this->getFiltesOfProfiles('gender', $company);
					$return['location'] = $this->getFiltesOfProfiles('location', $company);
					$return['relationship_status'] = $this->getFiltesOfProfiles('relationship_status', $company);
					$return['religion'] = $this->getFiltesOfProfiles('religion', $company);
					$return['political'] = $this->getFiltesOfProfiles('political', $company);
					$return['age'] = $this->getFiltesOfProfilesAges($company);
					return $return;
				}

				/**
				 * Gets filter on database and calculates the percentage of groups
				 * @param string filtro $filter
				 * @param compania $company
				 * @return type
				 */
				private function getFiltesOfProfiles($filter, $company) {
					$paramExtras = array(
						'User' => array(
							'query' => 'SELECT COUNT(facebook_profiles.' . $filter . ') as sum, facebook_profiles.' . $filter . ' as response FROM facebook_profiles INNER JOIN companies_users ON facebook_profiles.user_id = companies_users.user_id AND companies_users.company_id = ' . $company['Company']['id'] . ' WHERE facebook_profiles.' . $filter . ' IS NOT NULL GROUP BY ' . $filter . ';'
						)
					);
					$result = $this->AccentialApi->urlRequestToGetData('users', 'query', $paramExtras);
					$total = 0;
					if (is_array($result)) {
						foreach ($result as $response) {
							$total = $total + $response[0]['sum'];
						}
					}
					$resultArr = array();
					if (is_array($result)) {
						foreach ($result as $key => $response) {
							$resultArr[$key]['param'] = str_replace(",", " ", $response['facebook_profiles']['response']);
							$resultArr[$key]['total'] = number_format((($response[0]['sum'] * 100) / $total), 1);
						}
					}
					return $resultArr;
				}

				/**
				 * Gets filter on database (age only) and calculates the percentage of groups
				 * @param string filtro $filter
				 * @param compania $company
				 * @return type
				 */
				private function getFiltesOfProfilesAges($company) {
					$paramExtras = array(
						'User' => array(
							'query' => "
								SELECT
									SUM(IF(age < 20,1,0)) AS 0_20,
									SUM(IF(age BETWEEN 20 AND 29,1,0)) AS 20_29,
									SUM(IF(age BETWEEN 30 AND 39,1,0)) AS 30_39,
									SUM(IF(age BETWEEN 40 AND 49,1,0)) AS 40_49,
									SUM(IF(age BETWEEN 50 AND 59,1,0)) AS 50_59,
									SUM(IF(age BETWEEN 60 AND 120,1, 0)) AS 60_120,
									SUM(IF(age >= 121, 1, 0)) AS outro
								FROM ( SELECT YEAR(CURDATE()) - YEAR(birthday ) AS age 
								FROM users as a, companies_users as b 
								WHERE a.id=b.user_id and b.status='ACTIVE' 
									AND b.company_id = " . $company['Company']['id'] . ") AS derived;"
						)
					);
					$result = $this->AccentialApi->urlRequestToGetData('users', 'query', $paramExtras);
					$total = 0;
					foreach ($result[0][0] as $key => $response) {
						$total = $total + $response;
					}
					$resultArr = array();
					if (is_array($result)) {
						foreach ($result[0][0] as $key => $response) {
							$resultArr[$key]['param'] = str_replace("_", " a ", $key);
							if ($total == 0) {
								$resultArr[$key]['total'] = 0;
							} else {
								$resultArr[$key]['total'] = number_format((($response * 100) / $total), 1);
							}
						}
					}
					return $resultArr;
				}

				/**
				 * Save the image URL on database
				 * @param string $offerId
				 * @param string $imageUrl
				 * @param string $first
				 * @param string $photo_id
				 * @return resposne do query.
				 */
				private function saveImageUrl($offerId, $imageUrl, $first = false, $photo_id = 0) {
					if ($first) {
						$query = "UPDATE offers SET "
								. " photo = '" . $imageUrl . "' "
								. " WHERE id = " . $offerId . ";";
					} else {
						if ($photo_id == 0 || $photo_id == "0") {
							$query = "INSERT INTO offers_photos("
									. " offer_id, "
									. " photo )"
									. " values("
									. $offerId . ","
									. "'" . $imageUrl . "');";
						} else {
							$query = "UPDATE offers_photos SET "
									. " photo = '" . $imageUrl . "' "
									. " WHERE id = " . $photo_id . ";";
						}
					}
					$paramExtras = array(
						'User' => array(
							'query' => $query
						)
					);
					return $this->AccentialApi->urlRequestToGetData('users', 'query', $paramExtras);
				}

				/**
				 * Get the URL of extra images
				 * @param Offer id $offerId
				 * @return Arrya with images
				 */
				private function getAllImagesForOffer($offerId) {
					$query = "SELECT * FROM "
							. " offers_photos"
							. " WHERE offer_id = '" . $offerId . "';";
					$paramExtras = array(
						'User' => array(
							'query' => $query
						)
					);
					return $this->AccentialApi->urlRequestToGetData('users', 'query', $paramExtras);
				}

				/**
				 * Edit the extra information about eh offer.
				 * @param The id i just add $justAddId
				 * @param Teh id from edit $id
				 * @param $offer_type
				 * @param $delivery_dealine
				 * @param $delivery_value
				 * @param $use_correios_api
				 */
				private function editDeliveryInformation($justAddId, $newOffer, $offer_type, $delivery_dealine, $delivery_value, $use_correios_api) {
					if ($use_correios_api == 1 || $use_correios_api == "1") {
						$delivery_mode = "CORREIO";
						$delivery_dealine = 0;
						$delivery_value = 0;
					} else {
						$delivery_mode = "TRANSPORTA";
						if ($delivery_dealine == "") {
							$delivery_dealine = 0;
						}
						if ($delivery_value == "") {
							$delivery_value = 0;
						}
					}
					if (!$newOffer) {
						$query = "UPDATE offers_extra_infos SET "
								. " offer_type = '" . $offer_type . "' , "
								. " delivery_mode = '" . $delivery_mode . "' , "
								. " delivery_deadline = " . $delivery_dealine . " , "
								. " delivery_value = " . $delivery_value . ""
								. " WHERE offer_id = " . $justAddId . ";";
						$paramExtras = array(
							'User' => array(
								'query' => $query
							)
						);
						$infosExtras = $this->AccentialApi->urlRequestToGetData('users', 'query', $paramExtras);
					} else {
						$query = "INSERT INTO offers_extra_infos("
								. "offer_type, "
								. "delivery_mode, "
								. "delivery_deadline, "
								. "delivery_value, "
								. "offer_id)"
								. " values("
								. "'" . $offer_type . "',"
								. "'" . $delivery_mode . "',"
								. " " . $delivery_dealine . ","
								. " " . $delivery_value . ","
								. " " . $justAddId . ");";
						$paramExtras = array(
							'User' => array(
								'query' => $query
							)
						);
						$infosExtras = $this->AccentialApi->urlRequestToGetData('users', 'query', $paramExtras);
					}
					return $infosExtras;
				}

				/**
				 * Get the information about the offer
				 * @param Session $company
				 * @param Offer Id $offerId
				 * @return Offer
				 */
				private function getOfferInformation($company, $offerId) {
					$arrayParams = array(
						'Offer' => array(
							'conditions' => array(
								'Offer.company_id' => $company['Company'] ['id'],
								'Offer.id' => $offerId
							)
						)
					);
					return $this->AccentialApi->urlRequestToGetData('offers', 'first', $arrayParams);
				}

				/**
				 * Gets all extra information about the product
				 * @param type $offerId
				 * @return type
				 */
				private function getOfferExtraInformation($offerId) {
					$query = "SELECT * FROM offers_extra_infos WHERE offer_id = $offerId;";
					$paramExtras = array(
						'User' => array(
							'query' => $query
						)
					);
					$retorno = $this->AccentialApi->urlRequestToGetData('users', 'query', $paramExtras);
					
					return $retorno[0];
				}

				/**
				 * Gets all attributes for a offer.
				 * @return type
				 */
				private function getOfferAtributes() {
					$query = "select * from offers_attributes order by name;";
					$params3 = array(
						'User' => array(
							'query' => $query
						)
					);
					return $this->AccentialApi->urlRequestToGetData('users', 'query', $params3);
				}

				/**
				 * Gets all category for the company
				 * @return arrys with the categorys
				 */
				private function getCompanysCategory() {
					$arrayParams = array(
						'CompaniesCategory' => array()
					);
					return $this->AccentialApi->urlRequestToGetData('companies', 'all', $arrayParams);
				}

				/**
				 * Get all offer from this company
				 * @param type $company
				 * @return Array with all offers
				 */
				private function getAllOffers($company) {
					$arrayParams = array(
						'Offer' => array(
							'conditions' => array(
								'Offer.company_id' => $company['Company'] ['id']
							),
							'order' => array(
								'Offer.id' => 'DESC'
							),
						)
					);
					$offers = $this->AccentialApi->urlRequestToGetData('offers', 'all', $arrayParams);
					$offersWithStatistics = '';
					if (!empty($offers)) {
						foreach ($offers as $offer) {
							$statisticsQuery = "select details_click, checkouts_click, purchased_billet, purchased_card from offers_statistics where offers_statistics.offer_id =" . $offer['Offer']['id'] . ";";

							$statisticsParams = array(
								'User' => array(
									'query' => $statisticsQuery
								)
							);
							$statistics = $this->AccentialApi->urlRequestToGetData('users', 'query', $statisticsParams);
					
							$offer['Statistics'] = $statistics[0];
							 $offer['Statistics'][0]['evaluation'] = 0;
							  $offer['Statistics'][0]['votantes'] = 0;
							$offersWithStatistics[] = $offer;
						}
					}
					return $offersWithStatistics;
				}

				/**
				 * Get all active offer from this company
				 * @param type $company
				 * @return Array with all offers actives
				 */
				private function getAllOffersActive($company) {
					$paramsAtivas = array(
						'Offer' => array(
							'conditions' => array(
								'Offer.company_id' => $company['Company'] ['id'],
								'Offer.status' => 'ACTIVE'
							),
							'order' => array(
								'Offer.id' => 'DESC'
							),
						)
					);
					$offersActive = $this->AccentialApi->urlRequestToGetData('offers', 'all', $paramsAtivas);
					$activasWithStatistics = '';
					if (!empty($offersActive)) {
						foreach ($offersActive as $offer) {
						   $statisticsQuery = "select details_click, checkouts_click, purchased_billet, purchased_card from offers_statistics where offers_statistics.offer_id =" . $offer['Offer']['id'] . ";";

							$statisticsParams = array(
								'User' => array(
									'query' => $statisticsQuery
								)
							);
							$statistics = $this->AccentialApi->urlRequestToGetData('users', 'query', $statisticsParams);
					
							$offer['Statistics'] = $statistics[0];
							 $offer['Statistics'][0]['evaluation'] = 0;
							  $offer['Statistics'][0]['votantes'] = 0;
							$activasWithStatistics[] = $offer;
						}
					}
					return $activasWithStatistics;
				}

				/**
				 * Get all inactive offer from this company
				 * @param type $company
				 * @return Array with all offers inactives
				 */
				private function gelAllOffersInactive($company) {
					$paramsInativas = array(
						'Offer' => array(
							'conditions' => array(
								'Offer.company_id' => $company['Company'] ['id'],
								'Offer.status' => 'INACTIVE'
							),
							'order' => array(
								'Offer.id' => 'DESC'
							)
						)
					);
					
					$offersInactive = $this->AccentialApi->urlRequestToGetData('offers', 'all', $paramsInativas);
					$inactiveWithStatistics = '';
					if (!empty($offersInactive)) {
						foreach ($offersInactive as $offer) {
							$statisticsQuery = "select details_click, checkouts_click, purchased_billet, purchased_card from offers_statistics where offers_statistics.offer_id =" . $offer['Offer']['id'] . ";";

							$statisticsParams = array(
								'User' => array(
									'query' => $statisticsQuery
								)
							);
							$statistics = $this->AccentialApi->urlRequestToGetData('users', 'query', $statisticsParams);
					
							$offer['Statistics'] = $statistics[0];
							 $offer['Statistics'][0]['evaluation'] = 0;
							  $offer['Statistics'][0]['votantes'] = 0;
							$inactiveWithStatistics[] = $offer;
						}
					}
					return $inactiveWithStatistics;
				}

				public function getOfferDetails() {

					$this->layout = "";
					$offerId = $this->request->data['OfferId'];

					$paramsOffer = array(
						'Offer' => array(
							'conditions' => array(
								'Offer.id' => $offerId
							)
						)
					);

					$offer = $this->AccentialApi->urlRequestToGetData('offers', 'first', $paramsOffer);


					$paramsOfferComment = array(
						'OffersComment' => array(
							'conditions' => array(
								'OffersComment.offer_id' => $offerId
							)
						),
						'User'
					);

					$offerComment = $this->AccentialApi->urlRequestToGetData('offers', 'all', $paramsOfferComment);

					$this->set('offer', $offer);
					$this->set('offersComments', $offerComment);
				}

				public function testaUpload() {
					
				}

				public function tretes() {
					$this->autoRender = false;
					$file = $_FILES['file_name'];

					$offersExtraPhotos = $this->AccentialApi->uploadAnyPhoto('jezzyuploads/company-119/offers', $file);

					print_r($offersExtraPhotos);
				}

				public function reactiveOffer() {

					$id = $this->request->data['id'];
					$sql = "update offers set status = 'ACTIVE' where id = {$id};";
					$params = array(
						'Service' => array(
							'query' => $sql
						)
					);

					$this->AccentialApi->urlRequestToGetData('Services', 'query', $params);
				}

				public function inactiveOffer() {
					$this->autoRender = false;
					$id = $this->request->data['id'];
					$sql = "update offers set status = 'INACTIVE' where id = {$id};";
					$params = array(
						'Service' => array(
							'query' => $sql
						)
					);
					$this->AccentialApi->urlRequestToGetData('Services', 'query', $params);
				}
				
				/**
				* Após o cadastro de uma oferta pública essa função será executada, 
				* Ela é responsavel
				*/
				public function insertOffersUsersByOffer($offerId){
					//$this->autoRender = false;
					
					$company = $this->Session->read('CompanyLoggedIn');
					
					// selecione todos os usuários que estão ativos seguindo a empresa
					$sqlSelect = "select * from companies_users where company_id = {$company['Company']['id']} and status = 'ACTIVE';";
					$paramsSelect = array(
						'User' => array(
							'query' => $sqlSelect
						)
					);
					$companiesUsers = $this->AccentialApi->urlRequestToGetData('users', 'query', $paramsSelect);
					
					//caso a quantidade de seguidores da empresa seja diferente de 0, 
					//então inserimos o offers_users para essses caras
					//$insert = "I ";
					
					if(!empty($companiesUsers)){
						$data = date('Y-m-d');
						foreach($companiesUsers as $users){
						
							$insert = "INSERT INTO offers_users(`offer_id`, `user_id`, `date_register`, `target`) VALUES 
							({$offerId}, {$users['companies_users']['user_id']}, '{$data}', '');";
							
							$paramsInsert = array(
						'User' => array(
							'query' => $insert
						)
					);
					
					$this->AccentialApi->urlRequestToGetData('users', 'query', $paramsInsert);
						
						}
					}
					return null;
				}

				//</editor-fold>
			}
