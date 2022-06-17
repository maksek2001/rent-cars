<?php

namespace frontend\models\forms\edit_user_info;

use common\models\user_info\PassportInfo;
use yii\base\Model;

/**
 * Форма паспортных данных
 * @author Spirkov Maksim
 */
class PassportForm extends Model
{

    /** @var string */
    public $serie;

    /** @var string */
    public $number;

    public $issue_date;

    /** @var string */
    public $issue_organization;

    /** @var string */
    public $organization_code;

    public function attributeLabels()
    {
        return [
            'serie' => 'Серия',
            'number' => 'Номер',
            'issue_date' => 'Дата выдачи',
            'issue_organization' => 'Кем выдан',
            'organization_code' => 'Код подразделения'
        ];
    }

    public function rules()
    {
        return [
            [['serie', 'number', 'issue_date', 'issue_organization', 'organization_code'], 'required', 'message' => 'Обязательное поле!'],
            [['serie'], 'string', 'length' => 4, 'notEqual' => 'Серия должна состоять из 4 цифр'],
            [['number'], 'string', 'length' => 6, 'notEqual' => 'Номер должен состоять из 6 цифр'],
            [['serie', 'number'], 'double', 'message' => 'Введено не число'],
            [['organization_code'], 'string', 'length' => 7, 'notEqual' => 'Код подразделения должен состоять из 6 цифр и тире'],
            [['serie', 'number'], 'match', 'pattern' => '/^[0-9]*$/i', 'message' => 'Введён недопустимый символ. Допустимые символы 0-9'],
            [['organization_code'], 'match', 'pattern' => '/^[0-9]{3}-[0-9]{3}$/i', 'message' => 'Введён некорректный код подразделения'],
        ];
    }

    /**
     * Обновление паспортных данных
     */
    public function updateInfo($client_id): bool
    {
        if (!$this->validate())
            return false;

        $passportInfo = PassportInfo::findOne($client_id);

        if (!$passportInfo) {
            $passportInfo = new PassportInfo();
            $passportInfo->client_id = $client_id;
        }

        $passportInfo->serie = $this->serie;
        $passportInfo->number = $this->number;
        $passportInfo->issue_date = $this->issue_date;
        $passportInfo->issue_organization = $this->issue_organization;
        $passportInfo->organization_code = $this->organization_code;

        return $passportInfo->save(false);
    }
}
