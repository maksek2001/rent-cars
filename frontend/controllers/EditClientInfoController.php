<?php

namespace frontend\controllers;

use frontend\models\forms\edit_user_info\ContactInfoForm;
use frontend\models\forms\edit_user_info\ClientInfoForm;
use frontend\models\forms\edit_user_info\PassportForm;
use frontend\models\forms\edit_user_info\DrivingLicenseInfoForm;
use common\models\user_info\PassportInfo;
use common\models\user_info\ClientInformation;
use common\models\user_info\DrivingLicenseInfo;
use common\models\User;
use yii;

/**
 * Контроллер для изменения информации
 * @author Spirkov Maksim
 */
class EditClientInfoController extends SiteController
{

    public $layout = 'office';

    /**
     * Главная информация
     */
    public function actionMain()
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $clientInfo = ClientInformation::findOne(Yii::$app->user->id);

        $clientInfoForm = new ClientInfoForm();

        if ($clientInfo) {
            $clientInfoForm->fullname = $clientInfo->fullname;
            $clientInfoForm->sex = $clientInfo->sex;
            $clientInfoForm->birth_date = $clientInfo->birth_date;
        }

        if ($clientInfoForm->load(Yii::$app->request->post())) {

            if ($clientInfoForm->updateInfo(Yii::$app->user->id)) {
                return $this->redirect(['office/main']);
            } else {
                Yii::$app->session->setFlash('error', 'Введены неверные данные!');
            }
        }

        return $this->render('main', [
            'clientInfoForm' => $clientInfoForm
        ]);
    }

    /**
     * Контактная информация
     */
    public function actionContact()
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $clientInfo = User::findOne(Yii::$app->user->id);
        $contactInfoForm = new ContactInfoForm();
        $contactInfoForm->email = $clientInfo->email;
        $contactInfoForm->phone = $clientInfo->phone ? $clientInfo->phone : '';
        if ($contactInfoForm->load(Yii::$app->request->post())) {

            if ($contactInfoForm->updateInfo(Yii::$app->user->id)) {
                return $this->redirect(['office/main']);
            } else {
                Yii::$app->session->setFlash('error', 'Введены неверные данные!');
            }
        }

        return $this->render('contact', [
            'contactInfoForm' => $contactInfoForm,
        ]);
    }

    /**
     * Паспортные данные
     */
    public function actionPassport()
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $passportInfo = PassportInfo::findOne(Yii::$app->user->id);
        $passportInfoForm = new PassportForm();
        if ($passportInfo) {
            $passportInfoForm->serie = $passportInfo->serie;
            $passportInfoForm->number = $passportInfo->number;
            $passportInfoForm->issue_date = $passportInfo->issue_date;
            $passportInfoForm->issue_organization = $passportInfo->issue_organization;
            $passportInfoForm->organization_code = $passportInfo->organization_code;
        }
        if ($passportInfoForm->load(Yii::$app->request->post())) {

            if ($passportInfoForm->updateInfo(Yii::$app->user->id)) {
                return $this->redirect(['office/main']);
            } else {
                Yii::$app->session->setFlash('error', 'Введены неверные данные!');
            }
        }

        return $this->render('passport', [
            'passportInfoForm' => $passportInfoForm
        ]);
    }

    /**
     * Данные водительского удостоверения
     */
    public function actionLicense()
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $licenseInfo = DrivingLicenseInfo::findOne(Yii::$app->user->id);
        $licenseInfoForm = new DrivingLicenseInfoForm();
        if ($licenseInfo) {
            $licenseInfoForm->serie = $licenseInfo->serie;
            $licenseInfoForm->number = $licenseInfo->number;
            $licenseInfoForm->issue_date = $licenseInfo->issue_date;
            $licenseInfoForm->expiration_date = $licenseInfo->expiration_date;
        }
        if ($licenseInfoForm->load(Yii::$app->request->post())) {

            if ($licenseInfoForm->updateInfo(Yii::$app->user->id)) {
                return $this->redirect(['office/main']);
            } else {
                Yii::$app->session->setFlash('error', 'Введены неверные данные!');
            }
        }

        return $this->render('license', [
            'licenseInfoForm' => $licenseInfoForm
        ]);
    }
}
