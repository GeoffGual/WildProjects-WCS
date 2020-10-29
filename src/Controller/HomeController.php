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

class HomeController extends AbstractController
{

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
        $projectManager = new ProjectManager();
        $projects1 = $projectManager->selectMainPictureProject1();
        $projects2 = $projectManager->selectMainPictureProject2();
        $projects3 = $projectManager->selectMainPictureProject3();
        $projectsFavorite = $projectManager->selectMainPictureProjectFavorite();
        return $this->twig->render('Home/index.html.twig', [
            'projects1' => $projects1,
            'projects2' => $projects2,
            'projects3' => $projects3,
            'projectsFavorite' => $projectsFavorite,
        ]);
    }
}
