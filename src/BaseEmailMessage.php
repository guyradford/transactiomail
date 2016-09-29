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
    protected $to = [];

    /**
     * @var EmailAddress[]
     */
    protected $cc = [];

    /**
     * @var EmailAddress[]
     */
    protected $bcc = [];

    /**
     * @var EmailAddress
     */
    protected $from;

    /**
     * @var EmailAddress
     */
    protected $replyTo;

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
    public function addTo($emailAddress, $name='')
    {
        Assertion::email($emailAddress);
        $this->to[$emailAddress] = EmailAddress::create($emailAddress, $name);
        return $this;
    }

    /**
     * Add a cc email address to the list.
     *
     * @param string $emailAddress
     * @param string $name
     * @return $this
     */
    public function addCc($emailAddress, $name='')
    {
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
    public function addBcc($emailAddress, $name='')
    {
        Assertion::email($emailAddress);
        $this->bcc[$emailAddress] = EmailAddress::create($emailAddress, $name);
        return $this;
    }

    /**
     * Add a header.
     *
     * @param string $header
     * @param string $value
     * @return $this
     */
    public function addHeader($header, $value)
    {
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
    public function setReplyTo($emailAddress, $name='')
    {
        Assertion::email($emailAddress);
        $this->replyTo = EmailAddress::create($emailAddress, $name);
        return $this;
    }

    /**
     * Set the from email address
     *
     * @param string $emailAddress
     * @param string $name
     * @return $this
     */

    public function setFrom($emailAddress, $name='')
    {
        Assertion::email($emailAddress);
        $this->from = EmailAddress::create($emailAddress, $name);
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
    public function getTos()
    {
        return $this->to;
    }

    /**
     * @return ValueObject\EmailAddress[]
     */
    public function getCcs()
    {
        return $this->ccEmailAddresses;
    }

    /**
     * @return ValueObject\EmailAddress[]
     */
    public function getBccs()
    {
        return $this->bcc;
    }

    /**
     * @return EmailAddress
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * @return EmailAddress
     */
    public function getReplyTo()
    {
        return $this->replyTo;
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
