<?php
/**
 * Created by PhpStorm.
 * User: GuyRadford
 * Date: 24/09/2016
 * Time: 19:49
 */

namespace GuyRadford\TransactionMail\Adapter;

use GuyRadford\TransactionMail\EmailTemplatedMessage;
use GuyRadford\TransactionMail\Result;

class Void extends AbstractAdapter
{
    /**
     * Void constructor.
     */
    public function __construct()
    {
        $this->lastResult = Result::create(true, 'id-void', 'Message sent to void');
    }


    /**
     * @param EmailTemplatedMessage $emailMessage
     * @return Result
     */
    public function sendTemplateEmail(EmailTemplatedMessage $emailMessage)
    {
        return true;
    }
}
