<?php

require("../Vendor/pushbots/PushBots.class.php");

class MobileNotificationController extends AppController {

    public function __construct($request = null, $response = null) {
        $this->layout = '';
        $this->set('title_for_layout', '');
        parent::__construct($request, $response);
    }

    /**
     * Envia notificação apenas para UM usuário especifico
     * @param type $userId
     * @param type $message
     */
    public function sendMobileNotification($userId = null, $message = null) {

        //captura dados do usuario destinatario
        $query = "select * from users_using where user_id = 439;";
        $params = array(
            'User' => array(
                'query' => $query
            )
        );
        $destinatario = $this->AccentialApi->urlRequestToGetData('users', 'query', $params);

        print_r($destinatario);

        /*
         * Inicia envio da Push
         */
        $pb = new PushBots();
        $appID = '56f2db1e4a9efa66868b4567';
        $appSecret = 'c0e22a98aee35816d1266a4c20bc9979';
        $pb->App($appID, $appSecret);

        //mensagem
        $pb->AlertOne($message);

        if ($destinatario[0]['users_using']['android'] == 'ACTIVE') {
            $pb->PlatformOne("1");
        } else if ($destinatario[0]['users_using']['ios'] == 'ACTIVE') {
            $pb->PlatformOne("0");
        }

        //captura registration id do usuario
        $pb->TokenOne($destinatario[0]['users_using']['reg_id']);

        //Push to Single Device
        $pb->PushOne();
    }

    /**
     * Envia a mesma notificação para todos os usuários
     * @param type $message
     */
    public function sendPublicMobileNotification($message = null) {
        $this->autoRender = false;
        $pb = new PushBots();
// Application ID
        $appID = '56f2db1e4a9efa66868b4567';
// Application Secret
        $appSecret = 'c0e22a98aee35816d1266a4c20bc9979';
        $pb->App($appID, $appSecret);
// Notification Settings
        $platforms[0] = 0;
        $platforms[1] = 1;

        $pb->Alert($message);

        $pb->Platform($platforms);
// Custom fields - payload data
        $customfields = array("author" => "Jeff", "nextActivity" => "com.example.sampleapp.Next");
        $pb->Payload($customfields);
// Push it !
        $pb->Push();
    }

}
