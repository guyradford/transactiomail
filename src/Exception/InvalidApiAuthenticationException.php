<?php
/**
 * Created by PhpStorm.
 * User: GuyRadford
 * Date: 23/10/2016
 * Time: 19:57
 */

namespace GuyRadford\TransactionMail\Exception;

use Exception as BaseException;

class InvalidApiAuthenticationException extends \Exception
{

    /**
     * Constructor.
     *
     * @param BaseException $previous
     */
    public function __construct(BaseException $previous = null)
    {
        parent::__construct('Invalid Api Authentication.', 0, $previous);
    }
}