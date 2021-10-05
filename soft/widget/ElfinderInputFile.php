<?php


namespace soft\widget;


use mihaildev\elfinder\InputFile;

class ElfinderInputFile extends InputFile
{

      public $language = 'ru';
      public $template = '<div class="input-group">{input}<span class="input-group-btn">{button}</span></div>';
      public $options = ['class' => 'form-control'];
      public $buttonOptions = ['class' => 'btn btn-success'];
      public $multiple = false;

}