<?php

namespace common\models\shop;

/**
 * Аренда
 * 
 * @property int $id
 * @property int $car_id
 * @property int $client_id
 * @property DateTime $start_date
 * @property DateTime $end_date
 * @property int $total_price
 * @property string $status ('active','canceled_by_vip','canceled_by_yourself','completed') 
 * 
 * @author Spirkov Maksim
 */
class Rent extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return '{{rents}}';
    }

    public static function getAllRents()
    {
        return static::find()->orderBy(['start_date' => SORT_DESC]);
    }

    public static function getAllRentsByClientId($client_id)
    {
        return static::find()
            ->where(['client_id' => $client_id])
            ->orderBy(['start_date' => SORT_DESC]);
    }

    public static function updateStatus($rent_id, $status): bool
    {
        $rent = static::findOne($rent_id);
        $rent->status = $status;

        return $rent->save(false);
    }

    public static function getAllActiveRentsForCarByPeriod($startDate, $endDate, $car_id): array
    {
        $sql = "SELECT * FROM
                (
                    SELECT * FROM rents 
                    WHERE 
                        :startDate BETWEEN start_date AND end_date
                        OR :endDate BETWEEN start_date AND end_date
                        OR start_date BETWEEN :startDate AND :endDate
                        OR end_date BETWEEN :startDate AND :endDate
                ) AS tmp_rent
                WHERE 
                    car_id = :car_id AND status = 'active'";

        return Car::findBySql($sql, [
            ':startDate' => $startDate,
            ':endDate' => $endDate,
            ':car_id' => $car_id
        ])->asArray()->all();
    }

    public function create(): bool
    {
        return $this->save(false);
    }
}
