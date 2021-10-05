<?php

namespace backend\modules\billing\components;

use backend\modules\billing\models\Purchases;

/**
 * Class Billing
 */
class Billing extends \yii\base\Component
{

    /**
     * @param array $data
     * $data da quyidagi parametrlar bolishi kerak
     * user_revenue_percentage must be in $data
     * user_id
     * order_id
     * course_id
     * transaction_id
     * status
     * amount
     * payment_type
     * @return bool
     */
    public function newPurchase($data = []): bool
    {
        $purchase = new Purchases();

        $purchase->user_id = ($data['user_id']);
        $purchase->order_id = $data['order_id'];
        $purchase->course_id = $data['course_id'];
        $purchase->created_at = date('U');
        $purchase->transaction_id = $data['transaction_id'];
        $purchase->status = $data['status'];
        $purchase->amount = $data['amount'];
        $purchase->payment_type = $data['payment_type'];


        $revenue = $this->calculateRevenue($data['amount'], $data['user_revenue_percentage']);
        $purchase->teacher_fee = $revenue['teacher_revenue'];
        $purchase->platform_fee = $revenue['platform_revenue'];

        return $purchase->save();

    }

    /**
     * O'qituvchi va Platforma haqqini hisoblash
     * @param $amount
     * @param $user_revenue_percentage
     * @return array
     */
    public function calculateRevenue($amount, $user_revenue_percentage): array
    {
        $teacher = $amount * (($user_revenue_percentage) * 1.0 / 100);
        $platform = $amount - $teacher;

        return [
            'teacher_revenue' => $teacher,
            'platform_revenue' => $platform
        ];
    }
}