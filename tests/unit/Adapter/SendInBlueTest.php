<?php
/**
 * Created by PhpStorm.
 * User: GuyRadford
 * Date: 26/09/2016
 * Time: 19:55
 */

namespace GuyRadford\Test\TransactioMail\Unit\Adapter;

use GuyRadford\TransactioMail\Adapter\SendInBlue;
use GuyRadford\TransactioMail\EmailTemplatedMessage;
use GuyRadford\TransactioMail\Result;
use Sendinblue\Mailin;
use GuyRadford\Test\TransactioMail\Unit\TestTraits;

class SendInBlueTest extends \PHPUnit_Framework_TestCase
{
    protected $client;

    use TestTraits;

    public function setUp()
    {
        $this->client = $this->prophesize(Mailin::class);
    }


    /**
     * @test
     */
    public function getClient(){
        
        $client = $this->client->reveal();
        
        $adapter = new SendInBlue($client);

        $actual = $this->invokeMethod(
            $adapter,
            'getClient',
            []
        );

        $this->assertEquals($client, $actual);
    }
    

    /**
     * @test
     */
    public function sendTemplateEmail_calls_correct_methods()
    {


        $emailMessage = (new EmailTemplatedMessage())
            ->setTemplate('temp1')
            ->addTo('test1@example.com', 'test1')
            ->addTo('test2@example.com', 'test2')
            ->addCc('cc@example.com', 'cc')
            ->addBcc('bcc@example.com', 'bcc')
            ->setSubject('set subject')
            ->setReplyTo('replay-to@example.com')
            ->addMergeField('field1', 'value')
            ->addHeader('header-1', 'head');
        
        
        $resultArray = ['result' => true];
        $result = new Result(true, 'id-test', 'test');
        $messageData = [
            "id" => 'temp1',
            "to" => 'test1@example.com|test2@example.com',
            "cc" => 'cc@example.com',
            "bcc" => 'bcc@example.com',
            "attr" => [
                'SUBJECT' => 'set subject',
                'FIELD1'=> 'value'
            ],

            "replyto" => 'replay-to@example.com',
//			"attachment_url" => "",
//			"attachment" => array("myfilename.pdf" => "your_pdf_files_base64_encoded_chunk_data"),
            "headers" => ['header-1'=> 'head']
        ];

        $this->client->send_transactional_template($messageData)->shouldBeCalledTimes(1)->willReturn($resultArray);


        $adapter = $this
            ->getMockBuilder(SendInBlue::class)
            ->setConstructorArgs([$this->client->reveal()])
            ->setMethods(['getClient', 'getMessageData', 'builtResult'])
            ->getMock();

        $adapter
            ->expects($this->once())
            ->method('getMessageData')
            ->with($emailMessage)
            ->willReturn($messageData);

        $adapter
            ->expects($this->once())
            ->method('getClient')
            ->willReturn($this->client->reveal());


        $adapter
            ->expects($this->once())
            ->method('builtResult')
            ->with($resultArray)
            ->willReturn($result);


        $actualResult = $adapter->sendTemplateEmail($emailMessage);

        $this->assertEquals($result, $actualResult);


    }


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

    /**
     * @test
     */
    public function builtResult(){
        $resultArray = json_decode('{
  "code":"success",
  "message":"Email sent successfully",
  "data":{
      "message-id":"<201510300611.57110859183@smtp-relay.sendinblue.com>"
    }
  }', true);
        
        $expected =  Result::create(true, '201510300611.57110859183@smtp-relay.sendinblue.com', 'Email sent successfully');

        $adapter = new SendInBlue($this->client->reveal());

        $actual = $this->invokeMethod(
            $adapter,
            'builtResult',
            [$resultArray]
        );

        $this->assertEquals($expected, $actual);
    }


    /**
     * @test
     */
    public function getMessageData(){

        $emailMessage = (new EmailTemplatedMessage())
            ->setTemplate('temp1')
            ->addTo('test1@example.com', 'test1')
            ->addTo('test2@example.com', 'test2')
            ->addCc('cc@example.com', 'cc')
            ->addBcc('bcc@example.com', 'bcc')
            ->setSubject('set subject')
            ->setReplyTo('replay-to@example.com')
            ->addMergeField('field1', 'value')
            ->addHeader('header-1', 'head');

        $expected = [
            "id" => 'temp1',
            "to" => 'test1@example.com|test2@example.com',
            "cc" => 'cc@example.com',
            "bcc" => 'bcc@example.com',
            "attr" => [
                'SUBJECT' => 'set subject',
                'FIELD1'=> 'value'
            ],
        
            "replyto" => 'replay-to@example.com',
//			"attachment_url" => "",
//			"attachment" => array("myfilename.pdf" => "your_pdf_files_base64_encoded_chunk_data"),
            "headers" => ['header-1'=> 'head']
        ];

        $adapter = new SendInBlue($this->client->reveal());

        $actual = $this->invokeMethod(
            $adapter,
            'getMessageData',
            [$emailMessage]
        );

        $this->assertEquals($expected, $actual);
    }
}
