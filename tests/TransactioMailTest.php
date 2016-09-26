<?php
/**
 * Created by PhpStorm.
 * User: GuyRadford
 * Date: 26/09/2016
 * Time: 21:02
 */

namespace Test\TransactioMail;

use GuyRadford\TransactioMail\Adapter\Void;
use GuyRadford\TransactioMail\EmailTemplatedMessage;
use GuyRadford\TransactioMail\TransactioMail;

class TransactioMailTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     */
    public function test_construct_method()
    {
        $adapter = $this->prophesize(Void::class);

        $transactioMail = new TransactioMail($adapter->reveal());

        $this->assertTrue(method_exists($transactioMail, 'sendTemplateEmail'));
    }

    /**
     * @test
     */
    public function method_sendTemplateEmail_calls_adapter()
    {
        $emailMessage = new EmailTemplatedMessage();

        $adapter = $this->prophesize(Void::class);

        $adapter->sendTemplateEmail($emailMessage)->shouldBeCalledTimes(1)->willReturn(true);

        $transactioMail = new TransactioMail($adapter->reveal());

        $result = $transactioMail->sendTemplateEmail($emailMessage);
        $this->assertTrue($result);
    }
}
