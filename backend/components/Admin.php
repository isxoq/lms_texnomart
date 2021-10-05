<?php


namespace backend\components;

use Yii;
use backend\modules\kursmanager\models\Enroll;
use backend\modules\ordermanager\models\Order;
use common\models\User;
use yii\base\Component;

/**
 * Class Admin
 * Admin bajarishi mumkin bo'lgan amallar
 * @package backend\components
 */
class Admin extends Component
{

    /**
     * @param $user User
     * @return bool
     * @throws \Exception
     */
    public function approveTeacher($user)
    {
        if ($user instanceof User) {
            $user->type = User::TYPE_TEACHER;
            return $user->save(false);
        }
    }

    public function createFreeEnroll($kurs, $user_id)
    {
        $enroll = new Enroll();
        $enroll->user_id = $user_id;
        $enroll->kurs_id = $kurs->id;
        $enroll->type = Enroll::TYPE_FREE;
        $enroll->status = 1;
        $enroll->created_at = time();
        $enroll->generateEndTime($kurs->duration);
        $enroll->sold_price = 0;

        if ($enroll->save()) {
            $this->sendToTelegramAboutFreeEnroll($enroll);
            return true;
        } else {
            return false;
        }


    }

    /**
     * Buyurtmani faollashtirish
     * Bunda buyurtma muallifi to'lov qilgandan keyin buyurtma qilingan kursga a'zo qilinadi
     * @param $order_id int Order id
     * @return bool
     */
    public function activateOrder($order_id)
    {

        $order = Order::findOne($order_id);
        if ($order == null || $order->kurs == null) {
            return false;
        }

        $enroll = Enroll::findOne([
            'user_id' => $order->user_id,
            'kurs_id' => $order->kurs_id,
        ]);

        if ($enroll == null) {
            $enroll = new  Enroll([
                'user_id' => $order->user_id,
                'kurs_id' => $order->kurs_id,
            ]);
        }

        $enroll->type = Enroll::TYPE_PURCHASED;
        $enroll->sold_price = $order->amount;
        $enroll->generateEndTime($order->kurs->duration);
        $enroll->status = 1;

        if ($enroll->save()) {
            $order->payed();
            return true;
        }

        return false;

    }

    private function sendToTelegramAboutFreeEnroll(Enroll $enroll)
    {
        $kurs = $enroll->kurs;
        $student = $enroll->user;

        $text = "#newenroll  #freeenroll\n";

        $title = "Yangi bepul a'zolik";
        $text .= "$title\n";

        $kursTitle = "📝<b>Kurs:</b> $kurs->title \n";
        $fullname = "👤<b>Talaba:</b> $student->fullname \n";
        $phone = $student->phone ? "☎<b>Telefon:</b> $student->phone \n" : '';
        $email = $student->email ? "📧<b>Email:</b> $student->email \n" : '';
        $date = '📅 ' . Yii::$app->formatter->asDateTimeUz($enroll->created_at) . " \n";

        $text .= $kursTitle . $fullname . $phone . $email . $date;

        $chat_id = Yii::$app->help->virtualdarsTelegramAkkountId();
        Yii::$app->telegram->sendMessage([
            'chat_id' => $chat_id,
            'text' => $text,
            'parse_mode' => 'html'
        ]);
    }

}