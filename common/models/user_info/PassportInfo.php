<?php

namespace common\models\user_info;

/**
 * Паспортные данные пользователя
 * 
 * @property int $client_id
 * @property string $serie
 * @property string $number
 * @property Date $issue_date
 * @property string $issue_organization
 * @property string $issue_code
 * 
 * @author Spirkov Maksim
 */
class PassportInfo extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{passports_info}}';
    }

    public function create(): bool
    {
        return $this->save(false);
    }
}
