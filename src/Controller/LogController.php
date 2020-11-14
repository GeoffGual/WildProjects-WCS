<?php


namespace App\Controller;


use App\Model\LogManager;
use App\Service\FormValidator;

class LogController extends AbstractController
{
    public function login()
    {
        if (isset($_SESSION['login'])) {
            header('location: /');
        }
        $errorsMessages = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $logManager = new LogManager();
            $login = $_POST['login'];
            $logManager = $logManager->checkmdp($login);
            $postPassword = ['password' => $_POST['password']] ;
            $formValidator = new FormValidator($_POST);

            if ($logManager === $postPassword) {
                $_SESSION['login'] = $login;
                header('location: /');
            } else {
                $formValidator->addErrors('password', 'Nom d\'utilisateur ou mot de passe incorrect ');
            }

            $formValidator->checkFields();
            $errorsMessages = $formValidator->getErrors();
        }
        return $this->twig->render('Admin/login.html.twig', [
            'errors' => $errorsMessages,
        ]);
    }

    public function logout()
    {
        session_destroy();
        header("location: /");
    }
}
