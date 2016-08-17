<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MasterProductController
 *
 * @author user
 */
App::import('Vendor', 'PHPExcel');

class MasterProductController extends AppController {

    //put your code here

    public function __construct($request = null, $response = null) {
        $this->layout = 'default_business_master';
        parent::__construct($request, $response);
    }

    public function index() {
        $offers = $this->getAllOffers();
        $myOffers = $this->getAllMyOffers();
		//$statisticsFromAll = $this->getStatisticsFromAllOffers($offers);
        $this->set("offers", $offers);
        $this->set("myOffers", $myOffers);
		//$this->set('statisticsFromAll', $statisticsFromAll);
    }

    private function getAllOffers() {

        $arrayParams = array(
            'Offer' => array(
                'conditions' => array(
                ),
                'order' => array(
                    'Offer.id' => 'DESC'
                ),
            ),
            'Company'
        );
        $offers = $this->AccentialApi->urlRequestToGetData('offers', 'all', $arrayParams);
        $offersWithStatistics = '';
        foreach ($offers as $offer) {
            $statisticsQuery = "select details_click, checkouts_click, purchased_billet, purchased_card, sum(evaluation) evaluation, count(evaluation) votantes
                from offers_statistics 
                inner join offers_comments on offers_statistics.offer_id = offers_comments.offer_id 
                where offers_statistics.offer_id =" . $offer['Offer']['id'] . ";";

            $statisticsParams = array(
                'User' => array(
                    'query' => $statisticsQuery
                )
            );
            $statistics = $this->AccentialApi->urlRequestToGetData('users', 'query', $statisticsParams);
			if(!empty($statistics)){
            $offer['Statistics'] = $statistics[0];
			}
            $offersWithStatistics[] = $offer;
        }
        return $offersWithStatistics;
    }

    public function sendFileXls() {
        $this->layout = "";
        echo $_FILES['xlsFile']['tmp_name'];

        $objReader = new PHPExcel_Reader_Excel5();
        $objReader->setReadDataOnly(true);
        $objPHPExcel = $objReader->load("C:/xampp/htdocs/jezzy-master/portal/app/teste_php.xlsx");
        $objPHPExcel->setActiveSheetIndex(0);
    }

    public function getAllMyOffers() {

        $arrayParams = array(
            'Offer' => array(
                'conditions' => array(
                    'Offer.company_id' => 99999
                ),
                'order' => array(
                    'Offer.id' => 'DESC'
                )
            )
        );
        $offers = $this->AccentialApi->urlRequestToGetData('offers', 'all', $arrayParams);
        $offersWithStatistics = '';
       
            foreach ($offers as $offer) {
                $statisticsQuery = "select details_click, checkouts_click, purchased_billet, purchased_card
                from offers_statistics 
                where offers_statistics.offer_id =" . $offer['Offer']['id'] . ";";

                $statisticsParams = array(
                    'User' => array(
                        'query' => $statisticsQuery
                    )
                );
                $statistics = $this->AccentialApi->urlRequestToGetData('users', 'query', $statisticsParams);
                $offer['Statistics'] = $statistics[0];
                $offersWithStatistics[] = $offer;
            
        }
        return $offersWithStatistics;
    }
	
	public function getStatisticsFromAllOffers($offers = null){
		 $this->autoRender = false;
		$statisticsFromAll = '';
		foreach ($offers as $offer) {
                $statisticsQuery = "select details_click, checkouts_click, purchased_billet, purchased_card
                from offers_statistics 
                where offers_statistics.offer_id =" . $offer['Offer']['id'] . ";";

                $statisticsParams = array(
                    'User' => array(
                        'query' => $statisticsQuery
                    )
                );
				
                $statistics = $this->AccentialApi->urlRequestToGetData('users', 'query', $statisticsParams);
				$id = $offer['Offer']['id'];
                $statisticsFromAll[$id]['Statistics'] = $statistics[0];   
        }
		
		return $statisticsFromAll;
	
	}
        public function offerClickActivate(){
              $this->autoRender = false;
        
       $query = "UPDATE offers SET status = 'INACTIVE' WHERE id = " .$_POST['id']." and status = '".$_POST['status']."';";
        print_r($query);
        $Offersparam = array(
            'User' => array(
                'query' => $query
            )
        );

        $returnOffers = $this->AccentialApi->urlRequestToGetData('users', 'query', $Offersparam);
       
        return $returnOffers;
        }
        public function offerClickDesactivate(){
              $this->autoRender = false;
        
       $query = "UPDATE offers SET status = 'ACTIVE' WHERE id = " .$_POST['id']." and status = '".$_POST['status']."';";
        print_r($query);
        $Offersparam = array(
            'User' => array(
                'query' => $query
            )
        );

        $returnOffers = $this->AccentialApi->urlRequestToGetData('users', 'query', $Offersparam);
       
        return $returnOffers;
        }
		
		   public function configImportOffer() {
        $this->autoRender = false;
        if ($_FILES['file']['tmp_name']) {

//            if (!move_uploaded_file($_FILES['file']['tmp_name'], '../../import_xlsx/' . $_FILES['file']['name'])) {
//                die('Error uploading file - check destination is writeable.');
//            }
//
//            $objReader = new PHPExcel_Reader_Excel5();
//            $objReader->setReadDataOnly(true);
//            $objPHPExcel = $objReader->load("../../import_xlsx/".$_FILES['file']['name']);
//            $objPHPExcel->setActiveSheetIndex(0);
//            
//            print_r($objPHPExcel);
            //Capturamos o arquivo que está sendo upado  no INPUT[FILE]
            $objPHPExcel = PHPExcel_IOFactory::load($_FILES['file']['tmp_name']);

            //capturamos o total de colunas
            $columns = $objPHPExcel->setActiveSheetIndex(0)->getHighestColumn();
            //transformamos o total de colunas em número
            $columnsNumber = PHPExcel_Cell::columnIndexFromString($columns);
            //capturamos o total de linhas
            $rows = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();

            $scripts = '';
            //faremos o foreach baseado no total de linhas, pois será nosso 
            for ($linha = 3; $linha <= $rows; $linha++) {


                $sql = "INSERT INTO offers
(
`company_id`,
`title`,
`resume`,
`description`,
`specification`,
`value`,
`percentage_discount`,
`weight`,
`amount_allowed`,
`begins_at`,
`ends_at`,
`photo`,
`metrics`,
`parcels`,
`parcels_off_impost`,
`public`,
`status`,
`SKU`,
`parcels_quantity`,
`brand`,
`line`,
`result`,
`purchase_price`,
`classification`,
`value_2`,
`percentage_discount_2`,
`value_3`,
`percentage_discount_3`)
VALUES(
{$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(0, $linha)->getValue()},"
                        . "'{$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(1, $linha)->getValue()}',"
                        . "'{$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(2, $linha)->getValue()}',"
                        . "'{$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(3, $linha)->getValue()}',"
                        . "'{$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(4, $linha)->getValue()}',"
                        . "{$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(11, $linha)->getValue()},"
                        . "{$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(12, $linha)->getValue()},"
                        . "{$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(13, $linha)->getValue()},"
                        . "{$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(14, $linha)->getValue()},"
                        . "'{$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(15, $linha)->getValue()}',"
                        . "'{$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(16, $linha)->getValue()}',"
                        . "'FOTO',"
                        . "'{$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(26, $linha)->getValue()}',"
                        . "'{$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(18, $linha)->getValue()}',"
                        . "'PARCELS',"
                        . "'{$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(19, $linha)->getValue()}',"
                        . "'{$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(20, $linha)->getValue()}',"
                        . "'{$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(21, $linha)->getValue()}',"
                        . "{$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(22, $linha)->getValue()},"
                        . "'{$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(23, $linha)->getValue()}',"
                        . "'{$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(24, $linha)->getValue()}',"
                        . "'{$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(5, $linha)->getValue()}',"
                        . "{$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(6, $linha)->getValue()},"
                        . "'{$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(7, $linha)->getValue()}');";

                $scripts[$linha] = $sql;
            }
            
            print_r($scripts);
        }
    }
	
	public function openDirectory(){
		$this->autoRender = false;
		$root = $_SERVER['DOCUMENT_ROOT'];
		echo $root;
	}
        
}
