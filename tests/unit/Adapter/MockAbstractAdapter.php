<?php
/**
 * Created by PhpStorm.
 * User: GuyRadford
 * Date: 26/09/2016
 * Time: 20:38
 */

namespace GuyRadford\Test\TransactionMail\Unit\Adapter;

use GuyRadford\TransactionMail\Adapter\AbstractAdapter;
use GuyRadford\TransactionMail\EmailTemplatedMessage;
use GuyRadford\TransactionMail\Result;

class MockAbstractAdapter extends AbstractAdapter
{

    /**
     * @param EmailTemplatedMessage $emailMessage
     * @return Result
     */
    public function sendTemplateEmail(EmailTemplatedMessage $emailMessage)
    {
        // TODO: Implement sendTemplateEmail() method.
    }
}
