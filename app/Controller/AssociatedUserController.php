	<?php


	class AssociatedUserController extends AppController {

			public function __construct($request = null, $response = null) {
				$this->layout = 'default_business';
				$this->set('title_for_layout', 'Usuarios');

				parent::__construct($request, $response);
			}

			public function beforeFilter() {
				if ($this->Session->read('userLoggedType') != 1 && $this->Session->read('userLoggedType') != 3 ) {
					$this->render('../Errors/wrong_way');
					//TODO: enviar e-mail para responsavel da empresa avisando da tentativa.
				}
				parent::beforeFilter();
			}
			
			public function followAssociatedUser(){
			
				$associatedUser = $this->request->data ['associatedUserId'];
				$userId = $this->request->data ['userId'];
				$dat = date("Y-m-d");
			
				$sql = "INSERT INTO associated_user_followers(
				`associated_user_id`,
				`user_id`,
				`status`,
				`last_status`,
				`date_register`)
				VALUES(
				{$associatedUser},
				{$userId},
				'ACTIVE',
				'ACTIVE',
				'{$dat}'
				);";
				
				$param= array(
						'User' => array(
							'query' => $sql
						)
					);
					
					$this->AccentialApi->urlRequestToGetData('users', 'query', $param);
			
			}

			
	}

