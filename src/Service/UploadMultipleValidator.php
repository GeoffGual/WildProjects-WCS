<?php


namespace App\Service;


use App\Model\PictureManager;

class UploadMultipleValidator
{

    protected $files;

    protected $errors = [];


    public function __construct($files)
    {
        $this->files = $files;
    }

    public function uploadMultiple()
    {
        $typeNameData = $_FILES['images']['type'];
        $filesName = [];

        foreach ($typeNameData as $position => $typeName) {
            if (empty($_FILES['images']['name'][0])) {
                $this->errors['empty'] = 'Télécharger au moins une image';
            } else {
            $allowed = ['image/jpeg', 'image/png', 'image/gif'];
            if (!in_array($typeName, $allowed)) {
                $this->errors['type'] = 'seuls les fichiers, jpeg, png, gif sont acceptés';
            } else {
                $fileSize = $_FILES['images']['size'][$position];
                if ($fileSize > 2000000) {
                    $this->errors['size'] = 'fichier trop lourd';
                } else {
                    $extension = pathinfo($_FILES['images']['name'][$position], PATHINFO_EXTENSION);
                    $filename = uniqid() . '.' . $extension;
                    $directory = 'assets/images/';
                    $uploadFile = $directory . $filename;
                    move_uploaded_file($_FILES['images']['tmp_name'][$position], $uploadFile);
                    $filesName[] = $filename;
                    }
                }
            }
        }
        return $filesName;
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
     * @return UploadMultipleValidator
     */
    public function setFiles($files)
    {
        $this->files = $files;
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
     * @return UploadMultipleValidator
     */
    public function setErrors(array $errors): UploadMultipleValidator
    {
        $this->errors = $errors;
        return $this;
    }


}