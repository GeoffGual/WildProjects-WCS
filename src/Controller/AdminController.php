<?php


namespace App\Controller;


use App\Model\AdminManager;
use App\Model\ItemManager;
use App\Model\LangagueManager;
use App\Model\ProjectManager;

class AdminController extends AbstractController
{
    public function index()
    {
        $adminManager = new AdminManager();
        $titles = $adminManager->selectAllProject();
        return $this->twig->render('Admin/index.html.twig', [
            'projects' => $titles,
        ]);
    }

    /**
     * Display item informations specified by $id
     *
     * @param int $id
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function show(int $id)
    {
        $adminManager = new AdminManager();
        $project = $adminManager->selectOneById($id);
        $language = $adminManager->selectLanguageNameById($id);
        $picture = $adminManager->selectMainPictureProject($id);

        return $this->twig->render('Admin/show.html.twig', [
            'project' => $project,
            'language' => $language,
            'picture' => $picture,
        ]);
    }
    /**
     * @param int $id
     */
    public function delete(int $id)
    {
        $adminManager = new AdminManager();
        $adminManager->delete($id);
        header('Location:/admin/index');
    }

    public function edit(int $id)
    {
        $languageManager = new LangagueManager();
        $languages = $languageManager->selectAll();
        $projectManager = new ProjectManager();
        $project = $projectManager->selectOneById($id);
        $errorMessages = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $project = [
                'id' => intval($project['id']),
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
                $projectManager->update($project);
                header('Location: /Project/show/' . $id);
            }
        }
        return $this->twig->render('Home/newProject.html.twig', [
            'errors' => $errorMessages,
            'languages' => $languages,
            'project' => $project
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
        return $this->twig->render('Admin/add.html.twig', [
            'errors' => $errorMessages,
            'languages' => $languages,
            'project' => $project
        ]);
    }
}
