<?php


namespace App\Controller;


use App\Model\PictureManager;
use App\Model\ProjectManager;

class ProjectController extends AbstractController
{
    public function show($id)
    {
        $projectManager = new ProjectManager();
        $pictureManager = new PictureManager();
        $project = $projectManager->selectInfoProjectByIdProject($id);
        $pictures = $pictureManager->selectNamePictureById($id);
        return $this->twig->render('Home/Project.html.twig', [
            'project' => $project,
            'pictures' => $pictures
        ]);
    }
}
