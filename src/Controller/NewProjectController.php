<?php


namespace App\Controller;


class NewProjectController extends AbstractController
{
    public function add()
    {
        return $this->twig->render('Home/newProject.html.twig');
    }
}
