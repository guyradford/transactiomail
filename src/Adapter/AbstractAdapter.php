<?php
/**
 * Created by PhpStorm.
 * User: GuyRadford
 * Date: 24/09/2016
 * Time: 19:46
 */

namespace GuyRadford\TransactioMail\Adapter;


use GuyRadford\TransactioMail\AdapterInterface;
use GuyRadford\TransactioMail\BaseEmailMessage;
use GuyRadford\TransactioMail\Result;
use GuyRadford\TransactioMail\ValueObject\EmailAddress;

abstract class AbstractAdapter implements AdapterInterface
{
    /**
     * @var Result
     */
    protected $lastResult;


    /**
     * @return null|Result
     */
    public function getLastResult()
    {
        return $this->lastResult;
    }

    /**
     * @param BaseEmailMessage $emailMessage
     * @return array
     */
    protected function getHeadersAsArray(BaseEmailMessage $emailMessage){
        $headers = [];
        
        return $emailMessage->getHeaders();

//        array_walk($emailMessage->getHeaders(), function ($value, $key) use($headers){
//            $headers[$key] = $value;
//        });
//
//        return $headers;
    }


    /**
     * @param array $emailAddressList
     * @param string $separator
     * @param bool $emailOnly
     * @return string
     */
    protected function getListOfEmails($emailAddressList, $separator = ';', $emailOnly = true)
    {
        $emails = [];

        array_walk($emailAddressList, function (EmailAddress $email) use (&$emails, $emailOnly) {
            if($emailOnly)
                $emails[] = $email->getEmailAddress();
            else
                $emails[] = $email->toString();
        });

        return implode($separator, $emails);
    }
}