<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require("../../Vendor/phpmailer/PHPMailerAutoload.php");

class SendEmailsComponent extends Component {

    public function enviarEmailAgendamentoConfirmado($email) {

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

        
        $bodyEmail = '<table border="0" cellpadding="0" cellspacing="0"  style="background: #f2f2f2;">
            <tr>
                <td colspan="4"><img src="files/agendamento-confirmado/01.jpg"  style="vertical-align: bottom;"/></td>
            </tr>
            <tr>
                <td colspan="4"><img src="files/agendamento-confirmado/01-2.jpg"  style="vertical-align: bottom;"/></td>
            </tr>
            <tr>
                <td colspan="4"><img src="files/agendamento-confirmado/02.jpg"  style="vertical-align: bottom;"/></td>
            </tr>
            <tr style="color: #9b9b9b;  font-family: Helvetica, Arial, sans-serif; font-size: 12px;">
                <td style="width: 175px; text-align: right;">Corte de Cabelo</td>
                <td style="text-align: center;">20/04/2016</td>
                <td style="width: 170px;">12:00</td>
                <td style="width: 150px;">Januaria</td>
            </tr>
            <tr>
                <td colspan="4"><br/><br/><img src="files/agendamento-confirmado/03.jpg"  style="vertical-align: bottom;"/></td>
            </tr>
            <tr style="color: #9b9b9b;  font-family: Helvetica, Arial, sans-serif; font-size: 14px;">
                <td style="width: 150px; text-align: center;" colspan="4">
                    <br/>
                    <span><b>Salão Beauty Hair</b></span><br/>
                    <span>
                        Rua Cubatão, 411 - Bairro Paraiso - CEP 01234-500 - São Paulo - SP<br/>
                        Telefone: 11 9898-9898 - Horário de Funcionamento: Ter - Sáb das 09 às 20hrs
                    </span>
                    <br/>
                </td>
            </tr>
            <tr>
                <td colspan="4"><img src="files/agendamento-confirmado/04.jpg"  style="vertical-align: bottom;"/></td>
            </tr>
               <tr>
                <td colspan="1"><img src="http://www.schabla.com.br/jezzy_images/transacao-finalizada/07.jpg" width="151" style="vertical-align: bottom; text-align: center;"/></td>
                <td  colspan="1"><img src="http://www.schabla.com.br/jezzy_images/transacao-finalizada/08.jpg" width="151" style="vertical-align: bottom; text-align: center;"/></td>
                <td colspan="1"> <img src="http://www.schabla.com.br/jezzy_images/transacao-finalizada/09.jpg" width="151" style="vertical-align: bottom; text-align: center;"/></td>
                <td colspan="1"><img src="http://www.schabla.com.br/jezzy_images/transacao-finalizada/10.jpg" width="151" style="vertical-align: bottom; text-align: center;"/></td>
            </tr>
             <tr>
                <td colspan="4" style="text-align: center;">
                    <img src="http://www.schabla.com.br/jezzy_images/transacao-finalizada/12.jpg"  style="vertical-align: bottom;"/>
                </td>
            </tr>
        </table>';
        
        $mail->AddAddress("{$email}");

        // Define os dados técnicos da Mensagem
// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
        $mail->IsHTML(true); // Define que o e-mail será enviado como HTML
        $mail->CharSet = 'iso-8859-1'; // Charset da mensagem (opcional)
// Define a mensagem (Texto e Assunto)
// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
        $mail->Subject = "Agendamento Confirmado!"; // Assunto da mensagem
        $mail->Body = $bodyEmail;
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

    public function enviarEmailInatividade($email) {
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
        
        $emailBody = '<table border="0" cellpadding="0" cellspacing="0" >
            <tr>
                <td colspan="4"><img src="http://www.schabla.com.br/jezzy_images/inatividade/01.jpg" width="600" style="vertical-align: bottom;"/></td>
            </tr>
            <tr style="background: #f7f7f7; text-align: center;">
                <td colspan="4">
                    <br/>
                    <span style="color: #999933; font-family: Helvetica, Arial, sans-serif; font-size: 36px;"><i>Paola, tudo bem com você?</i></span>
                    <br/>
                    <br/>
                </td>
            </tr>
            <tr>
                <td colspan="4"><img src="http://www.schabla.com.br/jezzy_images/inatividade/03-2.jpg" width="600" style="vertical-align: bottom;"/></td>
            </tr>
            <tr style="background: #f7f7f7; text-align: center;">
                <td colspan="4">
                    <span style="color: #9B9B9B; font-family: Helvetica, Arial, sans-serif; font-size: 12px;"><b>Acessa para responder a pesquisa: <a  href="www.jezzy.com.br/portal/answers" style="color: #2597AC; font-size: 12px;  font-family: Helvetica, Arial, sans-serif; text-decoration: none;">http://www.jezzy.com.br/portal/answers</a></b></span>
                    <br/>
                </td>
            </tr>
             <tr style="background: #f7f7f7;">
                <td colspan="4">
                    <br/>
                    <img src="http://www.schabla.com.br/jezzy_images/transacao-finalizada/04.jpg" width="600"/>
                    <br/>
                </td>
            </tr>
            <tr style="background: #f7f7f7; width: 600px;">
                <td style="width: 50px;" colspan="1">
                </td>
                <td style="width: 150px; text-align: right;" colspan="1">
                    <a href="#"><img src="http://www.schabla.com.br/jezzy_images/transacao-finalizada/App Store.png" width="80"/></a>
                </td>
                <td style="width: 150px; text-align: left;" colspan="1">
                    <a href="#"> <img src="http://www.schabla.com.br/jezzy_images/transacao-finalizada/App Store.png" width="80"/></a>
                </td>
                <td style="width: 50px;" colspan="1">
                </td>
            </tr>
            <tr>
                <td colspan="4">
                    <img src="http://www.schabla.com.br/jezzy_images/transacao-finalizada/05-1.jpg" width="600" height="30" style="vertical-align: bottom;"/>
                </td>
            </tr>
            <tr>
                <td colspan="4">
                    <img src="http://www.schabla.com.br/jezzy_images/transacao-finalizada/06.jpg" width="600" style="vertical-align: bottom;"/>
                </td>
            </tr>
            <tr>
                <td colspan="1"><img src="http://www.schabla.com.br/jezzy_images/transacao-finalizada/07.jpg" width="151" style="vertical-align: bottom;"/></td>
                <td  colspan="1"><img src="http://www.schabla.com.br/jezzy_images/transacao-finalizada/08.jpg" width="151" style="vertical-align: bottom;"/></td>
                <td colspan="1"> <img src="http://www.schabla.com.br/jezzy_images/transacao-finalizada/09.jpg" width="151" style="vertical-align: bottom;"/></td>
                <td colspan="1"><img src="http://www.schabla.com.br/jezzy_images/transacao-finalizada/10.jpg" width="151" style="vertical-align: bottom;"/></td>
            </tr>
            <tr>
                <td colspan="4">
                    <img src="http://www.schabla.com.br/jezzy_images/transacao-finalizada/11.jpg" width="600" style="vertical-align: bottom;"/>
                </td>
            </tr>
            <tr>
                <td colspan="4">
                    <img src="http://www.schabla.com.br/jezzy_images/transacao-finalizada/12.jpg" width="600" style="vertical-align: bottom;"/>
                </td>
            </tr>
         </table>
        ';
        
        $mail->Subject = "Sentimos sua falta"; // Assunto da mensagem
        $mail->Body = $emailBody;
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
