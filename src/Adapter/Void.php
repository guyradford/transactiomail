<?php
/**
 * Created by PhpStorm.
 * User: GuyRadford
 * Date: 24/09/2016
 * Time: 19:49
 */

namespace GuyRadford\TransactioMail\Adapter;


use GuyRadford\TransactioMail\EmailTemplatedMessage;

class Void extends AbstractAdapter
{

    public function send(EmailTemplatedMessage $emailMessage)
    {
        return true;
    }
}