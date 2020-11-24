<?php


namespace App\Controller;


use App\Model\AdminManager;
use App\Model\LangagueManager;
use App\Model\PictureManager;
use App\Model\ProjectManager;
use App\Service\FormValidator;
use App\Service\LogAccess;
use App\Service\ProjectValidator;
use App\Service\UploadMultipleValidator;
use App\Service\UploadOneValidator;


class AdminController extends AbstractController
{
    const PROJECT_TYPE_1 = '1';
    const PROJECT_TYPE_2 = '2';
    const PROJECT_TYPE_3 = '3';

    public function index()
    {
        $adminManager = new AdminManager();
        $projects1 = $adminManager->selectAllProjectByProjectType(self::PROJECT_TYPE_1);
        $projects2 = $adminManager->selectAllProjectByProjectType(self::PROJECT_TYPE_2);
        $projects3 = $adminManager->selectAllProjectByProjectType(self::PROJECT_TYPE_3);
        return $this->twig->render('Admin/index.html.twig', [
            'projects1' => $projects1,
            'projects2' => $projects2,
            'projects3' => $projects3,
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
        $projectManager = new ProjectManager();
        $pictureManager = new PictureManager();
        $project = $projectManager->selectInfoProjectByIdProject($id);
        $pictures = $pictureManager->selectNamePictureById($id);
        return $this->twig->render('Home/Project.html.twig', [
            'project' => $project,
            'pictures' => $pictures
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
        $errorsUploadMain = [];
        $errorsUploadMultiple = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (empty($_POST['isFavorite'])) {
                $_POST['isFavorite'] = 0;
            } else {
                $_POST['isFavorite'] = 1;
            }
            $project = [
                'id' => intval($project['id']),
                'title' => $_POST['title'],
                'description' => $_POST['description'],
                'promo' => $_POST['promo'],
                'type_of_project' => intval($_POST['type_of_project']),
                'language_id' => intval($_POST['language']),
                'is_favorite' => $_POST['isFavorite']
            ];
            $uploadOneValidator = new UploadOneValidator($_FILES);
            $filename = $uploadOneValidator->uploadOne();
            $errorsUploadMain = $uploadOneValidator->getErrors();
            $mainPicture = [
                'name' => $filename,
                'is_main' => 1,
            ];
            $uploadMultipleValidator = new UploadMultipleValidator($_FILES);
            $filenames = $uploadMultipleValidator->uploadMultiple();
            $errorsUploadMultiple = $uploadMultipleValidator->getErrors();
            $pictures = [];
            foreach ($filenames as $filename) {
                $pictures[] = [
                    'name' => $filename,
                    'is_main' => 0,
                ];
            }
            $formValidator = new ProjectValidator($_POST);
            $formValidator->checkAll();
            $errorMessages = $formValidator->getErrors();

            if (empty($errorMessages)) {
                $projectManager = new ProjectManager();
                $projectManager->update($project);
                header('Location: /Project/show/' . $id);
            }
        }
        return $this->twig->render('Admin/edit.html.twig', [
            'errors' => $errorMessages,
            'languages' => $languages,
            'project' => $project,
        ]);
    }

    public function add()
    {
        $languageManager = new LangagueManager();
        $languages = $languageManager->selectAll();
        $errorMessages = [];
        $project = [];
        $errorsUploadMain = [];
        $errorsUploadMultiple = [];
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
                'type_of_project' => intval($_POST['type_of_project']),
                'language_id' => intval($_POST['language']),
                'is_favorite' => $_POST['isFavorite']
            ];

            $uploadOneValidator = new UploadOneValidator($_FILES);
            $filename = $uploadOneValidator->uploadOne();
            $errorsUploadMain = $uploadOneValidator->getErrors();
            $mainPicture = [
                'name' => $filename,
                'is_main' => 1,
            ];
            $uploadMultipleValidator = new UploadMultipleValidator($_FILES);
            $filenames = $uploadMultipleValidator->uploadMultiple();
            $errorsUploadMultiple = $uploadMultipleValidator->getErrors();
            $pictures = [];
            foreach ($filenames as $filename) {
                $pictures[] = [
                    'name' => $filename,
                    'is_main' => 0,
                ];
            }

            $formValidator = new ProjectValidator($_POST);
            $formValidator->checkAll();
            $errorMessages = $formValidator->getErrors();

            if (empty($errorMessages) && empty($errorsUploadMain) && empty($errorsUploadMultiple)) {
                $projectManager = new ProjectManager();
                $pictureManager = new PictureManager();
                $id = $projectManager->insert($project);
                $pictureManager->insert($mainPicture, $id);
                foreach ($pictures as $picture) {
                    $pictureManager->insert($picture, $id);
                }
                header('Location: /Project/show/' . $id);
            }
        }
        return $this->twig->render('Admin/add.html.twig', [
            'errors' => $errorMessages,
            'languages' => $languages,
            'project' => $project,
            'errorsUploadMain' => $errorsUploadMain,
            'errorsUploadMultiple' => $errorsUploadMultiple,
        ]);
    }

    public function favorite()
    {
        $json = file_get_contents('php://input');
        $jsonData = json_decode($json, true);
        $projectId = $jsonData['project'];
        $projectFavorite = $jsonData['favorite'];
        $projectManager = new ProjectManager();
        $projectManager->updateFavoriteByProjectId($jsonData);
        $response = [
            'status' => 'success',
            'project' => $projectId,
            'favorite_state' => $projectFavorite
        ];

        return json_encode($response);
    }
}
