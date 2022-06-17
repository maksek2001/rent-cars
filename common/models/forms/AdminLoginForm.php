<?php

namespace common\models\forms;

use common\models\Admin;
use Yii;
use yii\base\Model;

/**
 * Форма авторизации администратора
 * @author Spirkov Maksim
 */
class AdminLoginForm extends Model
{
    /** @var string */
    public $username;

    /** @var string */
    public $password;

    /** @var Admin $_admin*/
    private $_admin = null;

    /** @var bool */
    public $rememberMe = false;

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
        $this->getAdmin();

        if (!$this->_admin || !$this->_admin->validatePassword($this->password)) {
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

        return Yii::$app->user->login($this->_admin);
    }

    /**
     * Получение пользователя по его имени
     */
    public function getAdmin()
    {
        if ($this->_admin === null) {

            $this->_admin = Admin::findByUsername($this->username);

            if ($this->_admin) {
                $this->_admin->scenario = Admin::SCENARIO_LOGIN;
            }
        }
    }
}
