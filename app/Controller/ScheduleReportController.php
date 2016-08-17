<?php

/**
 * All action about schedule report
 */
class ScheduleReportController extends AppController {

    public function __construct($request = null, $response = null) {
        $this->layout = 'default_business';
        $this->set('title_for_layout', 'Rel.Agendamento');
        parent::__construct($request, $response);
    }

    /**
     * Show populated view
     */
    public function index() {
        $company = $this->Session->read('CompanyLoggedIn');
        $this->set('allSchedules', $this->getAllSchecule($company));
        $this->set('allSchedulesNext', $this->getAllSchecule($company, " > "));
        $this->set('allSchedulesPrevious', $this->getAllSchecule($company, " < "));
    }

    // <editor-fold  defaultstate="collapsed" desc="Private Methods">
    /**
     * Gets all schecule for this company
     * @param type $company
     * @return array whith all schecule
     */
    private function getAllSchecule($company, $dateComparison = "=") {
	date_default_timezone_set("America/Sao_Paulo");
        $scehduleSQL = "
            SELECT schedules.*, secondary_users.*
            FROM schedules
            INNER JOIN secondary_users
                ON schedules.secondary_user_id = secondary_users.id
            WHERE schedules.companie_id = '" . $company['Company'] ['id'] . "'
            AND schedules.date " . $dateComparison . " '" . date('Y-m-d') . "'";
        $scheduleParam = array(
            'Schedule' => array(
                'query' => $scehduleSQL
            )
        );
        return $this->AccentialApi->urlRequestToGetData('schedules', 'query', $scheduleParam);
    }

    // </editor-fold>
    // <editor-fold  defaultstate="collapsed" desc="REMOVE ON PRODUCTION">
    private function setTestVariable() {
        return Array
            (
            0 => Array
                (
                'Schedule' => Array
                    (
                    'id' => 75,
                    'user_id' => 290,
                    'company_id' => 119,
                    'status' => 'DONE',
                    'date' => '2014-10-03 22:20:30',
                    'hour' => '22:22',
                    'value' => 393.70
                ),
                'User' => Array
                    (
                    'id' => 290,
                    'name' => 'Matheus 1'
                ),
                'Sevices_sub_categories' => Array
                    (
                    'id' => 3,
                    'name' => 'Corte Marculino'
                ),
                'Secondary_users' => Array
                    (
                    'id' => 290,
                    'name' => 'Joaozinho'
                )
            ),
            1 => Array
                (
                'Schedule' => Array
                    (
                    'id' => 75,
                    'user_id' => 290,
                    'company_id' => 119,
                    'status' => 'DONE',
                    'date' => '2012-12-03 22:20:30',
                    'hour' => '10:22',
                    'value' => 393.70
                ),
                'User' => Array
                    (
                    'id' => 290,
                    'name' => 'Matheus 13'
                ),
                'Sevices_sub_categories' => Array
                    (
                    'id' => 3,
                    'name' => 'Secagem de unnha'
                ),
                'Secondary_users' => Array
                    (
                    'id' => 290,
                    'name' => 'Mariazinha'
                )
            ),
            2 => Array
                (
                'Schedule' => Array
                    (
                    'id' => 75,
                    'user_id' => 290,
                    'company_id' => 119,
                    'status' => 'DONE',
                    'date' => '2011-11-03 22:20:30',
                    'hour' => '11:22',
                    'value' => 393.70
                ),
                'User' => Array
                    (
                    'id' => 290,
                    'name' => 'Matheus 2'
                ),
                'Sevices_sub_categories' => Array
                    (
                    'id' => 3,
                    'name' => 'Corte Feminino'
                ),
                'Secondary_users' => Array
                    (
                    'id' => 290,
                    'name' => 'Pedrinho'
                )
            )
        );
    }
	
	public function getScheduleDetail(){
		
		$this->layout= '';
		 $scehduleSQL = "
            SELECT schedules.*, secondary_users.*
            FROM schedules
            INNER JOIN secondary_users
                ON schedules.secondary_user_id = secondary_users.id
            WHERE schedules.id = ". $this->request->data['checkoutId'].";";
        $scheduleParam = array(
            'Schedule' => array(
                'query' => $scehduleSQL
            )
        );
       $schedule =  $this->AccentialApi->urlRequestToGetData('schedules', 'query', $scheduleParam);

		$this->set('schedule', $schedule);
		
	}
	
	public function getUserDetail(){
		
		$this->layout= '';
		 $scehduleSQL = "
            SELECT schedules.*, secondary_users.*
            FROM schedules
            INNER JOIN secondary_users
                ON schedules.secondary_user_id = secondary_users.id
            WHERE schedules.id = 19;";
        $scheduleParam = array(
            'Schedule' => array(
                'query' => $scehduleSQL
            )
        );
       $schedule =  $this->AccentialApi->urlRequestToGetData('schedules', 'query', $scheduleParam);

		$this->set('schedule', $schedule);
		
	}

    //</editor-fold>
}
