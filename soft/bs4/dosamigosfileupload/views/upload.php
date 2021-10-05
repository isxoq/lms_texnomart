<!-- The template to display files available for upload -->
<?php

$css = <<<CSS

table video{
    max-width: 600px;
}

CSS;

$this->registerCss($css);

$js = <<<JS

  /* $(document).on('click',  '#cancel-button' , function (){
       $('#select-file-button').show()
   })*/

JS;

$this->registerJs($js);


?>


<script id="template-upload" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-upload">
        <td>
              <p class="name">{%=file.name%}</p>
            <strong class="error text-danger"></strong>
            <p class="size"><?= Yii::t('fileupload', 'Processing') ?>...</p>

            <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="progress-bar progress-bar-success" style="width:0%;"></div></div>
            <br>
            <p>
               {% if (!i && !o.options.autoUpload) { %}show
                <button class="btn btn-primary start" disabled>
                    <i class="glyphicon glyphicon-upload"></i>
                    <span>Yuklash</span>
                </button>
            {% } %}
            {% if (!i) { %}
                <button class="btn btn-warning cancel" id="cancel-button">
                    <i class="glyphicon glyphicon-ban-circle"></i>
                    <span>Bekor qilish</span>
                </button>
            {% } %}
            </p>
            <p>
            <span class="preview"></span>
            </p>

        </td>
    </tr>
{% } %}
</script>