<?php
/**
 * Created by PhpStorm.
 * User: GuyRadford
 * Date: 26/09/2016
 * Time: 19:55
 */

namespace GuyRadford\Test\TransactionMail\Unit\Adapter;

use GuyRadford\TransactionMail\Adapter\Void;
use GuyRadford\TransactionMail\EmailTemplatedMessage;
use GuyRadford\TransactionMail\Result;

class VoidTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @test 
     */
    public function test_construct()
    {
        $emailMessage = new EmailTemplatedMessage();

        $adapter = new Void();

        $this->assertTrue($adapter->sendTemplateEmail($emailMessage));

        $result = $adapter->getLastResult();

        $this->assertInstanceOf(Result::class, $result);

        $this->assertTrue($result->getSuccess());
        $this->assertEquals('id-void', $result->getMessageId());
        $this->assertEquals('Message sent to void', $result->getMessage());
    }
}
