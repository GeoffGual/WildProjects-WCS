<?php


namespace App\Controller;


use App\Model\ProjectManager;

class ProjectController extends AbstractController
{
    public function show($id)
    {
        $projectManager = new ProjectManager();
        $title = $projectManager->selectTitleProjectByIdProject($id);
        return $this->twig->render('Home/Project.html.twig', [
            'title' => $title,
        ]);
    }
}
