<?php


namespace App\Controller;


use App\Model\AdminManager;
use App\Model\ItemManager;

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
}
