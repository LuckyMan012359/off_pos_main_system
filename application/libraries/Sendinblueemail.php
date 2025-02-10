<?php

use SendinBlue\Client\Configuration;
use SendinBlue\Client\Api\TransactionalEmailsApi;
use SendinBlue\Client\Model\SendSmtpEmail;
use SendinBlue\Client\Model\SendSmtpEmailTo;
use SendinBlue\Client\Model\SendSmtpEmailSender;
use SendinBlue\Client\Model\SendSmtpEmailAttachment;

class SendinBlueEmail
{
    protected $CI;
    public function __construct()
    {
        $this->CI =& get_instance();
    }
    public function sendEmail($mail_data)
    {
        $company_smtp = json_decode(getCompanySMTP($mail_data['company_id']));
        require_once FCPATH . 'vendor/autoload.php';
        // Create a new configuration instance
        $config = Configuration::getDefaultConfiguration();
        $config->setApiKey('api-key', "$company_smtp->api_key");
        // Create an instance of the TransactionalEmailsApi
        $apiInstance = new TransactionalEmailsApi(new GuzzleHttp\Client(), $config);
        // Create a new SendSmtpEmail object
        $email = new SendSmtpEmail();
        $sender = new SendSmtpEmailSender();

        $sender->setName($company_smtp->from_name);
        $sender->setemail($company_smtp->from_email);
        $email->setSender($sender);

        $recipients = [];

        foreach ($mail_data['to'] as $recipient) {
            $toObject = new SendSmtpEmailTo();
            $toObject->setEmail($recipient);
            $recipients[] = $toObject;
            if(isset($mail_data['file_path'])){
                if ($mail_data['file_path'] !== null) {
                    $attachment = new SendSmtpEmailAttachment();
                    $attachment->setName($mail_data['file_name']);
                    $attachment->setContent(base64_encode(file_get_contents($mail_data['file_path'])));
                    $email->setAttachment([$attachment]);
                }
            }
        }


        $email->setTo($recipients);
        $email->setSubject($mail_data['subject']);
        $email->setHtmlContent($mail_data['template']);
        try {
            // Send the email
            $result = $apiInstance->sendTransacEmail($email);
            return true; // Email sent successfully
        } catch (Exception $e) {
            echo 'Error sending email: ', $e->getMessage();
            return false; // Email sending failed
        }


    }
}


