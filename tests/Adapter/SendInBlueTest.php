<?php
/**
 * Created by PhpStorm.
 * User: GuyRadford
 * Date: 26/09/2016
 * Time: 19:55
 */

namespace Test\TransactioMail\Adapter;

use GuyRadford\TransactioMail\Adapter\SendInBlue;
use GuyRadford\TransactioMail\Adapter\Void;
use GuyRadford\TransactioMail\EmailTemplatedMessage;
use GuyRadford\TransactioMail\Result;
use Sendinblue\Mailin;
use Test\TransactioMail\TestTraits;

class SendInBlueTest extends \PHPUnit_Framework_TestCase
{
    protected $client;

    use TestTraits;

    public function setUp()
    {
        $this->client = $this->prophesize(Mailin::class);
    }


//    /**
//     * @test
//     */
//    public function test_construct()
//    {
//        $emailMessage = new EmailTemplatedMessage();
//
//        $adapter = new Void();
//
//        $this->assertTrue($adapter->sendTemplateEmail($emailMessage));
//
//        $result = $adapter->getLastResult();
//
//        $this->assertInstanceOf(Result::class, $result);
//
//        $this->assertTrue($result->getSuccess());
//        $this->assertEquals('id-void', $result->getMessageId());
//        $this->assertEquals('Message sent to void', $result->getMessage());
//    }

//    /**
//     * @test
//     */
//    public function sendTemplateEmail_calls_correct_methods()
//    {
//
//
//        $emailMessage = new EmailTemplatedMessage();
//        $resultArray = ['result' => true];
//        $result = new Result(true, 'id-test', 'test');
//        $messageData = ['message' => 'test'];
//
//        $this->client->send_transactional_template($messageData)->shouldBeCalledTimes(1)->willReturn($resultArray);
//
//        $adapter = $this->prophesize(SendInBlue::class);
//        $adapter->willBeConstructedWith([$this->client->reveal()]);
//
//
//        $adapter->getMessageData($emailMessage)->shouldBeCalledTimes(1)->willReturn($messageData);
//        $adapter->builtResult($resultArray)->shouldBeCalledTimes(1)->willReturn($result);
//
//        $actualResult = $adapter->reveal()->sendTemplateEmail($emailMessage);
//
//        $this->assertEquals($result, $actualResult);
//
//
//    }


    /**
     * @return array
     */
    public function dataProvider_getMergeFields()
    {
        return [
            [
                [
                    'key1' => 'value1',
                    'key2' => 'value2'
                ],
                'subject',
                [
                    'SUBJECT' => 'subject',
                    'KEY1' => 'value1',
                    'KEY2' => 'value2'
                ]
            ],            
            [
                [
                    'key1' => 'value1',
                    'key2' => 'value2'
                ],
                '',
                [
                    'KEY1' => 'value1',
                    'KEY2' => 'value2'
                ]
            ],
            [
                [
                    'key1' => 'value1',
                    'key2' => 'value2',
                    'subject' => 'new' 
                ],
                'old',
                [
                    'SUBJECT' => 'new',
                    'KEY1' => 'value1',
                    'KEY2' => 'value2'
                ]
            ],            
            [
                [
                    'key1' => 'value1',
                    'key2' => 'value2',
                    'subject' => 'new' 
                ],
                '',
                [
                    'SUBJECT' => 'new',
                    'KEY1' => 'value1',
                    'KEY2' => 'value2'
                ]
            ],
            
            
        ];

    }


    /**
     * @dataProvider dataProvider_getMergeFields
     * @test
     * @param array $fields
     * @param string $subject
     * @param array $expected
     */
    public function getMergeFields($fields, $subject, $expected)
    {
        
        $adapter = new SendInBlue($this->client->reveal());

        $actual = $this->invokeMethod(
            $adapter,
            'getMergeFields',
            [$fields, $subject]
        );

        $this->assertEquals($expected, $actual);

    }
}
