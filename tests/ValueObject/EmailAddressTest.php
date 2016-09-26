<?php
/**
 * Created by PhpStorm.
 * User: GuyRadford
 * Date: 24/09/2016
 * Time: 20:24
 */

namespace Test\TransactioMail\ValueObject;

use GuyRadford\TransactioMail\ValueObject\EmailAddress;

class EmailAddressTest extends \PHPUnit_Framework_TestCase
{
    public function create_data_provider()
    {
        return [
            [
                'invalid_email',
                'name',
                \Exception::class,
                'Value "invalid_email" was expected to be a valid e-mail address.'
            ],
            [
                '',
                'name',
                \Exception::class,
                'Value "" was expected to be a valid e-mail address.'
            ],
            [
                'example.com',
                'name',
                \Exception::class,
                'Value "example.com" was expected to be a valid e-mail address.'
            ],
            [
                true,
                'name',
                \Exception::class,
                'Value "<TRUE>" expected to be string, type boolean given.'
            ],
            [
                null,
                'name',
                \Exception::class,
                'Value "<NULL>" expected to be string, type NULL given.'
            ],
            [
                'test@exampe.com',
                null,
                \Exception::class,
                'Value "<NULL>" expected to be string, type NULL given.'
            ],
            [
                'test@exampe.com',
                new \stdClass(),
                \Exception::class,
                'Value "stdClass" expected to be string, type object given.'
            ],
        ];
    }

    /**
     * @dataProvider create_data_provider
     * @test
     */
    public function use_create_fuction_test_validation($email, $name, $exception, $message)
    {
        $this->setExpectedException($exception, $message);
        EmailAddress::create($email, $name);
    }


    /**
     * @test
     */
    public function use_create_fuction_successful()
    {
        $faker = \Faker\Factory::create();

        $email = $faker->email;
        $name = $faker->name;

        $emailAddress = EmailAddress::create($email, $name);

        $this->assertEquals($email, $emailAddress->getEmailAddress());
        $this->assertEquals($name, $emailAddress->getName());
    }

    /**
     * @test
     */
    public function fromString_and_toString_with_name_and_email()
    {
        $faker = \Faker\Factory::create();

        $email = $faker->safeEmail;
        $name = $faker->name;

        $stringEmailAddress = "$name <$email>";

        $emailAddress = EmailAddress::fromString($stringEmailAddress);

        $this->assertEquals($email, $emailAddress->getEmailAddress());
        $this->assertEquals($name, $emailAddress->getName());

        $this->assertEquals($stringEmailAddress, $emailAddress->toString());
    }

    /**
     * @test
     */
    public function fromString_and_toString_with_only_email()
    {
        $faker = \Faker\Factory::create();

        $email = $faker->safeEmail;
        $name = '';

        $stringEmailAddress = "$email";

        $emailAddress = EmailAddress::fromString($stringEmailAddress);

        $this->assertEquals($email, $emailAddress->getEmailAddress());
        $this->assertEquals($name, $emailAddress->getName());

        $this->assertEquals($stringEmailAddress, $emailAddress->toString());
    }
}
