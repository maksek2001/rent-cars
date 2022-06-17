<?php

namespace frontend\controllers;

use Yii;
use common\models\forms\ClientLoginForm;
use common\models\forms\RegistrationForm;

/**
 * Контроллер авторизации и регистрации
 * @author Spirkov Maksim
 */
class AuthenticationController extends SiteController
{

    public $layout = 'authentication';

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $loginForm = new ClientLoginForm();
        if ($loginForm->load(Yii::$app->request->post())) {
            
            if ($loginForm->login()) {
                return $this->redirect(['office/main']);
            } else {
                Yii::$app->session->setFlash('error', 'Не удалось авторизоваться!');
                return $this->redirect(['login']);
            }
        }

        $loginForm->password = '';
        return $this->render('login', [
            'loginForm' => $loginForm,
        ]);
    }

    public function actionRegistration()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $registrationForm = new RegistrationForm();
        if ($registrationForm->load(Yii::$app->request->post())) {

            if ($registrationForm->registration()) {
                Yii::$app->session->setFlash('success', 'Вы успешно зарегистрировались!');
                return $this->redirect('login');
            } else {
                Yii::$app->session->setFlash('error', 'Не удалось зарегистрироваться!');
            }
        }

        return $this->render('registration', [
            'registrationForm' => $registrationForm,
        ]);
    }
}
