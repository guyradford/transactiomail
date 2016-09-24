<?php
/**
 * Created by PhpStorm.
 * User: GuyRadford
 * Date: 24/09/2016
 * Time: 20:08
 */

namespace GuyRadford\TransactioMail\ValueObject;


use Assert\Assertion;

class EmailAddress
{

    /**
     * @var string
     */
    protected $emailAddress;

    /**
     * @var string
     */
    protected $name;

    /**
     * EmailAddress constructor.
     * @param string $emailAddress
     * @param string $name
     */
    public function __construct($emailAddress, $name)
    {

        $this->emailAddress = $emailAddress;
        $this->name = $name;
    }

    /**
     * @param string $emailAddress
     * @param string $name
     * @return EmailAddress
     */
    static public function create($emailAddress, $name){
        Assertion::email($emailAddress);
        Assertion::string($name);

        return new self($emailAddress, $name);

    }

    /**
     * @param string $email
     * @return EmailAddress
     */
    static public function fromString($email){
        $emailParts = explode('<', $email);

        if (isset($emailParts[1])){
            $name = trim($emailParts[0]);
            $emailAddress = trim(str_replace('>','',$emailParts[1]));
        }else{
            $name = '';
            $emailAddress = trim($emailParts[0]);
        }
        return self::create($emailAddress, $name);
    }

    /**
     * @return string
     */
    public function toString(){
        if (strlen($this->name)>0)
            return "{$this->name} <{$this->emailAddress}>";
        
        return $this->emailAddress;
    }

    /**
     * @return string
     */
    public function getEmailAddress(){
        return $this->emailAddress;
    }

    /**
     * @return string
     */
    public function getName(){
        return $this->name;
    }


}