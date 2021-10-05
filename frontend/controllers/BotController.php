<?php

namespace frontend\controllers;


/**
 * Created by Isxoqjon Axmedov.
 * WEB site: https://www.ninja.uz
 * Date: 5/8/2021
 * Time: 9:45 AM
 * Project name: virtualdarsd
 */

use backend\modules\botmanager\models\BotUser;

use backend\modules\categorymanager\models\Category;
use backend\modules\categorymanager\models\SubCategory;
use backend\modules\kursmanager\models\Kurs;
use yii;


class BotController extends \yii\web\Controller
{
    public $enableCsrfValidation = false;

    //    BOT API CALLS

    public function actionHook()
    {

        Yii::$app->response->format = "json";

        $update = Yii::$app->request->getRawBody();
        $update = json_decode($update);

        $message = $update->message;
        $chat_id = $update->message->chat->id;
        $user_id = $update->message->from->id;


        if ($message) {

            $this->messageHandler($message, $user_id);
        }


    }

    public function messageHandler($message, $user_id)
    {

        $user = BotUser::findOne(['user_id' => $user_id]);


        if ($user) {

            if ($user->step) {
                $this->setHandler($user, $message, $user->user_id);
                return 1;
            } else {
                if (!$this->messageIsCategory($message, $user_id, $user)) {

                    $this->setStep($user_id, 'getFio');
                    $model = new BotUser();
                    $model->user_id = $user_id;
                    $model->save();

                    $this->setHandler($user_id, 'getFio');


                    $this->main($user_id);
                }
            }


        } else {
            $user = new BotUser();
            $user->user_id = $user_id;
            $user->step = 'getFio';
            $user->save();
            $this->stepHandler($user, $user_id);
        }


    }


    public function findInCategories($category_name)
    {
        $models = $this->kursCategories();

        foreach ($models as $model) {
            if ($model->title_uz == $category_name) {
                return $model;
            }
        }


        $models = SubCategory::findAll(['status' => SubCategory::STATUS_ACTIVE]);

        foreach ($models as $model) {
            if ($model->title == $category_name) {
                return $model;
            }
        }


        return false;

    }

    public function messageIsCategory($message, $user_id, $user)
    {
        $model = $this->findInCategories($message->text);

        if ($model) {
            $user->step = 'selectSubCategory';
            $user->save();

            $this->request('sendMessage', [
                'chat_id' => $user_id,
                'text' => $this->t('select_category'),
                'parse_mode' => 'html',
                'reply_markup' => json_encode([
                    'keyboard' => $this->getKursButtons($model->getActiveSubCategories()->all()),
                    'resize_keyboard' => true
                ])
            ]);

            return 1;
        } else {
            $this->main($user_id);
            return 1;
        }


    }


    public function findLesson($text)
    {
        $models = Kurs::findAll(['status' => Kurs::STATUS_ACTIVE]);
        foreach ($models as $model) {
            if ($model->title == $text) {
                return $model;
            }
        }

        return false;
    }

    public function setHandler($user, $message, $user_id)
    {

        if (isset($message->contact)) {
            $user->phone = $message->contact->phone_number;
            $user->step = "";
            $user->save();
            $this->main($user_id);
            return 1;

        }
        if ($message->text == $this->t('home1')) {
            $user->step = "";
            $user->save();
            $this->main($user_id);
            return 1;

        }


        if ($user->step == "selectLesson") {

            if ($message->text == $this->t('buy')) {

                $url = "s";
                $kurs = Kurs::findOne(['id' => $user->temp_kurs_id, 'status' => Kurs::STATUS_ACTIVE]);

//                $this->request('sendMessage', [
//                    'chat_id' => $user_id,
//                    'text' => "salom"
//                ]);


                $url = yii\helpers\Url::to(['course/detail', 'id' => $kurs->slug], true);

                $this->request('sendMessage', [
                    'chat_id' => $user_id,
                    'text' => $this->t('buy_text'),
                    'parse_mode' => "html",
                    'reply_markup' => json_encode([
                        'inline_keyboard' => [
                            [['text' => $this->t('buy'), 'url' => $url]],
                        ],
                        'resize_keyboard' => true
                    ])

                ]);

                return 1;

            }

            $kurs = $this->findLesson($message->text);

            $user->temp_kurs_id = $kurs->id;
            $user->save();
            $text = "";
            $text .= $this->t('Kurs haqida:') . PHP_EOL . $kurs->short_description . PHP_EOL . PHP_EOL;

            $benefits_text = "";
            foreach ($kurs->getBenefitsAsArray() as $benefit) {
                $benefits_text .= "✅" . $benefit . PHP_EOL;
            }

            $text .= $this->t('benefits') . PHP_EOL . $benefits_text . PHP_EOL . PHP_EOL;

            $text .= $this->t('Davomiyligi:') . PHP_EOL . $kurs->durationText . PHP_EOL . PHP_EOL;
            $text .= $this->t('Kurs narxi:') . PHP_EOL . $kurs->formattedPrice . PHP_EOL . PHP_EOL;

            $this->request('sendMessage', [
                'chat_id' => $user_id,
                'text' => $text,
                'parse_mode' => "html",
                'reply_markup' => json_encode([
                    'keyboard' => [
                        [['text' => $this->t('buy')]],
                        [['text' => $this->t('home1')]],
                    ],
                    'resize_keyboard' => true
                ])
            ]);

        }


        if ($user->step == "selectSubCategory") {

            if ($this->isSubCategory($message->text)) {
                $model = $this->isSubCategory($message->text);
                $this->request('sendMessage', [
                    'chat_id' => $user_id,
                    'text' => $this->t('selectted_subcategory'),
                    'parse_mode' => 'html',
                    'reply_markup' => json_encode([
                        'keyboard' => $this->getLessonButtons($model),
                        'resize_keyboard' => true
                    ])
                ]);
                $user->step = "selectLesson";
                $user->save();
                return 1;
            }

        }

        if ($user->step == "getFio") {
            $user->fio = $message->text;
            $user->step = "getContact";
            $user->save();
            $this->stepHandler($user, $user_id);
            return 1;
        }

        if ($user->step == "getContact") {

            $user->phone = $message->text;
            $user->step = "";
            $user->save();
            $this->main($user_id);
            return 1;
        }


    }

    public function stepHandler($user, $user_id)
    {
        if ($user->step == "getFio") {
            $this->request('sendMessage', [
                'chat_id' => $user_id,
                'text' => $this->t('enter_fio'),
                'reply_markup' => json_encode([
                    'remove_keyboard' => true
                ])
            ]);
            return 1;
        }

        if ($user->step == "getContact") {
            $this->request('sendMessage', [
                'chat_id' => $user_id,
                'text' => $this->t('enter_contact'),
                'parse_mode' => 'html',
                'reply_markup' => json_encode([
                    'keyboard' => [
                        [['text' => $this->t('send_contact'), 'request_contact' => true]],
                    ],
                    'resize_keyboard' => true
                ])
            ]);
            return 1;
        }
    }

    public function main($user_id)
    {
        $this->request('sendMessage', [
            'chat_id' => $user_id,
            'text' => $this->t('select_category'),
            'parse_mode' => 'html',
            'reply_markup' => json_encode([
                'keyboard' => $this->getKursButtons(),
                'resize_keyboard' => true
            ])
        ]);
    }


    private function request($command, $data)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.telegram.org/bot1384771329:AAGdpHdpjiWNKKr42DOXqnM79KqFEiDFnPU/' . $command,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $data,
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }

    private function t($text)
    {

        return Yii::t('app', $text);

    }


    public function getKursButtons($models = null)
    {

        $keys = [];

        if ($models == null) {
            $models = $this->kursCategories();
        }


        foreach ($models as $model) {

            $keys[] = [['text' => $model->title]];

        }
        return $keys;
    }


    public function getLessonButtons($model)
    {

        $keys = [];
        $models = $model->getActiveCourses()->all();
        foreach ($models as $model) {

            $keys[] = [['text' => $model->title]];

        }
        return $keys;
    }

    public function kursCategories()
    {
        return Category::find()->active()->all();

    }

    public function isSubCategory($text)
    {
        $models = SubCategory::findAll(['status' => SubCategory::STATUS_ACTIVE]);
        foreach ($models as $model) {
            if ($model->title == $text) {
                return $model;
            }
        }

        return false;

    }

}



