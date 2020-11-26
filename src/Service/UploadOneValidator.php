<?php


namespace App\Service;


use App\Model\PictureManager;

class UploadOneValidator
{
    protected $errors = [];

    protected $files;

    public function __construct($files)
    {
        $this->files = $files;
    }

    public function uploadOne()
    {
        $typeNameData = $_FILES['image_main']['type'];
        $fileSize = $_FILES['image_main']['size'];
        if (empty($_FILES['image_main']['name'])) {
            $this->errors['empty'] = 'Merci de télécharger l\'image';
        } else {
            $allowed = ['image/jpeg', 'image/png', 'image/gif'];
            if (!in_array($typeNameData, $allowed)) {
                $this->errors['type'] = 'Seuls les fichiers, jpeg, png, gif sont acceptés';
            } elseif ($fileSize > 1000000) {
                $this->errors['size'] = 'fichier trop lourd';
            } else {
                $extension = pathinfo($_FILES['image_main']['name'], PATHINFO_EXTENSION);
                $filename = uniqid() . '.' . $extension;
                $directory = 'assets/images/';
                $uploadFile = $directory . $filename;
                move_uploaded_file($_FILES['image_main']['tmp_name'], $uploadFile);
                return $filename;
            }
        }
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
     * @return UploadOneValidator
     */
    public function setErrors(array $errors): UploadOneValidator
    {
        $this->errors = $errors;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFiles()
    {
        return $this->files;
    }

    /**
     * @param mixed $files
     * @return UploadOneValidator
     */
    public function setFiles($files)
    {
        $this->files = $files;
        return $this;
    }
}