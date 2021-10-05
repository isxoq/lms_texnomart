<?php


namespace soft\i18n;


use kartik\helpers\Html;

use soft\helpers\SHtml;
use Yii;

use yii\i18n\Formatter;


class SFormatter extends Formatter

{

    public $nullDisplay = '<span class="not-set">null</span>';


    public $timeZone = 'Asia/Tashkent';

    public function init()
    {
        date_default_timezone_set($this->timeZone);
        parent::init();
    }


    public function asStatus($value)
    {

        switch ($value) {
            case 1:
            case 10:
                return '<label class="label label-success">Faol</label>';
            case 0:
                return '<label class="label label-danger">Nofaol</label>';
            case 5:
                return '<label class="label label-warning">Yangi</label>';
            default:
                return $value;
        }
    }


    public function asDollar($value)
    {
        return $this->asDecimal($value, 1) . "$";
    }


    public function asSum($value)
    {
        if ($value == null) {
            return "";
        }
        return $this->asInteger($value) . " " . Yii::t('app', "sum");
    }


    public function asLittleImage($value, $width = '150px')
    {
        $options['width'] = $width;
        return $this->asImage($value, $options);
    }

    public function asThumbnail($value = null, $size = '75px', $options = [])
    {
        $class = isBs4() ? "img-thumbnail" : 'thumbnail';
        if ($value == null) {
            return $this->nullDisplay;
        }
        SHtml::addCssClass($options, $class);
        SHtml::addCssStyle($options, "max-height:{$size};max-width:{$size};display: block;margin-left: auto;margin-right: auto;");
        return SHtml::img($value, $options);

    }

    public function asBool($value, $text1 = null, $text2 = null)
    {
        if ($text1 == null) {
            $text1 = t('Yes', 'yii');
        }
        if ($text2 == null) {
            $text2 = t('No', 'yii');
        }
        if ($value) {
            return Html::badge($text1, ['class' => 'badge-primary']);
        } else {
            return Html::badge($text2, ['class' => 'badge-danger']);
        }
    }

    public function asShortText($value, $length = 150, $end = " ...")
    {
        $text = strip_tags($value);
        if (strlen($text) < $length) {
            return $text;
        }
        return mb_substr(strip_tags($text), 0, $length) . $end;
    }

    /**
     * @param $value int timestapm
     **/
    public function asDateUz($value = null)
    {
        if ($value == null) {
            return null;
        }
        $month = Yii::t('app', date('M', $value));

        return date('d', $value) . "-" . $month . "-" . date('Y', $value);
    }

    /**
     * @param $value timestapm
     **/
    public function asFullDateUz($value = null)
    {
        if ($value == null) {
            return null;
        }
        $month = $this->fullMonthName(date('m', $value));
        return date('d', $value) . "-" . $month . "-" . date('Y', $value);
    }

    /**
     * @param $value timestapm
     **/
    public function asTimeUz($value = null)
    {
        if ($value == null) {
            return null;
        }

        return date('H:i', $value);
    }

    /**
     * @param $value timestapm
     * @return string|null Formatted datetime
     */
    public function asDateTimeUz($value = null)
    {
        if ($value == null) {
            return null;
        }

        return $this->asDateUz($value) . " " . $this->asTimeUz($value);
    }

    /**
     * @param $value int
     **/
    public function asFullDateTimeUz($value = null)
    {
        if ($value == null) {
            return null;
        }

        return $this->asFullDateUz($value) . " " . $this->asTimeUz($value);
    }

    /**
     * @param string $value phone number, like "+998911234567", +(998) 91 656-03-21, "911234567", or "998911234567"
     * @return string phone number with operator code, like "911234567"
     */

    public function asShortPhoneNumber($value)
    {
        $phoneNumber = Yii::$app->help->clearPhoneNumber($value);
        if (strlen($phoneNumber) == 12) {
            $phoneNumber = substr($phoneNumber, 3);
        }
        return $phoneNumber;
    }

    /**
     * @param $value
     * @return array|string|string[]
     */
    public function asFormattedShortPhoneNumber($value)
    {
        $phoneNumber = $this->asShortPhoneNumber($value);
        $phoneNumber = substr_replace($phoneNumber, ' ', 2, 0);
        $phoneNumber = substr_replace($phoneNumber, '-', 6, 0);
        return substr_replace($phoneNumber, '-', 9, 0);
    }

    public function fullMonthName($monthNumber = 0)
    {
        switch ($monthNumber) {

            case '01' :
                return Yii::t('app', 'January');
            case '02' :
                return Yii::t('app', 'February');
            case '03' :
                return Yii::t('app', 'March');
            case '04' :
                return Yii::t('app', 'April');
            case '05' :
                return Yii::t('app', 'May');
            case '06' :
                return Yii::t('app', 'June');
            case '07' :
                return Yii::t('app', 'July');
            case '08' :
                return Yii::t('app', 'August');
            case '09' :
                return Yii::t('app', 'September');
            case '10' :
                return Yii::t('app', 'October');
            case '11' :
                return Yii::t('app', 'November');
            case '12' :
                return Yii::t('app', 'December');
            default:
                return false;


        }
    }

    public function asGmtime($value = null)
    {
        if ($value == null) {
            return 0;
        }
        $value = intval($value);

        $hours = floor($value / 3600);
        $minutes = floor(($value / 60) % 60);
        $seconds = $value % 60;

        $minutesText = strval($minutes);
        $minutesText = $minutes < 10 ? '0' . $minutesText : $minutesText;

        $secondsText = strval($seconds);
        $secondsText = $seconds < 10 ? '0' . $secondsText : $secondsText;


        if ($hours > 0) {

            $hoursText = strval($hours);
            $hoursText = $hours < 10 ? '0' . $hoursText : $hoursText;

            return "$hoursText:$minutesText:$secondsText";
        }

        return "$minutesText:$secondsText";
    }

    public function asFileSize($value = null)
    {
        if ($value == null) {
            return $this->nullDisplay;
        }
        $size = intval($value);
        if ($size <= 0) {
            return '';
        }

        if ($size < 1024) {
            return $this->asDecimal($size, 2) . " Bayt";
        }
        if ($size < 1024 * 1024) {
            return $this->asDecimal($size / 1024, 2) . " KB";
        }
        return $this->asDecimal($size / 1024 / 1024, 2) . " MB";

    }


    /**
     * @param $value
     * @param array $options
     * @return string
     */
    public function asSmall($value, $options = [])
    {
        if ($value == null) {
            return $this->nullDisplay;
        }
        return Html::tag('small', $value, $options);
    }
}


?>