<?php

namespace frontend\controllers;

use yii\data\Pagination;
use common\models\shop\Car;
use common\models\shop\CarObjective;
use common\models\shop\CategoryObjective;

/**
 * Контроллер для каталога
 * @author Spirkov Maksim
 */
class CatalogController extends SiteController
{
    private $_pageSize = 5;
    public $layout = 'catalog';

    /**
     * Главная страница категорий
     */
    public function actionMain()
    {
        $carIds = CarObjective::findCarIdsByObjectiveId($_GET['objective_id']);
        $cars = Car::findByIds($carIds);

        $pagination = new Pagination(['totalCount' => $cars->count(), 'pageSize' => $this->_pageSize]);

        $cars = $cars->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return $this->render('main', [
            'cars' => $cars,
            'pagination' => $pagination
        ]);
    }

    /**
     * Просмотр автомобиля
     */
    public function actionCar()
    {
        $car = Car::findOne($_GET['car_id']);

        return $this->render('car', [
            'car' => $car
        ]);
    }

    /**
     * Просмотр всех автомобилей категории
     */
    public function actionCategory()
    {
        $cars = [];

        $objectiveIds = CategoryObjective::findObjectivesByCategoryId($_GET['category_id']);

        $carIds = CarObjective::findCarIdsByObjectiveIds($objectiveIds);
        $cars = Car::findByIds($carIds);

        $pagination = new Pagination(['totalCount' => $cars->count(), 'pageSize' => $this->_pageSize]);

        $cars = $cars->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return $this->render('category', [
            'cars' => $cars,
            'pagination' => $pagination
        ]);
    }
}
