<?php
/**
 * Created by PhpStorm.
 * User: GuyRadford
 * Date: 24/09/2016
 * Time: 19:52
 */

namespace GuyRadford\TransactioMail;


use Assert\Assertion;

class EmailTemplatedMessage
{

    protected $toEmailAddresses = [];
    protected $ccEmailAddresses = [];
    protected $bccEmailAddresses = [];

    protected $fromEmailAddress;
    protected $replyToEmailAddress;

    protected $template;
    protected $mergeFields = [];

    protected $subject;


    /**
     * Add a To email address to the list.
     * 
     * @param string $emailAddress
     * @param string $name
     */
    public function addToEmailAddress($emailAddress, $name=''){
        Assertion::email($emailAddress);
        $this->toEmailAddresses[$emailAddress] = $name;
    }

    /**
     * Add a cc email address to the list.
     * 
     * @param string $emailAddress
     * @param string $name
     */
    public function addCcEmailAddress($emailAddress, $name=''){
        Assertion::email($emailAddress);
        $this->ccEmailAddresses[$emailAddress] = $name;
    }
    
    /**
     * Add a bcc email address to the list.
     * 
     * @param string $emailAddress
     * @param string $name
     */
    public function addBccEmailAddress($emailAddress, $name=''){
        Assertion::email($emailAddress);
        $this->bccEmailAddresses[$emailAddress] = $name;
    }
    
    public function setReplyToEmailAddress($emailAddress, $name=''){
        Assertion::email($emailAddress);
        $this->replyToEmailAddress[$emailAddress] = $name;
        
    }
    
}