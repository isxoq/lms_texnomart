<?php

namespace common\models;

use Yii;

/**
 * Trait UserTelegramTrait
 * User bilan bog'liq amallarni telegram botga jo'natish uchun methodlar to'plami
 * @package common\models
 * @see \common\models\User
 * @var $this \common\models\User
 */
trait UserTelegramTrait
{

    /**
     * Yangi user ro'yxatdan o'tganda botga xabar jo'natish
     */
    public function sendToTelegramAboutNewUser()
    {
        $text = "#newuser\n";
        $title = "Yangi foydalanuvchi";
        $text .= "<b>$title</b>\n";

        $id = "🆔 $this->id \n";
        $user = "👤 $this->fullname \n";
        $phone = "☎ $this->phone \n";
        $date = "📅 " . Yii::$app->formatter->asDateTimeUz($this->created_at) . " \n";
        $count = "🎯 Bugungi ro'yxatdan o'tganlar soni: " . self::countTodayUsers() . "\n";

        $text .= $id . $user . $phone . $date . $count;

        $chat_id = Yii::$app->help->virtualdarsTelegramAkkountId();
        Yii::$app->telegram->sendMessage([
            'chat_id' => $chat_id,
            'text' => $text,
            'parse_mode' => 'html'
        ]);

    }

    /**
     * User o'z telefon raqamini o'zgartirganda yoki avval tel. raqami bo'lmagan user tel. raqamini
     * kiritganda botga xabar jo'natish
     * @param bool $isNewPhoneNumber
     */
    public function sendToTelegramAboutPhoneNumber($isNewPhoneNumber = true)
    {
        $text = "#phonenumber\n";
        $title = $isNewPhoneNumber ? "Foydalanuvchi telefon raqamini kiritdi" : "Foydalanuvchi telefon raqamini o'zgartirdi";
        $text .= "<b>$title</b>\n";

        $user = "👤 $this->fullname \n";
        $phone = "☎ $this->phone \n";

        $text .= $user . $phone;

        $chat_id = Yii::$app->help->virtualdarsTelegramAkkountId();
        Yii::$app->telegram->sendMessage([
            'chat_id' => $chat_id,
            'text' => $text,
            'parse_mode' => 'html'
        ]);

    }

    /**
     * Bugungi ro'yxatdan userlar soni
     */
    public static function countTodayUsers()
    {
        $begin = strtotime('today');
        $end = strtotime('tomorrow');

        $count = static::find()
            ->andWhere(['>=', 'created_at', $begin])
            ->andWhere(['<', 'created_at', $end])
            ->count();
        return intval($count);
    }


    /**
     * O'qituvchi tomonidan yangi user qo'shilganda botga xabar jo'natish
     * @param $user \common\models\User
     * @param $teacher \common\models\User
     */
    public function sendToTelegramAboutNewUserByTeacher($user, $teacher)
    {
        $text = "#newuser  #byteacher\n";

        $teacherFullname = '<b>' . $teacher->fullname . '</b>';

        $title = "O'qituvchi 🎓 $teacherFullname yangi foydalanuvchi qo'shdi";
        $text .= "$title\n";

        $id = "🆔 $user->id \n";
        $fullname = "👤<b>Talaba:</b> $user->fullname \n";
        $phone = "☎<b>Telefon:</b> $user->phone \n";
        $date = '📅 ' . Yii::$app->formatter->asDateTimeUz($user->created_at) . " \n";
        $count = "🎯 Bugungi ro'yxatdan o'tganlar soni: " . self::countTodayUsers() . "\n";

        $text .= $id . $fullname . $phone . $date . $count;

        $chat_id = Yii::$app->help->virtualdarsTelegramAkkountId();
        Yii::$app->telegram->sendMessage([
            'chat_id' => $chat_id,
            'text' => $text,
            'parse_mode' => 'html'
        ]);
    }

    /**
     * O'qituvchi tomonidan yangi user qo'shilganda botga xabar jo'natish
     * @param $student \backend\modules\usermanager\models\User
     * @param $enroll \backend\modules\kursmanager\models\Enroll
     * @param $teacher \common\models\User
     * @param $kurs \frontend\modules\teacher\models\Kurs
     */
    public function sendToTelegramAboutNewEnrollmentByTeacher($student, $enroll,  $teacher, $kurs)
    {
        $text = "#newenroll  #byteacher\n";

        $teacherFullname = '<b>' . $teacher->fullname . '</b>';

        $title = "O'qituvchi 🎓 $teacherFullname o'zining kursiga yangi talaba qo'shdi";
        $text .= "$title\n";

        $kursTitle = "📝<b>Kurs:</b> $kurs->title \n";
        $fullname = "👤<b>Talaba:</b> $student->fullname \n";
        $phone =  $student->phone ? "☎<b>Telefon:</b> $student->phone \n" : '';
        $email =  $student->email ? "📧<b>Email:</b> $student->email \n" : '';
        $price = "💰<b>Sotilgan narxi:</b> ".Yii::$app->formatter->asSum( $enroll->sold_price) ."\n";
        $date = '📅 ' . Yii::$app->formatter->asDateTimeUz($enroll->created_at) . " \n";

        $text .= $kursTitle . $fullname . $phone . $email . $price . $date ;

        $chat_id = Yii::$app->help->virtualdarsTelegramAkkountId();
        Yii::$app->telegram->sendMessage([
            'chat_id' => $chat_id,
            'text' => $text,
            'parse_mode' => 'html'
        ]);
    }


}