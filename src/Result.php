<?php
/**
 * Created by PhpStorm.
 * User: GuyRadford
 * Date: 25/09/2016
 * Time: 20:59
 */

namespace GuyRadford\TransactioMail;

use Assert\Assertion;

class Result
{

    /**
     * @var boolean
     */
    protected $success;

    /**
     * @var string
     */
    protected $messageId;

    /**
     * @var string
     */
    protected $message;

    /**
     * Response constructor.
     * @param boolean $success
     * @param string $messageId
     * @param string $message
     */
    public function __construct($success, $messageId, $message)
    {
        $this->success = $success;
        $this->messageId = $messageId;
        $this->message = $message;
    }


    /**
     * @param boolean $success
     * @param string $messageId
     * @param string $message
     * @return Result
     */
    public static function create($success, $messageId, $message)
    {
        Assertion::boolean($success);
        Assertion::string($messageId);
        Assertion::string($message);

        return new self($success, $messageId, $message);
    }

    /**
     * @return boolean
     */
    public function getSuccess()
    {
        return $this->success;
    }

    /**
     * @return string
     */
    public function getMessageId()
    {
        return $this->messageId;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }
}
