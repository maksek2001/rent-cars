<?php

namespace common\models\forms;

use Yii;
use yii\base\Model;
use common\models\User;

/**
 * Форма авторизации пользователя
 * @author Spirkov Maksim
 */
class ClientLoginForm extends Model
{
    /** @var string */
    public $username;

    /** @var string */
    public $password;

    /** @var bool */
    public $rememberMe = true;

    /** @var User $_client*/
    private $_client = null;

    public function attributeLabels()
    {
        return [
            'username' => 'Логин',
            'password' => 'Пароль'
        ];
    }

    public function rules()
    {
        return [
            [['username', 'password'], 'required', 'message' => 'Обязательное поле!'],
            ['rememberMe', 'boolean'],
            ['password', 'validatePassword'],
        ];
    }

    public function validatePassword($attribute)
    {
        $this->getClient();

        if (!$this->_client || !$this->_client->validatePassword($this->password)) {
            $this->addError($attribute, 'Неверный логин или пароль');
        }
    }

    /**
     * Авторизация
     */
    public function login(): bool
    {
        if (!$this->validate())
            return false;

        return Yii::$app->user->login($this->_client,  $this->rememberMe ? 3600 * 24 * 30 : 0);
    }

    /**
     * Получение пользователя по его имени
     */
    public function getClient()
    {
        if ($this->_client === null) {

            $this->_client = User::findByUsername($this->username);

            if ($this->_client) {
                $this->_client->scenario = User::SCENARIO_LOGIN;
            }
        }
    }
}
