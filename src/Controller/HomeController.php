<?php
/**
 * Created by PhpStorm.
 * User: aurelwcs
 * Date: 08/04/19
 * Time: 18:40
 */

namespace App\Controller;

use App\Model\PictureManager;
use App\Model\ProjectManager;
use App\Service\SearchExist;

class HomeController extends AbstractController
{
    const PROJECT_TYPE_1 = '1';
    const PROJECT_TYPE_2 = '2';
    const PROJECT_TYPE_3 = '3';

    /**
     * Display home page
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function index()
    {
        $verify = new SearchExist();
        $verify->verify();
        $projectManager = new ProjectManager();
        $projects1 = $projectManager->selectMainPictureProjectByType(self::PROJECT_TYPE_1);
        $projects2 = $projectManager->selectMainPictureProjectByType(self::PROJECT_TYPE_2);
        $projects3 = $projectManager->selectMainPictureProjectByType(self::PROJECT_TYPE_3);
        $projectsFavorite = $projectManager->selectMainPictureProjectFavorite();
        return $this->twig->render('Home/index.html.twig', [
            'projects1' => $projects1,
            'projects2' => $projects2,
            'projects3' => $projects3,
            'projectsFavorite' => $projectsFavorite,

        ]);
    }
}
