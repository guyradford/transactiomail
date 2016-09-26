<?php
/**
 * Created by PhpStorm.
 * User: GuyRadford
 * Date: 24/09/2016
 * Time: 19:44
 */

namespace GuyRadford\TransactioMail;


interface AdapterInterface
{

    /**
     * @param EmailTemplatedMessage $emailMessage
     * @return Result
     */
    public function sendTemplateEmail(EmailTemplatedMessage $emailMessage);
//    public function sendEmail(EmailTemplatedMessage $emailMessage);


    /**
     * @return Result
     */
    public function getLastResult();
}