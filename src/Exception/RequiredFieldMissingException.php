<?php
/**
 * Created by PhpStorm.
 * User: GuyRadford
 * Date: 23/10/2016
 * Time: 19:57
 */

namespace GuyRadford\TransactionMail\Exception;

use Exception as BaseException;

class RequiredFieldMissingException extends \Exception
{

    /**
     * Constructor.
     *
     * @param string $fieldName
     * @param BaseException $previous
     */
    public function __construct($fieldName = '', BaseException $previous = null)
    {
        if ($fieldName) $message = "Required field '$fieldName' is missing.";
        else $message = "Required field is missing.";
        parent::__construct($message, 0, $previous);
    }
}