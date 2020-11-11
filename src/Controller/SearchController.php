<?php


namespace App\Controller;


use App\Model\ProjectManager;
use App\Service\SearchExist;

class SearchController extends AbstractController
{
    public function show()
    {
        $search = new SearchExist();
        $search->verify();
        $word = $search->verify();
        $projectManager = new ProjectManager();
        $projectsFound = $projectManager->selectByWordKey($word);
        return $this->twig->render('Home/search.html.twig', [
            'projectsFound' => $projectsFound,
            'word' => $word,
        ]);
    }
}
