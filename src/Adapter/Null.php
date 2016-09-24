<?php
/**
 * Created by PhpStorm.
 * User: GuyRadford
 * Date: 24/09/2016
 * Time: 19:49
 */

namespace GuyRadford\TransactioMail\Adapter;


use GuyRadford\TransactioMail\EmailTemplatedMessage;

class Null extends AbstractAdapter
{

    public function send(EmailTemplatedMessage $emailMessage)
    {
        // TODO: Implement send() method.
    }
}