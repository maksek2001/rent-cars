<?php

namespace common\models;

use Yii;

/**
 * Клиент
 *
 * @property int $id
 * @property string $username
 * @property string $password
 * @property string $email
 * @property string $phone
 * @property bool $vip
 * 
 * @author Spirkov Maksim
 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{

    const SCENARIO_LOGIN = 'login';
    const SCENARIO_REGISTER = 'registration';

    public function scenarios()
    {
        return [
            self::SCENARIO_LOGIN => ['username', 'password'],
            self::SCENARIO_REGISTER => ['username', 'email', 'password'],
        ];
    }

    public static function tableName()
    {
        return '{{clients}}';
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

    /**
     * @param string $email
     */
    public static function existEmail($email): bool
    {
        return static::find()->where(['email' => $email])->count() != 0;
    }

    /**
     * @param int $id
     * @param string $email
     * @param string $phone
     */
    public static function updateContactInfo($id, $email, $phone): bool
    {
        $client = static::findOne($id);
        $client->email = $email;
        $client->phone = $phone;

        return $client->save(false);
    }

    /**
     * @param string $email
     */
    public function createNewClientByEmail($email): array
    {
        $client = new User(['scenario' => static::SCENARIO_REGISTER]);

        if ($this->existEmail($email))
            return ['new' => false];

        $client->username = $email;
        $client->password = Yii::$app->getSecurity()->generatePasswordHash($email);
        $client->email = $email;

        $client->create();

        return ['new' => true, 'client' => $client];
    }

    public function create(): bool
    {
        return $this->save(false);
    }
}
