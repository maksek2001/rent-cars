<?php

namespace frontend\controllers;

use DateTime;
use DateTimeZone;
use common\models\user_info\PassportInfo;
use common\models\User;
use common\models\user_info\DrivingLicenseInfo;
use common\models\shop\Rent;
use common\models\user_info\ClientInformation;
use yii\data\Pagination;
use yii;


/**
 * Контроллер для личного кабинета
 * @author Spirkov Maksim
 */
class OfficeController extends SiteController
{

    private $_pageSize = 6;

    public $layout = 'office';

    /**
     * Личный кабинет
     */
    public function actionMain()
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $rents = Rent::getAllRentsByClientId(Yii::$app->user->id);

        $pagination = new Pagination(['totalCount' => $rents->count(), 'pageSize' => $this->_pageSize]);

        $rents = $rents->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        $now = new DateTime('now', new DateTimeZone('Europe/Samara'));

        foreach ($rents as &$rent) {

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

        return $this->render('main', [
            'client' => User::findOne(Yii::$app->user->id),
            'clientInfo' => ClientInformation::findOne(Yii::$app->user->id),
            'passportInfo' => PassportInfo::findOne(Yii::$app->user->id),
            'licenseInfo' => DrivingLicenseInfo::findOne(Yii::$app->user->id),
            'rents' => $rents,
            'pagination' => $pagination
        ]);
    }

    /**
     * Отмена аренды
     */
    public function actionCancelRent()
    {
        Rent::updateStatus($_GET['rent_id'], "canceled_by_yourself");
        return $this->redirect('main');
    }
}
