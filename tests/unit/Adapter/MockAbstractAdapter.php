<?php
/**
 * Created by PhpStorm.
 * User: GuyRadford
 * Date: 26/09/2016
 * Time: 20:38
 */

namespace GuyRadford\Test\TransactioMail\Unit\Adapter;

use GuyRadford\TransactioMail\Adapter\AbstractAdapter;
use GuyRadford\TransactioMail\EmailTemplatedMessage;
use GuyRadford\TransactioMail\Result;

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
