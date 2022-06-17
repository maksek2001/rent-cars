<?php

namespace backend\controllers;

use Yii;
use DateTime;
use DateTimeZone;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Controller;
use common\models\forms\AdminLoginForm;
use common\models\shop\Rent;
use common\models\User;
use common\models\user_info\ClientInformation;
use common\models\user_info\PassportInfo;
use common\models\user_info\DrivingLicenseInfo;


/**
 * Основной контроллер для панели администратора
 * 
 * @author Spirkov Maksim
 */
class SiteController extends Controller
{
    public $layout = 'main';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => \yii\web\ErrorAction::class,
            ],
        ];
    }

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $loginForm = new AdminLoginForm();
        if ($loginForm->load(Yii::$app->request->post())) {

            if ($loginForm->login()) {
                $this->goBack();
            } else {
                Yii::$app->session->setFlash('error', 'Не удалось авторизоваться!');
                return $this->redirect('login');
            }
        }

        $loginForm->password = '';
        return $this->render('login', [
            'loginForm' => $loginForm,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $clientsContacts = [];
        $clientsInfo = [];
        $clientsPassports = [];
        $clientsLicenses = [];

        $allRents = Rent::getAllRents()->all();

        $now = new DateTime('now', new DateTimeZone('Europe/Samara'));
        foreach ($allRents as &$rent) {
            $clientId = $rent->client_id;

            $clientsContacts[$clientId] = User::findOne(['id' => $clientId]);
            $clientsInfo[$clientId] = ClientInformation::findOne(['client_id' => $clientId]);
            $clientsPassports[$clientId] = PassportInfo::findOne(['client_id' => $clientId]);
            $clientsLicenses[$clientId] = DrivingLicenseInfo::findOne(['client_id' => $clientId]);

            $end_date = new DateTime($rent->end_date, new DateTimeZone('Europe/Samara'));
            $availableDate = new DateTime($rent->end_date, new DateTimeZone('Europe/Samara'));
            $availableDate->modify("+1 day");

            if ($rent->status == 'active' && $end_date < $now) {
                if ($now < $availableDate) {
                    $rent->status = 'pending';
                } else {
                    $rent->status = 'overdue';
                }
            }
        }

        return $this->render('index', [
            'allRents' => $allRents,
            'clientsContacts' => $clientsContacts,
            'clientsInfo' => $clientsInfo,
            'clientsPassports' => $clientsPassports,
            'clientsLicenses' => $clientsLicenses,
        ]);
    }

    /**
     * Завершение аренды
     */
    public function actionCompleteRent()
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        Rent::updateStatus($_GET['rent_id'], "completed");
        return $this->redirect('index');
    }
}
