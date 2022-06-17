<?php

namespace frontend\controllers;

use frontend\models\forms\shop\RentForm;
use common\models\User;
use common\models\shop\Car;
use yii;


/**
 * Контроллер для аренды автомобиля
 * @author Spirkov Maksim
 */
class RentController extends SiteController
{

    public $layout = 'rent';

    /**
     * Главна страница аренды
     */
    public function actionMain()
    {
        if (!Yii::$app->user->isGuest) {
            $client = User::findOne(Yii::$app->user->id);
            $rentForm = new RentForm();

            if ($rentForm->load(Yii::$app->request->post())) {
                $result = $rentForm->addRent($client, $_GET['car_id'], $_POST['total_price']);
                Yii::$app->session->setFlash($result['code'], $result['response']);
                Yii::$app->session->setFlash($result['code'], $result['response']);
                return $this->redirect(['main?car_id=' . $_GET['car_id']]);
            }

            $car = Car::findOne($_GET['car_id']);
            $car->rental_price = $car->rental_price * 0.9;

            return $this->render('main', [
                'auth' => true,
                'car' => $car,
                'client' => $client,
                'rentForm' => $rentForm
            ]);
        } else {
            $rentForm = new RentForm();

            if ($rentForm->load(Yii::$app->request->post())) {
                $result = $rentForm->addRent(NULL, $_GET['car_id'], $_POST['total_price']);
                Yii::$app->session->setFlash($result['code'], $result['response']);

                return $this->redirect(['main?car_id=' . $_GET['car_id']]);
            }

            return $this->render('main', [
                'auth' => false,
                'car' => Car::findOne($_GET['car_id']),
                'rentForm' => $rentForm
            ]);
        }
    }
}
