<?php
/**
 * Created by PhpStorm.
 * User: GuyRadford
 * Date: 24/09/2016
 * Time: 19:49
 */

namespace GuyRadford\TransactioMail\Adapter;


use GuyRadford\TransactioMail\EmailTemplatedMessage;
use Mandrill;

class Null extends AbstractAdapter
{
    /**
     * @var Mandrill
     */
    private $client;


    /**
     * Null constructor.
     * @param Mandrill $client
     */
    public function __construct(Mandrill $client)
    {
        $this->client = $client;
    }

    public function send(EmailTemplatedMessage $emailMessage)
    {
        // TODO: Implement send() method.
    }
    
    
}