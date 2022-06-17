<?php

namespace common\models;

use Yii;

/**
 * Администратор
 *
 * @property int $id
 * @property string $username
 * @property string $password
 * @property string $email
 * 
 * @author Spirkov Maksim
 */
class Admin extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    const SCENARIO_LOGIN = 'login';

    public function scenarios()
    {
        return [
            self::SCENARIO_LOGIN => ['username', 'password'],
        ];
    }


    public static function tableName()
    {
        return '{{admins}}';
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }


    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
    }


    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
    }

    public static function findByUsername($username)
    {
        return static::find()->where(['username' => $username])->one();
    }

    /**
     * @param string $password
     */
    public function validatePassword($password): bool
    {
        return Yii::$app->getSecurity()->validatePassword($password, $this->password);
    }

    /**
     * @param string $username
     */
    public static function existUsername($username): bool
    {
        return static::find()->where(['username' => $username])->count() != 0;
    }

    public function create(): bool
    {
        return $this->save(false);
    }
}

