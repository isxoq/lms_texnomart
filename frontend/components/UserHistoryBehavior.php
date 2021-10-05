<?php
/*
 * @author Shukurullo Odilov <shukurullo0321@gmail.com>
 * Date: 30.04.2021, 9:55
 */

namespace frontend\components;

use Yii;
use yii\helpers\Url;
use backend\modules\usermanager\models\UserHistory;
use yii\base\Behavior;
use yii\web\Controller;
use Mobile_Detect;

class UserHistoryBehavior extends Behavior
{

    public const DEVICE_MOBILE = 1;
    public const DEVICE_TABLET = 2;
    public const DEVICE_DESCTOP = 3;
    public const DEVICE_APP = 4;

    public $excludeActions = [];

    /**
     * User App  orqali kirganligini bildirish uchun kerak
     * Mobile App uchun yozilgan controllerlarga ushbu xususiyatni true qilinadi
     * Shunda UserHistory::device_type qiymati self::DEVICE_APP ga teng bo'ladi
     * @var bool
     */
    public $isApp = false;

    public function events()
    {
        return [Controller::EVENT_AFTER_ACTION => 'afterAction'];
    }

    public function afterAction()
    {
//        $this->saveUserHistory();
    }

    public function saveUserHistory()
    {

        if (!Yii::$app->user->isGuest) {

            if ($this->isValidAction()){
                $device = new Mobile_Detect();

                $model = new UserHistory();
                $model->user_id = Yii::$app->user->identity->id;
                $model->ip = Yii::$app->request->userIP;
                $model->date = time();
                $model->url = Url::current();
                $model->device = $device->getUserAgent();
                $model->device_type = $this->detectDevice($device);
                $model->prev_url = Yii::$app->request->referrer;
                $model->page_title = Yii::$app->view->title;

                return $model->save();
            }
        }

    }

    /**
     * @param $device Mobile_Detect
     * @return int
     */
    private function detectDevice($device)
    {
        if ($this->isApp){
            return self::DEVICE_APP;
        }

        if ($device->isMobile()) {
            return self::DEVICE_MOBILE;
        }

        if ($device->isTablet()) {
            return self::DEVICE_TABLET;
        }

        return self::DEVICE_DESCTOP;
    }

    /**
     * @return bool
     */
    private function isValidAction()
    {
        if (empty($this->excludeActions)){
            return true;
        }

        $currentAction = Yii::$app->controller->action->id;
        $excludeActions = (array) $this->excludeActions;
        return !in_array($currentAction, $excludeActions, true);
    }

}