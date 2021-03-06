<?php
/**
 * Created by PhpStorm.
 * User: GuyRadford
 * Date: 25/09/2016
 * Time: 21:22
 */

namespace GuyRadford\TransactionMail;

interface TransactionMailInterface
{
    /**
     * @param EmailTemplatedMessage $emailMessage
     * @return Result
     */
    public function sendTemplateEmail(EmailTemplatedMessage $emailMessage);
//    public function sendEmail(EmailTemplatedMessage $emailMessage);
}
