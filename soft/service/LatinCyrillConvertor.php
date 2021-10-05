<?php


namespace soft\service;


use yii\base\Component;

class LatinCyrillConvertor extends Component
{

    public static  $latinToCyrillPairs = [


        'email' => "эмаил",
        'Email' => "Эмаил",
        'EMAIL' => "ЭМАИЛ",

        'YO' => 'Ё',
        'TS' => 'Ц',
        'CH' => 'Ч',
        'SH' => 'Ш',
        'YU' => 'Ю',
        'YA' => 'Я',

        'Yo' => 'Ё',
        'Ts' => 'Ц',
        'Ch' => 'Ч',
        'Sh' => 'Ш',
        'Yu' => 'Ю',
        'Ya' => 'Я',

        "O'" => "Ў",
        "G'" => 'Ғ',

        'yo' => 'ё',
        'ts' => 'ц',
        'ch' => 'ч',
        'sh' => 'ш',
        'yu' => 'ю',
        'ya' => 'я',
        "o'" => "ў",
        "g'" => 'ғ',

        'a' => 'а',
        'b' => 'б',
        'c' => "с",
        'd' => 'д',
        'e' => 'е',
        'f' => 'ф',
        'g' => 'г',
        'h' => 'ҳ',
        'i' => 'и',
        'j' => 'ж',
        'k' => 'к',
        'l' => 'л',
        'm' => 'м',
        'n' => 'н',
        'o' => 'о',
        'p' => 'п',
        'q' => 'қ',
        'r' => 'р',
        's' => 'с',
        't' => 'т',
        'u' => 'у',
        'v' => 'в',
        'x' => 'х',
        'z' => 'з',
        'y' => 'й',


        'A' => 'А',
        'B' => 'Б',
        'C' => "С",
        'D' => 'Д',
        'E' => 'Е',
        'F' => 'Ф',
        'G' => 'Г',
        'H' => 'Ҳ',
        'I' => 'И',
        'J' => 'Ж',
        'K' => 'К',
        'L' => 'Л',
        'M' => 'М',
        'N' => 'Н',
        'O' => 'О',
        'P' => 'П',
        'Q' => 'Қ',
        'R' => 'Р',
        'S' => 'С',
        'T' => 'Т',
        'U' => 'У',
        'V' => 'В',
        'X' => 'Х',
        'Z' => 'З',
        'Y' => 'Й',

    ];


    public static function latinToCyrill($text='')
    {
        return strtr($text, static::$latinToCyrillPairs);
    }

    public static function cyrillToLatin($text='')
    {
        $pairs = static::$latinToCyrillPairs;
        $latins = array_keys($pairs);
        $cyrills = array_values($pairs);
        return strtr($text, $cyrills, $latins);
    }

}