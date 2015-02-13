<?php

namespace App\Controllers;

use App\Components\Auth\Identity;
use T4\Core\Std;
use T4\Mvc\Controller;
use App\Models\User;

class Index
    extends Controller
{

    public function actionDefault()
    {
    }

    public function actionLogin($login = null)
    {
        if (null !== $login) {

            try {
                $identity = new Identity();
                $user = $identity->authenticate($login);
                $this->app->flash->message = 'Добро пожаловать, ' . $user->email . '!';
                $this->redirect('/');
            } catch (\T4\Auth\Exception $e) {
                $this->app->flash->error = $e->getMessage();
            }

            $this->data->email = $login->email;

        }
    }

    public function actionLogout()
    {
        $identity = new Identity();
        $identity->logout();
        $this->redirect('/');
    }

    public function actionRegister($register = null)
    {
        if (null !== $register) {
            $this->data->email = $register->email;
        }
    }

    public function actionCaptcha()
    {
        $this->app->extensions->captcha->generateImage();
        die();
    }

}
