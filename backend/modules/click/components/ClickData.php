<?php

namespace backend\modules\click\components;


class ClickData
{
    const SECRET_KEY = 't0N3svGrjKMMa';

    const MERCHANT_ID = "7400";
    const MERCHANT_USER_ID = "16167";
    const SERVICE_ID = "15787";

    const MIN_AMOUNT = 1000;
    const MAX_AMOUNT = 1000000;

    public static function getMessage($value)
    {
        $messages = array(
            0 => array("error" => "0", "error_note" => "Success"),
            1 => array("error" => "-1", "error_note" => "SIGN CHECK FAILED!"),
            2 => array("error" => "-2", "error_note" => "Incorrect parameter amount"),
            3 => array("error" => "-3", "error_note" => "Action not found"),
            4 => array("error" => "-4", "error_note" => "Already paid"),
            5 => array("error" => "-5", "error_note" => "User does not exist"),
            6 => array("error" => "-6", "error_note" => "Transaction does not exist"),
            7 => array("error" => "-7", "error_note" => "Failed to update user"),
            8 => array("error" => "-8", "error_note" => "Error in request from click"),
            9 => array("error" => "-9", "error_note" => "Transaction cancelled"),
            'n' => array("error" => "-n", "error_note" => "Unknown Error"),
        );
        return $messages[$value];
    }
}


?>