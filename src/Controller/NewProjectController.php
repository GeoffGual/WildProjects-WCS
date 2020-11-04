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
        $languageManager = new LangagueManager();
        $languages = $languageManager->selectAll();
        $errorMessages = [];
        $project = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (empty($_POST['isFavorite'])) {
                $_POST['isFavorite'] = 0;
            } else {
                $_POST['isFavorite'] = 1;
            }
            $project = [
                'title' => $_POST['title'],
                'description' => $_POST['description'],
                'promo' => $_POST['promo'],
                'type_of_project' => intval($_POST['type-of-project']),
                'language_id' => intval($_POST['language']),
                'is_favorite' => $_POST['isFavorite']
            ];
            if (empty($_POST["title"])) {
                $errorMessages ['title'] = "Tu dois entrer un titre";
            }
            if (intval($_POST["type-of-project"]) === 0) {
                $errorMessages ['type-of-project'] = "Tu dois sélectionner un type de projet";
            }
            if (intval($_POST["language"]) === 0) {
                $errorMessages ['language'] = "Tu dois sélectionner un language";
            }
            if (empty($_POST["promo"])) {
                $errorMessages ['promo'] = "Tu dois rentrer une promo";
            }
            if (strlen($_POST["description"]) === 0) {
                $errorMessages ['description'] = "Tu dois entrer une descritpion";
            }
            if (empty($errorMessages)) {
                $projectManager = new ProjectManager();

                $id = $projectManager->insert($project);
                header('Location: /Project/show/' . $id);
            }
        }
        return $this->twig->render('Home/newProject.html.twig', [
            'errors' => $errorMessages,
            'languages' => $languages,
            'project' => $project
        ]);
    }
}
