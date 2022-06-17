<?php

namespace frontend\models\forms\edit_user_info;

use common\models\user_info\DrivingLicenseInfo;
use yii\base\Model;

/**
 * Форма данных водительского удостоверения
 * @author Spirkov Maksim
 */
class DrivingLicenseInfoForm extends Model
{

    /** @var string */
    public $serie;

    /** @var string */
    public $number;

    public $issue_date;

    public $expiration_date;

    public function attributeLabels()
    {
        return [
            'serie' => 'Серия',
            'number' => 'Номер',
            'issue_date' => 'Дата выдачи',
            'expiration_date' => 'Дата окончания действия'
        ];
    }

    public function rules()
    {
        return [
            [['serie', 'number', 'issue_date', 'expiration_date'], 'required', 'message' => 'Обязательное поле!'],
            [['serie'], 'string', 'length' => 4, 'notEqual' => 'Серия должна состоять из 4 цифр'],
            [['serie', 'number'], 'double', 'message' => 'Введено не число'],
            [['number'], 'string', 'length' => 6, 'notEqual' => 'Номер должен состоять из 6 цифр'],
            [['serie', 'number'], 'match', 'pattern' => '/^[0-9]*$/i', 'message' => 'Введён недопустимый символ. Допустимые символы 0-9'],
        ];
    }

    /**
     * Обновление данных водительского удостоверения
     */
    public function updateInfo($client_id): bool
    {
        if (!$this->validate())
            return false;

        $licenseInfo = DrivingLicenseInfo::findOne($client_id);

        if (!$licenseInfo) {
            $licenseInfo = new DrivingLicenseInfo();
            $licenseInfo->client_id = $client_id;
        }

        $licenseInfo->serie = $this->serie;
        $licenseInfo->number = $this->number;
        $licenseInfo->issue_date = $this->issue_date;
        $licenseInfo->expiration_date = $this->expiration_date;

        return $licenseInfo->save(false);
    }
}
