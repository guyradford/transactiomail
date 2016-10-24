<?php
/**
 * Created by PhpStorm.
 * User: GuyRadford
 * Date: 26/09/2016
 * Time: 21:02
 */

namespace GuyRadford\Test\TransactionMail\Unit;

use GuyRadford\TransactionMail\Adapter\Void;
use GuyRadford\TransactionMail\EmailTemplatedMessage;
use GuyRadford\TransactionMail\TransactionMail;

class TransactionMailTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     */
    public function test_construct_method()
    {
        $adapter = $this->prophesize(Void::class);

        $transactionMail = new TransactionMail($adapter->reveal());

        $this->assertTrue(method_exists($transactionMail, 'sendTemplateEmail'));
    }

    /**
     * @test
     */
    public function method_sendTemplateEmail_calls_adapter()
    {
        $emailMessage = new EmailTemplatedMessage();

        $adapter = $this->prophesize(Void::class);

        $adapter->sendTemplateEmail($emailMessage)->shouldBeCalledTimes(1)->willReturn(true);

        $transactionMail = new TransactionMail($adapter->reveal());

        $result = $transactionMail->sendTemplateEmail($emailMessage);
        $this->assertTrue($result);
    }
}
