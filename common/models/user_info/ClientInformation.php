<?php

namespace common\models\user_info;

/**
 * Основная информация клиента
 * 
 * @property int $client_id
 * @property string $fullname
 * @property string $sex ('male', 'female')
 * @property Date $birth_date
 * 
 * @author Spirkov Maksim
 */
class ClientInformation extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{clients_info}}';
    }

    public function create(): bool
    {
        return $this->save(false);
    }
}
