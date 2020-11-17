<?php


namespace App\Service;


class ProjectValidator extends FormValidator
{
    public function checkFields()
    {
        foreach ($this->fields as $fieldType => $value) {
            if ($fieldType !== 'isFavorite' && empty($value)) {
                $this->addErrors($fieldType, 'Ce champ doit être rempli');
            }
        }
    }
    public function checkDescription()
    {
        $description = $this->fields['description'];
        if (strlen($description) < 10) {
            $this->errors['description'] = 'Le description doit contenir plus de 10 caractères.';
        }
    }

    public function checkPromo()
    {
        $regex = '/([0-1][0-9])\/([0-9]{4})/';
        $promo = $this->fields['promo'];
        if (preg_match($regex, $promo) === 0) {
            $this->errors['promo'] = 'Le format n\'est pas le bon, merci d\'entrer une date de type MM/AAAA';
        }
    }

    public function checkAll()
    {
        $this->checkFields();
        $this->checkDescription();
        $this->checkPromo();
    }
}
