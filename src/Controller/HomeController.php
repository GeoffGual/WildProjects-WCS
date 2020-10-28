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
        $projects = $projectManager->selectAll();
        $pictureManager = new PictureManager();
        $pictures = $pictureManager->selectAll();
        return $this->twig->render('Home/index.html.twig', [
            'projects' => $projects,
            'pictures' => $pictures,
        ]);
    }
}
