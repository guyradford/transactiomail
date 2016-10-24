<?php
/**
 * Created by PhpStorm.
 * User: GuyRadford
 * Date: 04/10/2016
 * Time: 22:06
 */

namespace GuyRadford\Test\TransactionMail\Integration\SendInBlue;

require_once "config.php";

use GuyRadford\Test\TransactionMail\Integration\BaseIntegrationTesting;
use GuyRadford\TransactionMail\Adapter\SendInBlue;
use GuyRadford\TransactionMail\EmailTemplatedMessage;
use GuyRadford\TransactionMail\Exception\InvalidApiAuthenticationException;
use GuyRadford\TransactionMail\TransactionMail;
use Sendinblue\Mailin;

class SendInBlueTest extends BaseIntegrationTesting
{

    /**
     * @test
     * @expectedException \GuyRadford\TransactionMail\Exception\InvalidApiAuthenticationException
     */
    public function invalid_api_key()
    {
        $mailin = new Mailin("https://api.sendinblue.com/v2.0", "INVALID");
        $adapter = new SendInBlue($mailin);
        $transactionMail = new TransactionMail($adapter);

        $email = (new EmailTemplatedMessage())
            ->setFrom('from@example.co.uk')
            ->addTo('to@example.com')
            ->setSubject('Testing')
            ->addMergeField('firstname', 'John');

        $transactionMail->sendTemplateEmail($email);
    }

    /**
     * @test
     * @expectedException \GuyRadford\TransactionMail\Exception\InvalidTemplateIdException
     */
    public function invalid_template()
    {
        $mailin = new Mailin("https://api.sendinblue.com/v2.0", SendInBlue_ApiKey_V2);
        $adapter = new SendInBlue($mailin);
        $transactionMail = new TransactionMail($adapter);

        $email = (new EmailTemplatedMessage())
            ->setTemplate('invalid')
            ->setFrom('from@example.co.uk')
            ->addTo('to@example.com')
            ->setSubject('Testing')
            ->addMergeField('firstname', 'John');

        $transactionMail->sendTemplateEmail($email);
    }

    /**
     * @test
     * @expectedException \GuyRadford\TransactionMail\Exception\InvalidTemplateIdException
     */
    public function invalid_template_number()
    {
        $mailin = new Mailin("https://api.sendinblue.com/v2.0", SendInBlue_ApiKey_V2);
        $adapter = new SendInBlue($mailin);
        $transactionMail = new TransactionMail($adapter);

        $email = (new EmailTemplatedMessage())
            ->setTemplate(999)
            ->setFrom('from@example.co.uk')
            ->addTo('to@example.com')
            ->setSubject('Testing')
            ->addMergeField('firstname', 'John');

        $transactionMail->sendTemplateEmail($email);
    }
    
    /**
     * @test
     * @expectedException \GuyRadford\TransactionMail\Exception\RequiredFieldMissingException
     */
    public function missing_to_address()
    {
        $mailin = new Mailin("https://api.sendinblue.com/v2.0", SendInBlue_ApiKey_V2);
        $adapter = new SendInBlue($mailin);
        $transactionMail = new TransactionMail($adapter);

        $email = (new EmailTemplatedMessage())
            ->setTemplate(SendInBlue_TemplateId)
            ->setFrom('from@example.co.uk')
//            ->addTo('to@example.com')
            ->setSubject('Testing')
            ->addMergeField('firstname', 'John');

        $transactionMail->sendTemplateEmail($email);
    }


    public function send_email_template_and_read()
    {
    }


//    /**
//     * @test
//     */
//    public function read_email(){
//
//        $emailList = $this->getEmailList();
//        $message = $this->getEmail($emailList[0]);
//        print_r($this->getSubject($message));
//        print_r($this->getTextBody($message));
//        print_r($this->getHtmlBody($message));
//        
//    }


}
