<?php

require("../Vendor/phpmailer/PHPMailerAutoload.php");
/**
 * All action about schedule
 */
class ScheduleController extends AppController {

    public function __construct($request = null, $response = null) {
        $this->layout = 'default_business';
        $this->set('title_for_layout', 'Agenda');
        parent::__construct($request, $response);
    }

    public function index() {
	date_default_timezone_set("America/Sao_Paulo");
        $company = $this->Session->read('CompanyLoggedIn');
        if ($this->Session->read('userLoggedType') == 1) { //system admin
            $this->set('secundary_users', $this->getSecundaryUsers($company));
        } else {
			$secUs = $this->Session->read('SecondaryUserLoggedIn');
            $user = $secUs[0]['secondary_users'];
            $this->set('secundary_users', $this->getSecundaryUsers($company, $user));
        }
		$servcs = $this->getCompanyServices($company);
        $this->set('services', $servcs);
    }

    /**
     * Gets the personal schedule of secundary user
     * @return boolean
     */
    public function personalSchedule() {
        $this->layout = '';
        if ($this->request->is('post')) {
            $this->GeneralFunctions = $this->Components->load('GeneralFunctions');
            $dataSend = $this->GeneralFunctions->convertDateBrazilToSQL($this->request->data['scheduleDay']);
            $userId = $this->request->data['userId'];
		  // $dataSend = '17/6/2016';
          //  $userId = 92;
            $company = $this->Session->read('CompanyLoggedIn');
            $schedules = $this->getSchecule($company, $userId, $dataSend);
            if (empty($schedules)) {
                $this->set('userInformation', $this->getSecundaryUsers($company, $userId));
            } else {
                $this->set('schedules', $schedules);
            }
        } else {
            $this->autoRender = false;
            return false;
        }
    }

    /**
     * Add a new schedule for secundary user
     * @return boolean
     */
    public function ajaxAddSchedule() {
        $this->autoRender = false;
        if ($this->request->is('post')) {
            $company = $this->Session->read('CompanyLoggedIn');
            $this->GeneralFunctions = $this->Components->load('GeneralFunctions');
            if (!empty($this->request->data['Schedule']['scheduleDate'])) {
                $dataSend = $this->GeneralFunctions->convertDateBrazilToSQL($this->request->data['Schedule']['scheduleDate']);
            } else {
                $dataSend = date('Y-m-d');
            }

            $service = $this->getInformationAboutService($this->request->data, $company);
            if (!isset($service['classes']['name']) || empty($service['classes']['name'])) {
                return 'false';
            }
            //$time = strtotime($this->request->data['Schedule']['schedulehour']);
            //$endTime = date("H:i", strtotime('+' . $service['services']['time'], $time));
			
			$horaTermino = new DateTime($this->request->data['Schedule']['schedulehour']);
			$duracao = $service['services']['time'];
			$newHoraTermino = $horaTermino->add(New DateInterval('PT'.$duracao.'M'));
			$endTime = date_format($newHoraTermino, 'H:i');
			
            $queryInsert = "
                INSERT INTO schedules ( 
                    `classe_name`,
                    `subclasse_name` ,
                    `date` ,
                    `service_id` ,
                    `time_begin` ,
                    `time_end` ,
                    `client_name`,
                    `client_phone` ,
                    `status` ,
                    `valor` ,
                    `companie_id` ,
                    `secondary_user_id`,
					`user_id`
					)
                VALUES (
                    '" . $service['classes']['name'] . "',      
                    '" . $service['subclasses']['name'] . "',
                    '" . $dataSend . "',
                    '" . $this->request->data['Schedule']['serviceId'] . "',
                    '" . $this->request->data['Schedule']['schedulehour'] . "',
                    '" . $endTime . "',
                    '" . $this->request->data['Schedule']['scheduleClient'] . "',
                    '" . $this->request->data['Schedule']['schedulePhone'] . "',
                    '1',
                    '" . $this->request->data['Schedule']['schedulePrice'] . "',
                    '" . $company['Company'] ['id'] . "',
                    '" . $this->request->data['Schedule']['scheduleSecondaryUser'] . "',
					'" . $this->request->data['Schedule']['userId']."'
                                
                )";
            $scheduleParam = array(
                'Schedule' => array(
                    'query' => $queryInsert
                )
            );
            $scheduleReturn = $this->AccentialApi->urlRequestToGetData('schedules', 'query', $scheduleParam);
			
			$service = $service['subclasses']['name'];
			$hour = $this->request->data['Schedule']['schedulehour'];
			$dataForm = explode("-", $dataSend);
			$date = $dataForm[2]+"/"+$dataForm[1]+"/"+$dataForm[0];
			$name = $this->request->data['Schedule']['scheduleClient'];
			$valor = $this->request->data['Schedule']['schedulePrice'];
			$email = $this->request->data['Schedule']['userEmail'];
			$this->sendEmailNewSchedule($name, $email, $date, $hour, $service, $valor);
			
            if (empty($scheduleReturn)) {
                return true;
            }
        }
        return 'false';
    }

	
		
    /**
     * Remove a previous sschedule
     * @param type $scheduleId
     * @return boolean
     */
    public function ajaxRemoveSchedule() {
        $this->autoRender = false;
        $company = $this->Session->read('CompanyLoggedIn');
        if ($this->request->is('post')) {
            $queryDelete = "DELETE FROM Schedules WHERE id = " . $this->request->data['Schedule']['scheduleId'] . " AND companie_id = " . $company['Company'] ['id'] . "";
            $scheduleParam = array(
                'Schedule' => array(
                    'query' => $queryDelete
                )
            );
            $scheduleReturn = $this->AccentialApi->urlRequestToGetData('schedules', 'query', $scheduleParam);
            if (empty($scheduleReturn)) {
                return true;
            }
        }
        return 'false';
    }

    public function ajaxChangeScheduleStatus() {
        $this->autoRender = false;
        $company = $this->Session->read('CompanyLoggedIn');
        if ($this->request->is('post')) {
            $queryDelete = "UPDATE Schedules SET status = 1 WHERE id = " . $this->request->data['Schedule']['scheduleId'] . " AND companie_id = " . $company['Company'] ['id'] . "";
            $scheduleParam = array(
                'Schedule' => array(
                    'query' => $queryDelete
                )
            );
            $scheduleReturn = $this->AccentialApi->urlRequestToGetData('schedules', 'query', $scheduleParam);
            if (empty($scheduleReturn)) {
                return true;
            }
        }
        return 'false';
    }

    /**
     * Get the price of product for schedule.
     * @return int
     */
    public function ajaxGetServicePrice() {
        $this->autoRender = false;
        if ($this->request->is('post')) {
            if ($this->request->data['Schedule']['serviceId'] == 0) {
                return 0;
            } else {
                $company = $this->Session->read('CompanyLoggedIn');
                $query = "SELECT value FROM services WHERE id = '" . $this->request->data['Schedule']['serviceId'] . "' AND companie_id = '" . $company['Company']['id'] . "'";
                $params = array(
                    'Service' => array(
                        'query' => $query
                    )
                );
				$retorno = $this->AccentialApi->urlRequestToGetData('Services', 'query', $params);
                return $retorno[0]['services']['value'];
            }
        }
        return 0;
    }

    // <editor-fold  defaultstate="collapsed" desc="Private Methods">

    /**
     * Gets all the information about a service
     * @param _POST $post
     * @param CompanySession $company
     * @return All informations about a service
     */
    private function getInformationAboutService($post, $company) {
        $queryInformation = "SELECT services.*,  subclasses.*, classes.*
                FROM services 
                INNER JOIN subclasses ON subclasses.id = services.subclasse_id
                    AND services.id = " . $post['Schedule']['serviceId'] . " 
                    AND services.companie_id = " . $company['Company'] ['id'] . "
                INNER JOIN classes ON classes.id = subclasses.classe_id";
        $params = array(
            'Service' => array(
                'query' => $queryInformation
            )
        );
		$retorno = $this->AccentialApi->urlRequestToGetData('Services', 'query', $params);
        return $retorno[0];
    }

    /**
     * Gets all the services for the company
     * @param type $company
     * @return type
     */
    private function getCompanyServices($company) {
        $queryInformation = "SELECT services.*,  subclasses.*
                FROM services 
                INNER JOIN subclasses ON subclasses.id = services.subclasse_id
                    AND services.companie_id = " . $company['Company'] ['id'] . "";
        $params = array(
            'Service' => array(
                'query' => $queryInformation
            )
        );
        return $this->AccentialApi->urlRequestToGetData('Services', 'query', $params);
    }

    /**
     * Gets all schecule for this company
     * @param type $company
     * @return array whith all schecule
     */
    private function getSchecule($company, $userId, $date = null) {
        if ($date == null) {
            $date = date('Y-m-d');
        }
        $scehduleSQL = "
            SELECT schedules.*, secondary_users.*
            FROM schedules
            INNER JOIN secondary_users
                ON schedules.secondary_user_id = secondary_users.id
            WHERE schedules.companie_id = '" . $company['Company'] ['id'] . "'
            AND schedules.date = '" . $date . "'
            AND schedules.secondary_user_id = '" . $userId . "'";
        $scheduleParam = array(
            'Schedule' => array(
                'query' => $scehduleSQL
            )
        );
        return $this->AccentialApi->urlRequestToGetData('schedules', 'query', $scheduleParam);
    }

    /**
     * Get the secundary user of the system.
     * @param type $company
     * @param type $user
     * @return type
     */
    private function getSecundaryUsers($company, $user = null) {
        //TODO: este metodo pode ser unificado com o metodo do Dashboar <> Schedule <> Users
        $andQuery = "";
        if ($user != null) {
            if (is_array($user)) {
                $andQuery = " AND secondary_users.id = " . $user['id'] . " ";
            } else {
                $andQuery = " AND secondary_users.id = " . $user . " ";
            }
        }
        $secondUserSQL = "select secondary_users.name, secondary_users.id "
                . "from secondary_users "
                . "inner join secondary_users_types on secondary_users.secondary_type_id = secondary_users_types.id "
                . "where secondary_users.excluded = 0 AND company_id  = {$company['Company'] ['id']} $andQuery;";
        $secondUserParam = array(
            'User' => array(
                'query' => $secondUserSQL
            )
        );
        return $this->AccentialApi->urlRequestToGetData('users', 'query', $secondUserParam);
    }

	public function getUserByName(){
		
		$this->layout = '';
		
		$name = $this->request->data['searchService'];
		
		$query = "SELECT * FROM users WHERE name LIKE '{$name}%' order by name;";
		
			
			$params = array(
            'General' => array(
                'query' => $query
				)
			);
			$servicesArr = unserialize(utf8_decode($this->AccentialApi->urlRequestToGetData('General', 'query', $params)));
			
			$_SESSION['users'] = $servicesArr;
			$this->set("users", $servicesArr);
	
	}
	
    	public function sendEmailNewSchedule($name, $email, $date, $hour, $service, $valor){
				$mail = new PHPMailer(true);
		
		// Define os dados do servidor e tipo de conexão
// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
 $mail->IsSMTP(); // Define que a mensagem será SMTP
 $mail->Host = "pro.turbo-smtp.com"; // Endereço do servidor SMTP
 $mail->SMTPAuth = true; // Usa autenticação SMTP? (opcional)
 $mail->Username = 'contato@jezzy.com.br'; // Usuário do servidor SMTP
 $mail->Password = 'oo0MvB2Qw'; // Senha do servidor SMTP
 
 // Define o remetente
 // =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
 $mail->From = "contato@jezzy.com.br"; // Seu e-mail
 $mail->FromName = "Contato - Jezzy"; // Seu nome
 
  $mail->AddAddress("{$email}");
  
  // Define os dados técnicos da Mensagem
// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
 $mail->IsHTML(true); // Define que o e-mail será enviado como HTML
 $mail->CharSet = 'iso-8859-1'; // Charset da mensagem (opcional)

// Define a mensagem (Texto e Assunto)
// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
 $mail->Subject  = "Bem-Vindo ao Jezzy"; // Assunto da mensagem
 $mail->Body = "Ola, {$name},<br/> Seu agendamento foi concluido com sucesso, confira as informacoes a baixo: <br />{$service} as {$hour} do dia {$date} <br /> <b>TOTAL:</b> {$valor} <br/>
 <i>Atenciosamente,<br/></i> Equipe Jezzy";
 $mail->AltBody = "";
 
 // Define os anexos (opcional)
 // =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
//$mail->AddAttachment("c:/temp/documento.pdf", "novo_nome.pdf");  // Insere um anexo
  // Envia o e-mail
 $enviado = $mail->Send();

// Limpa os destinatários e os anexos
 $mail->ClearAllRecipients();
$mail->ClearAttachments();
}
}
