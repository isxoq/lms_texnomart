<?php


namespace soft\service;

class InputType{

    const STATIC = 'staticInput';
    const HIDDEN = 'hiddenInput';
    const HIDDEN_STATIC = 'hiddenStaticInput';
    const TEXT = 'textInput';
    const TEXTAREA = 'textarea';
    const PASSWORD = 'passwordInput';
    const DROPDOWN_LIST = 'dropdownList';
    const LIST_BOX = 'listBox';
    const CHECKBOX = 'checkbox';
    const RADIO = 'radio';
    const CHECKBOX_LIST = 'checkboxList';
    const RADIO_LIST = 'radioList';
    const CHECKBOX_BUTTON_GROUP = 'checkboxButtonGroup';
    const RADIO_BUTTON_GROUP = 'radioButtonGroup';
    const MULTISELECT = 'multiselect';
    const FILE = 'fileInput';
    const HTML5 = 'input';
    const WIDGET = 'widget';
    const DEPDROP = '\kartik\depdrop\DepDrop';
    const SELECT2 = '\kartik\select2\Select2';
    const TYPEAHEAD = '\kartik\typeahead\Typeahead';
    const SWITCH = '\kartik\switchinput\SwitchInput';
    const SPIN = '\kartik\touchspin\TouchSpin';
    const RATING = '\kartik\rating\StarRating';
    const RANGE = '\kartik\range\RangeInput';
    const COLOR = '\kartik\color\ColorInput';
    const FILEINPUT = '\kartik\file\FileInput';
    const DATE = '\kartik\date\DatePicker';
    const TIME = '\kartik\time\TimePicker';
    const DATETIME = '\kartik\datetime\DateTimePicker';
    const DATE_RANGE = '\kartik\daterange\DateRangePicker';
    const SORTABLE = '\kartik\sortinput\SortableInput';
    const SLIDER = '\kartik\slider\Slider';
    const MONEY = '\kartik\money\MaskMoney';
    const CHECKBOX_X = '\kartik\checkbox\CheckboxX';

    // inputs list
    protected static $basicInputs = [
        self::HIDDEN => 'hiddenInput',
        self::TEXT => 'textInput',
        self::PASSWORD => 'passwordInput',
        self::TEXTAREA => 'textarea',
        self::CHECKBOX => 'checkbox',
        self::RADIO => 'radio',
        self::LIST_BOX => 'listBox',
        self::DROPDOWN_LIST => 'dropDownList',
        self::CHECKBOX_LIST => 'checkboxList',
        self::RADIO_LIST => 'radioList',
        self::HTML5 => 'input',
        self::FILE => 'fileInput',
        self::WIDGET => 'widget',
        self::CHECKBOX_BUTTON_GROUP => 'checkboxButtonGroup',
        self::RADIO_BUTTON_GROUP => 'radioButtonGroup',
    ];

    // dropdown inputs
    protected static $dropDownInputs = [
        self::LIST_BOX => 'listBox',
        self::DROPDOWN_LIST => 'dropDownList',
        self::CHECKBOX_LIST => 'checkboxList',
        self::RADIO_LIST => 'radioList',
        self::CHECKBOX_BUTTON_GROUP => 'checkboxButtonGroup',
        self::RADIO_BUTTON_GROUP => 'radioButtonGroup',
    ];

    protected static $widget = [
        self::WIDGET => 'widget',
    ];

//    widget inputs
    protected static $widgets = [
        self::DEPDROP => '\kartik\depdrop\DepDrop',
        self::SELECT2 => '\kartik\select2\Select2',
        self::TYPEAHEAD => '\kartik\typeahead\Typeahead',
        self::SWITCH => '\kartik\switchinput\SwitchInput',
        self::SPIN => '\kartik\touchspin\TouchSpin',
        self::RATING => '\kartik\rating\StarRating',
        self::RANGE => '\kartik\range\RangeInput',
        self::COLOR => '\kartik\color\ColorInput',
        self::FILEINPUT => '\kartik\file\FileInput',
        self::DATE => '\kartik\date\DatePicker',
        self::TIME => '\kartik\time\TimePicker',
        self::DATETIME => '\kartik\datetime\DateTimePicker',
        self::DATE_RANGE => '\kartik\daterange\DateRangePicker',
        self::SORTABLE => '\kartik\sortinput\SortableInput',
        self::SLIDER => '\kartik\slider\Slider',
        self::MONEY => '\kartik\money\MaskMoney',
        self::CHECKBOX_X => '\kartik\checkbox\CheckboxX',
    ];

    public static function getInputCategory($type){
        if (isset(self::$basicInputs[$type] )) return 'basicInput';
        if (isset(self::$dropDownInputs[$type] )) return 'dropDownInput';
        if ($type == self::WIDGET) return 'widget';
        if (isset(self::$widgets[$type] )) return 'widgets';
        return false;
    }
}