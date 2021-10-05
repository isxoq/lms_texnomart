<?php


namespace soft\db;

use Yii;

/**
 * Trait SActiveRecordFindTrait - SActiveRecord uchun find() metodlari
 * @package soft\db
 */
trait SActiveRecordFindTrait
{

    /**
     * @return SActiveQuery
     */
    public static function find()
    {
        return new \soft\db\SActiveQuery(get_called_class());
    }

    /**
     * Berilgan $id qiymat bo'yicha modelni topish
     * @param string $id
     * @return static
     * @throws yii\web\NotFoundHttpException
     */
    public static function findModel($id='')
    {
        $model = static::find()->where(['id' => $id])->one();
        if ($model == null) {
            throw new \yii\web\NotFoundHttpException(Yii::t('app',"Page not found!"));
        }
        return $model;
    }

    /**
     * Jadvaldag activ modelni topish
     * DIQQAT: Bu metoddan foydalanish uchun jadvalda status degan maydon bo'lishi zarur
     * @param string $id
     * @return array|\yii\db\ActiveRecord|null
     */
    public static function findActiveOne($id='')
    {
        $tableName = static::tableName();
        return static::find()->where(['id' => $id])->andWhere([$tableName.'.status' => SActiveRecord::STATUS_ACTIVE])->one();
    }

    /**
     * Aktiv modelni topish
     * @param string $id
     * @return array|\yii\db\ActiveRecord
     * @throws \yii\web\NotFoundHttpException - agar model topilmasa yoki aktiv bo'lmasa
     */
    public static function findActiveModel($id='')
    {
        $model = static::findActiveOne($id);
        if ($model == null) {
            throw new \yii\web\NotFoundHttpException(Yii::t('app',"Page not found!"));
        }
        return $model;
    }

}