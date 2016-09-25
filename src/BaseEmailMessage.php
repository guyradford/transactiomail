<?php
/**
 * Created by PhpStorm.
 * User: GuyRadford
 * Date: 24/09/2016
 * Time: 19:52
 */

namespace GuyRadford\TransactioMail;


use Assert\Assertion;
use GuyRadford\TransactioMail\ValueObject\EmailAddress;

abstract class BaseEmailMessage
{

    /**
     * @var EmailAddress[]
     */
    protected $toEmailAddresses = [];

    /**
     * @var EmailAddress[]
     */
    protected $ccEmailAddresses = [];

    /**
     * @var EmailAddress[]
     */
    protected $bccEmailAddresses = [];

    /**
     * @var EmailAddress
     */
    protected $fromEmailAddress;

    /**
     * @var EmailAddress
     */
    protected $replyToEmailAddress;

    /**
     * @var array
     */
    protected $headers = [];
    
    /**
     * @var string
     */
    protected $subject;


    /**
     * Add a To email address to the list.
     *
     * @param string $emailAddress
     * @param string $name
     * @return $this
     */
    public function addToEmailAddress($emailAddress, $name=''){
        Assertion::email($emailAddress);
        $this->toEmailAddresses[$emailAddress] = EmailAddress::create($emailAddress, $name);
        return $this;
    }

    /**
     * Add a cc email address to the list.
     *
     * @param string $emailAddress
     * @param string $name
     * @return $this
     */
    public function addCcEmailAddress($emailAddress, $name=''){
        Assertion::email($emailAddress);
        $this->ccEmailAddresses[$emailAddress] = EmailAddress::create($emailAddress, $name);
        return $this;

    }

    /**
     * Add a bcc email address to the list.
     *
     * @param string $emailAddress
     * @param string $name
     * @return $this
     */
    public function addBccEmailAddress($emailAddress, $name=''){
        Assertion::email($emailAddress);
        $this->bccEmailAddresses[$emailAddress] = EmailAddress::create($emailAddress, $name);
        return $this;
    }

    /**
     * Add a header.
     *
     * @param string $header
     * @param string $value
     * @return $this
     */
    public function addHeader($header, $value){
        Assertion::string($header);
        Assertion::string($value);
        
        $this->headers[$header] = $value;
        return $this;
    }

    /**
     * Set the reply To email address
     *
     * @param string $emailAddress
     * @param string $name
     * @return $this
     */
    public function setReplyToEmailAddress($emailAddress, $name=''){
        Assertion::email($emailAddress);
        $this->replyToEmailAddress = EmailAddress::create($emailAddress, $name);
        return $this;

    }

    /**
     * Set the from email address
     *
     * @param string $emailAddress
     * @param string $name
     * @return $this
     */

    public function setFromEmailAddress($emailAddress, $name=''){
        Assertion::email($emailAddress);
        $this->replyToEmailAddress = EmailAddress::create($emailAddress, $name);
        return $this;
    }

    /**
     * @param string $subject
     * @return $this
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
        return $this;
    }
    
    /**
     * @return ValueObject\EmailAddress[]
     */
    public function getToEmailAddresses()
    {
        return $this->toEmailAddresses;
    }

    /**
     * @return ValueObject\EmailAddress[]
     */
    public function getCcEmailAddresses()
    {
        return $this->ccEmailAddresses;
    }

    /**
     * @return ValueObject\EmailAddress[]
     */
    public function getBccEmailAddresses()
    {
        return $this->bccEmailAddresses;
    }

    /**
     * @return EmailAddress
     */
    public function getFromEmailAddress()
    {
        return $this->fromEmailAddress;
    }

    /**
     * @return EmailAddress
     */
    public function getReplyToEmailAddress()
    {
        return $this->replyToEmailAddress;
    }
    
    /**
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }
    
    
    
}