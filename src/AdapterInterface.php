<?php
/**
 * Created by PhpStorm.
 * User: GuyRadford
 * Date: 24/09/2016
 * Time: 19:44
 */

namespace GuyRadford\TransactioMail;


interface AdapterInterface
{

    public function send(EmailTemplatedMessage $emailMessage);
}