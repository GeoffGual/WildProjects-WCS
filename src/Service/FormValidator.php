<?php

namespace App\Service;

class FormValidator
{
    protected $fields;
    protected $errors = [];

    public function __construct($fields)
    {
        $this->fields = $fields;
    }

    /**
     * @return mixed
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * @param mixed $fields
     * @return FormValidator
     */
    public function setFields($fields)
    {
        $this->fields = $fields;
        return $this;
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * @param array $errors
     * @return FormValidator
     */
    public function setErrors(array $errors): FormValidator
    {
        $this->errors = $errors;
        return $this;
    }

    public function checkField()
    {
        foreach ($this->fields as $fieldType => $value) {
            if ($fieldType !== 'isFavorite' && empty($value)) {
                    $this->addErrors($fieldType, 'Ce champs doit être rempli');
            }
        }
    }

    public function addErrors($fieldType, $message)
    {
        $this->errors[$fieldType] = $message;
    }
}
