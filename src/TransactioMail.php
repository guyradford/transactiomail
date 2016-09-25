<?php
/**
 * Created by PhpStorm.
 * User: GuyRadford
 * Date: 25/09/2016
 * Time: 21:18
 */

namespace GuyRadford\TransactioMail;


class TransactioMail implements TransactioMailInterface
{
    /**
     * @var AdapterInterface
     */
    private $adapter;


    /**
     * TransactioMail constructor.
     * @param AdapterInterface $adapter
     */
    public function __construct(AdapterInterface $adapter)
    {
        $this->adapter = $adapter;
    }


    /**
     * @param EmailTemplatedMessage $emailMessage
     * @return Result
     */
    public function sendTemplateEmail(EmailTemplatedMessage $emailMessage)
    {
        return $this->adapter->sendTemplateEmail($emailMessage);
    }
}