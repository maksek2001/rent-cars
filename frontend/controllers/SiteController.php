<?php

namespace frontend\controllers;

use common\models\shop\Category;
use common\models\shop\Car;
use common\models\shop\CarObjective;
use common\models\shop\CategoryObjective;
use common\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use common\uses\core\menu\Menu;


/**
 * Основной контроллер
 * @author Spirkov Maksim
 */
class SiteController extends Controller
{
    /** @var Menu */
    public $menu;

    /** @var bool */
    public $vip;

    public $layout = 'main';

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
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
            'captcha' => [
                'class' => \yii\captcha\CaptchaAction::class,
                'fixedVerifyCode' => YII_ENV ? 'testme' : null,
            ],
        ];
    }


    public function beforeAction($action)
    {
        $this->menu = Menu::loadMenu();

        if (!Yii::$app->user->isGuest) {
            $client = User::findOne(Yii::$app->user->id);
            $this->vip = $client->vip;
        }

        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        $categories = Category::getHeadCategories(6);
        $categoryPrices = [];

        foreach ($categories as $category) {
            $objectiveIds = CategoryObjective::findObjectivesByCategoryId($category->id);

            $carsIds = CarObjective::findCarIdsByObjectiveIds($objectiveIds);
            $minPrice = Car::findMinRentalPriceByIds($carsIds);

            $categoryPrices[$category->id] = $minPrice;
        }

        return $this->render('index', [
            'categories' => Category::getAllCategories(),
            'categoryPrices' => $categoryPrices,
            'cars' => Car::getHeadCars(5)
        ]);
    }

    public function actionContacts()
    {
        return $this->render('contacts');
    }

    public function actionHelp()
    {
        return $this->render('help');
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
