<?php


namespace App\Controller;


use App\Model\ProjectManager;
use App\Service\FormValidator;
use App\Service\ProjectValidator;
use App\Service\SearchExist;

class SearchController extends AbstractController
{
    public function show()
    {
        $errorMessages = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $words = $_POST['search'];
            if ($words === '') {
                $formValidator = new ProjectValidator($_POST);
                $formValidator->checkFields();
                $errorMessages = $formValidator->getErrors();
                $projectsFound = [];
            } else {
                $projectManager = new ProjectManager();
                $projectsFound = $projectManager->selectByWordKey($words);
            }
            return $this->twig->render('Home/search.html.twig', [
                'projectsFound' => $projectsFound,
                'word' => $words,
                'errors' => $errorMessages
            ]);
        }
    }
}
