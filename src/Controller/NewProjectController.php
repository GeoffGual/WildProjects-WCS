<?php


namespace App\Controller;


class NewProjectController extends AbstractController
{
    public function newProject()
    {
        return $this->twig->render('Home/newProject.html.twig');
    }
}
