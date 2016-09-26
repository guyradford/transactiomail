<?php
/**
 * Created by PhpStorm.
 * User: GuyRadford
 * Date: 24/09/2016
 * Time: 19:52
 */

namespace GuyRadford\TransactioMail;

use Assert\Assertion;

final class EmailTemplatedMessage extends BaseEmailMessage
{

    /**
     * @var string
     */
    protected $template;

    /**
     * @var array
     */
    protected $mergeFields = [];


    /**
     * @param string $template
     * @return $this
     */
    public function setTemplate($template)
    {
        $this->template = $template;
        return $this;
    }

    /**
     * @param string $field
     * @param string $value
     * @return $this
     */
    public function addMergeField($field, $value)
    {
        Assertion::string($field);
        Assertion::string($value);

        $this->mergeFields[$field] = $value;
        return $this;
    }

    /**
     * @param array $mergeFields
     * @return $this
     */
    public function addMergeFields($mergeFields)
    {
        foreach ($mergeFields as $field => $value) {
            $this->addMergeField($field, $value);
        }
        return $this;
    }

    /**
     * @return string
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * @return array
     */
    public function getMergeFields()
    {
        return $this->mergeFields;
    }
}
