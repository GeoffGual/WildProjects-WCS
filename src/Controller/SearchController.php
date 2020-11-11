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
        $projectSearch = $projectManager->selectByWordKey($word);
        /*$projects1 = $projectManager->selectMainPictureProjectByType(self::PROJECT_TYPE_1);
        $projects2 = $projectManager->selectMainPictureProjectByType(self::PROJECT_TYPE_2);
        $projects3 = $projectManager->selectMainPictureProjectByType(self::PROJECT_TYPE_3);
        $projectsFavorite = $projectManager->selectMainPictureProjectFavorite();*/
        return $this->twig->render('Home/search.html.twig', [
            /*'projects1' => $projects1,
            'projects2' => $projects2,
            'projects3' => $projects3,
            'projectsFavorite' => $projectsFavorite,*/

        ]);
    }
}