<?php

namespace backend\modules\ordermanager\models;

use backend\modules\usermanager\models\User;
use soft\db\SActiveRecord;
use backend\modules\kursmanager\models\Kurs;

/**
 * This is the model class for table "order".
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $status
 * @property float|null $amount
 *
 * @property User $user
 * @property-read Kurs $kurs
 * @property-read int $isPayed
 * @property int $kurs_id [int]
 */
class Order extends SActiveRecord
{

    /**
     * User yangi buyurtma berganda, hali pulini to'lamagan holatida
     * statusi ⏬ shunga teng bo'ladi
     */
    const STATUS_NOT_PAYED = 5;
    const STATUS_PAYED = 7;

    public static function tableName()
    {
        return 'order';
    }

    public function rules()
    {
        return [
            [['user_id', 'created_at', 'updated_at', 'status', 'kurs_id'], 'integer'],
            [['amount'], 'number']
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getKurs()
    {
        return $this->hasOne(Kurs::className(), ['id' => 'kurs_id']);
    }

    /**
     * Buyurtmani to'langan yoki to'lanmaganini tekshirish
     * @return bool
     */
    public function getIsPayed()
    {
        return $this->status == self::STATUS_PAYED;
    }

    /**
     * Buyurtmani to'langan holatga o'tkazish
     * @return bool
     */
    public function payed()
    {
        $this->status = self::STATUS_PAYED;
        return $this->save(false);
    }

    public function setAttributeNames()
    {
        return [
            'createdByAttribute' => 'user_id',

//            Timestamp attributes
            'createdAtAttribute' => 'created_at',
            'updatedAtAttribute' => 'updated_at',
        ];
    }


}
