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
            if ($_POST['search'] == '') {
                $formValidator = new ProjectValidator($_POST);
                $formValidator->checkField();
                $errorMessages = $formValidator->getErrors();
                return $this->twig->render('Component/_navbar.html.twig', [
                    'errors' => $errorMessages
                ]);
            } else {
                $words = $_POST['search'];
                preg_match("/([^A-Za-z0-9\s])/", $words, $result);
                if (empty($result)) {
                    $projectManager = new ProjectManager();
                    $projectsFound = $projectManager->selectByWordKey($words);
                    return $this->twig->render('Home/search.html.twig', [
                        'projectsFound' => $projectsFound,
                        'word' => $words,
                        'errors' => $errorMessages
                    ]);
                } else {
                    $formValidator = new FormValidator($_POST);
                    $formValidator->addErrors('symbole', 'Pas de symbole dans la recherche');
                    $errorMessages = $formValidator->getErrors();
                    return $this->twig->render('Component/_navbar.html.twig', [
                        'errors' => $errorMessages
                    ]);
                }
            }
        }
    }
}
