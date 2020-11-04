<?php


namespace App\Controller;


use App\Model\LangagueManager;
use App\Model\ProjectManager;

class NewProjectController extends AbstractController
{
    public function form()
    {
        $languageManager = new LangagueManager();
        $languages = $languageManager->selectAll();
        return $this->twig->render('Home/newProject.html.twig', [
            'languages' => $languages
        ]);
    }

    public function add()
    {
        var_dump($_POST);
        die;
    }
}

