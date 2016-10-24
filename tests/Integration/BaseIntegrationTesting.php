<?php
/**
 * Created by PhpStorm.
 * User: GuyRadford
 * Date: 04/10/2016
 * Time: 22:06
 */


namespace GuyRadford\Test\TransactionMail\Integration;

use ContextIO;


class BaseIntegrationTesting extends \PHPUnit_Framework_TestCase
{


    protected function deleteAllEmails()
    {

        $emails = $this->getEmailList();
        foreach ($emails as $emailId)
            $this->deleteEmail($emailId);
    }

    protected function getEmailList()
    {

        $contextIO = $this->getContextIO();

        $r = $contextIO->listMessages(ContextIO_AccountId);
        $emailList = [];

        foreach ($r->getData() as $message) {
            $emailList[] = $message['message_id'];
        }
        return $emailList;

    }

    /**
     * @param string $emailId
     */
    protected function getEmail($emailId)
    {
        $contextIO = $this->getContextIO();
        $message = $contextIO->getMessage(
            ContextIO_AccountId,
            [
                'message_id' => $emailId,
                'include_body' => 1,
                'include_headers' => 1
            ]
        );
        return $message->getData();
    }

    protected function deleteEmail($emailId)
    {
        $contextIO = $this->getContextIO();
        $message = $contextIO->deleteMessage(ContextIO_AccountId, ['message_id' => $emailId]);
        return $message;
    }

    /**
     * @return ContextIO
     */
    protected function getContextIO()
    {
        return new ContextIO(ContextIO_Key, ContextIO_Secret);

    }

    protected function getHtmlBody($message)
    {
        foreach ($message['body'] as $body) {
            if ($body['type'] == 'text/html')
                return $body['content'];
        }
    }

    protected function getTextBody($message)
    {
        foreach ($message['body'] as $body) {
            if ($body['type'] == 'text/plain')
                return $body['content'];
        }
    }

    protected function getSubject($message)
    {
        return $message['subject'];
    }
    
    public function setUp()
    {
//        $this->deleteAllEmails();
    }
    
    
}
