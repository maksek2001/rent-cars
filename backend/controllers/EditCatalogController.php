<?php

namespace backend\controllers;

use Yii;
use common\models\shop\Car;
use common\models\shop\Objective;
use backend\models\forms\AddCarForm;
use backend\models\forms\DeleteCarForm;
use common\uses\libs\storage\classes\StorageFile;
use common\uses\libs\storage\Storage;
use common\uses\libs\config\GetConfig;
use yii\web\UploadedFile;

/**
 * Основной контроллер для панели администратора
 * 
 * @author Spirkov Maksim
 */
class EditCatalogController extends SiteController
{
    private $_admissibleExtensions = ['jpg', 'jpeg', 'png', 'jfif', 'webp'];

    public function actionMain()
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        return $this->render('main');
    }

    public function actionAddCar()
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $objectives = Objective::getAllObjectives();

        $objectiveOptions = [];

        foreach ($objectives as $objective) {
            $objectiveOptions["$objective->id"] = $objective->name;
        }

        $addCarForm = new AddCarForm();
        if (Yii::$app->request->post()) {

            $carsImagesDir = GetConfig::get('storages');
            $storage = new Storage($carsImagesDir['cars_images']['directory']);

            $image = UploadedFile::getInstance($addCarForm, 'image');

            $imageName = "";
            if (in_array($image->extension, $this->_admissibleExtensions)) {
                $imageName = date('YmdHis') . '.' . $image->extension;
            }

            if ($addCarForm->load(Yii::$app->request->post())) {
                if ($imageName != "") {
                    if ($addCarForm->addCar($imageName)) {

                        $storageFile = new StorageFile($imageName, file_get_contents($image->tempName));

                        if ($storage->uploadFile($storageFile)) {
                            Yii::$app->session->setFlash('success', 'Автомобиль успешно добавлен!');
                            return $this->redirect('add-car');
                        } else {
                            Yii::$app->session->setFlash('error', 'Не удалось загрузить изображение!');
                        }
                    } else {
                        Yii::$app->session->setFlash('error', 'Не удалось добавить автомобиль!');
                    }
                } else {
                    Yii::$app->session->setFlash('error', 'Вы пытались загрузить недопустимый файл');
                }
            }
        }

        return $this->render('add-car', [
            'addCarForm' => $addCarForm,
            'objectives' => $objectiveOptions,
            'typesTransmission' => Car::TYPES_TRANSMISSION
        ]);
    }

    public function actionDeleteCar()
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $deleteCarForm = new DeleteCarForm();

        if ($deleteCarForm->load(Yii::$app->request->post())) {

            $image = $deleteCarForm->deleteCar();

            if ($image != null) {
                $carsImagesDir = GetConfig::get('storages');
                $storage = new Storage($carsImagesDir['cars_images']['directory']);

                if ($storage->deleteFile($image)) {
                    Yii::$app->session->setFlash('success', 'Автомобиль успешно удалён');
                } else {
                    Yii::$app->session->setFlash('error', 'Не удалось найти изображение данного автомобиля.');
                }
            } else {
                Yii::$app->session->setFlash('error', 'Не удалось найти автомобиль с данным ID.');
            }
            return $this->redirect('delete-car');
        }

        return $this->render('delete-car', [
            'deleteCarForm' => $deleteCarForm
        ]);
    }
}
