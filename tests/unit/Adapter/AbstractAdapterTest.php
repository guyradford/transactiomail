<?php
/**
 * Created by PhpStorm.
 * User: GuyRadford
 * Date: 26/09/2016
 * Time: 19:33
 */

namespace GuyRadford\Test\TransactionMail\Unit\Adapter;

use GuyRadford\TransactionMail\EmailTemplatedMessage;
use GuyRadford\TransactionMail\ValueObject\EmailAddress;
use GuyRadford\Test\TransactionMail\Unit\TestTraits;

class AbstractAdapterTest extends \PHPUnit_Framework_TestCase
{
    use TestTraits;

    /**
     * @test
     */
    public function test_getHeadersAsArray()
    {
        $emailMessage = (new EmailTemplatedMessage())
            ->addHeader('header1', 'value1')
            ->addHeader('header2', 'value2');

        $expected = [
            'header1' => 'value1',
            'header2' => 'value2'
        ];

        $adapter = new MockAbstractAdapter();
        $result = $this->invokeMethod($adapter, 'getHeadersAsArray', [$emailMessage]);

        $this->assertEquals($expected, $result);
    }


    public function dataProvider_getListOfEmails()
    {
        return [
            [
                [
                    EmailAddress::create('test@example.com', 'test'),
                    EmailAddress::create('test1@example.com', 'test1')
                ],
                ',',
                true,
                'test@example.com,test1@example.com'
            ],
            [
                [
                    EmailAddress::create('test@example.com', 'test'),
                    EmailAddress::create('test1@example.com', 'test1')
                ],
                ';',
                true,
                'test@example.com;test1@example.com'
            ],
            [
                [
                    EmailAddress::create('test@example.com', 'test'),
                    EmailAddress::create('test1@example.com', 'test1')
                ],
                '|',
                false,
                'test <test@example.com>|test1 <test1@example.com>'
            ]
        ];
    }

    /**
     * @dataProvider dataProvider_getListOfEmails
     * @test
     */
    public function test_getListOfEmails($emailAddressList, $separator, $emailOnly, $expacted)
    {
        $adapter = new MockAbstractAdapter();
        $result = $this->invokeMethod($adapter, 'getListOfEmails', [$emailAddressList, $separator, $emailOnly]);

        $this->assertEquals($expacted, $result);
    }
}
