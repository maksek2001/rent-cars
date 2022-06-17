<?php

namespace frontend\models\forms\edit_user_info;

use common\models\User;
use yii\base\Model;

/**
 * Форма контактной информации
 * @author Spirkov Maksim
 */
class ContactInfoForm extends Model
{

    /** @var string */
    public $email;

    /** @var string */
    public $phone;

    public function attributeLabels()
    {
        return [
            'email' => 'E-mail',
            'phone' => 'Номер телефона'
        ];
    }

    public function rules()
    {
        return [
            [['email'], 'required', 'message' => 'Обязательное поле!'],
            ['email', 'email', 'message' => 'Некорректный E-mail'],
            ['phone', 'match', 'pattern' => '/^((\+7|7|8)+([0-9]){10})$/i', 'message' => 'Введён недопустимый номер телефона'],
        ];
    }

    /**
     * Обновление контактной информации
     */
    public function updateInfo($client_id): bool
    {
        if (!$this->validate())
            return false;

        return User::updateContactInfo($client_id, $this->email, $this->phone);
    }
}
