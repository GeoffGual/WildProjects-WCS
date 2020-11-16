<?php


namespace App\Controller;


use App\Model\ProjectManager;
use App\Service\SearchExist;

class SearchController extends AbstractController
{
    public function show()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($_POST['search'] == '') {
                header('Location: /');
            } else {
                $words = $_POST['search'];
                preg_match("/([^A-Za-z0-9\s])/", $words, $result);
                if (empty($result)) {
                    /*$words = explode(" ", $words);*/
                    $projectManager = new ProjectManager();
                    $projectsFound = $projectManager->selectByWordKey($words);
                    return $this->twig->render('Home/search.html.twig', [
                        'projectsFound' => $projectsFound,
                        'word' => $words,
                    ]);
                } else {
                    header('Location: /');
                }
            }
        }
    }
}
