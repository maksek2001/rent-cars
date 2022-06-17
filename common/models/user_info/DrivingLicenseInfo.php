<?php

namespace common\models\user_info;

/**
 * Данные водительского удостоверения
 * 
 * @property int $client_id
 * @property string $serie
 * @property string $number
 * @property Date $issue_date
 * @property Date $expiration_date
 * 
 * @author Spirkov Maksim
 */
class DrivingLicenseInfo extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{driving_licenses}}';
    }

    public function create(): bool
    {
        return $this->save(false);
    }
}
