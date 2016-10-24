<?php
/**
 * Created by PhpStorm.
 * User: GuyRadford
 * Date: 29/09/2016
 * Time: 20:19
 */

namespace GuyRadford\Test\TransactionMail\Unit;


use GuyRadford\TransactionMail\BaseEmailMessage;

class BaseEmailMessageTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var BaseEmailMessage
     */
    protected $emailMessage;


    protected $faker;

    public function setUp()
    {

        $this->faker = \Faker\Factory::create();

        $this->emailMessage = $this->getMockForAbstractClass(BaseEmailMessage::class);
    }


    public function dataProvider_Emails()
    {


        return [
            ['john@example.com', 'John Doe', 'John Doe <john@example.com>'],
            ['john@example.com', '', 'john@example.com'],
        ];

    }

    /**
     * @dataProvider dataProvider_Emails
     * @test
     * @param $email
     * @param $name
     * @param $fullEmail
     */
    public function addTo_list($email, $name, $fullEmail)
    {

        $this->addTo_addCc_addBcc('addTo', 'getTos', $email, $name, $fullEmail);
        $this->addTo_addCc_addBcc('addCc', 'getCcs', $email, $name, $fullEmail);
        $this->addTo_addCc_addBcc('addBcc', 'getBccs', $email, $name, $fullEmail);
    }


    public function addTo_addCc_addBcc($addMethod, $getMethod, $email, $name, $fullEmail)
    {

        $this->emailMessage->$addMethod($email, $name);

        $this->assertEquals(
            $email,
            $this->emailMessage->$getMethod()[$email]->getEmailAddress()
        );

        $this->assertEquals(
            $name,
            $this->emailMessage->$getMethod()[$email]->getName()
        );

        $this->assertEquals($fullEmail, $this->emailMessage->$getMethod()[$email]->toString());
    }


    /**
     * @test
     */
    public function multi_addTo_list()
    {
        foreach (range(1, 3) as $i) {
            $email = $this->faker->email;
            $name = $this->faker->name;
            $fullEmail = "{$name} <{$email}>";

            $this->addTo_addCc_addBcc('addTo', 'getTos', $email, $name, $fullEmail);
            $this->addTo_addCc_addBcc('addCc', 'getCcs', $email, $name, $fullEmail);
            $this->addTo_addCc_addBcc('addBcc', 'getBccs', $email, $name, $fullEmail);

            $this->assertEquals($i, count($this->emailMessage->getTos()));
            $this->assertEquals($i, count($this->emailMessage->getCcs()));
            $this->assertEquals($i, count($this->emailMessage->getBccs()));
        }
    }

    /**
     * @test
     */
    public function setReplyTo()
    {

        $email = $this->faker->email;
        $name = $this->faker->name;
        $fullEmail = "{$name} <{$email}>";
        $this->emailMessage->setReplyTo($email, $name);

        $this->assertEquals($fullEmail, $this->emailMessage->getReplyTo()->toString());


        $email = $this->faker->email;
        $name = $this->faker->name;
        $fullEmail = "{$name} <{$email}>";
        $this->emailMessage->setReplyTo($email, $name);

        $this->assertEquals($fullEmail, $this->emailMessage->getReplyTo()->toString());
    }

    /**
     * @test
     */
    public function setFrom()
    {

        $email = $this->faker->email;
        $name = $this->faker->name;
        $fullEmail = "{$name} <{$email}>";
        $this->emailMessage->setFrom($email, $name);

        $this->assertEquals($fullEmail, $this->emailMessage->getFrom()->toString());


        $email = $this->faker->email;
        $name = $this->faker->name;
        $fullEmail = "{$name} <{$email}>";
        $this->emailMessage->setFrom($email, $name);

        $this->assertEquals($fullEmail, $this->emailMessage->getFrom()->toString());
    }

    /**
     * @test
     */
    public function setSubject()
    {

        $subject = $this->faker->sentence;
        $this->emailMessage->setSubject($subject);

        $this->assertEquals($subject, $this->emailMessage->getSubject());


        $subject = $this->faker->sentence;
        $this->emailMessage->setSubject($subject);

        $this->assertEquals($subject, $this->emailMessage->getSubject());
    }


    /**
     * @test
     */
    public function addHeader()
    {


        foreach (range(1, 3) as $i) {
            $header = "Header-$i";
            $value = $this->faker->sentence;
            $this->emailMessage->addHeader($header, $value);

            $this->assertEquals(
                $value,
                $this->emailMessage->getHeaders()[$header]
            );
            $this->assertEquals($i, count($this->emailMessage->getHeaders()));
        }

    }
}
