<?php


namespace soft\adminty;

use Yii;
use soft\widget\SButton;
use soft\grid\SKGridView;
use soft\helpers\SUrl;

class GridView extends SKGridView
{

    public $bordered = false;
    public $striped = false;
    public $condensed = true;
    public $pjax = true;

    public $breakWords = true;

    public $bulkButtonsTemplate = false;

    public $panelBeforeTemplate = <<< HTML
    {toolbarContainer}
    {before}
     <div class="clearfix"></div>
    {summary}
    <div class="clearfix"></div>
HTML;


    public $panelTemplate = <<< HTML
{panelBefore}
{items}
{panelAfter}
{panelFooter}
HTML;

    public $summary = <<<HTML
        <br>
        <div class="summary">
        Namoyish etilyapti: <b>{begin}-{end}</b>. Jami: <b>{totalCount}</b> ta yozuv.
</div>
HTML;


    public function defaultValues()

    {

        return [
            'panel' => [
                'type' => false,
                'after' => "{bulk-buttons}",
                'beforeOptions' => [
                    'style' => 'border:0px',
                ],
            ],
            'toolbarButtons' => [
                'create' => [
                    'modal' => false,
                    'pjax' => false,
                    'url' => SUrl::to(['create']),
                    'style' => SButton::STYLE['default'],
                    'icon' => 'plus',
                    'title' => "Yangi qo'shish",
                    'options' => [
                        'class' => 'btn-outline-success',
                    ]

                ],

                'refresh' => [
                    'url' => SUrl::current(),
                    'style' => SButton::STYLE['default'],
                    'icon' => 'sync-alt',
                    'title' => "Yangilash",
                    'options' => [
                        'class' => 'btn-outline-primary',
                    ]
                ],
            ],

            'bulkButtons' => [
                'delete' => [
                    "confirmMessage" => "Siz rostdan ham tanlangan elementlarni o'chirishni xoxlaysizmi?",
                    'label' => "O'chirish",
                    'url' => SUrl::to(['/general/bulk-delete-models', 'modelClass' => $this->getModelClass()]),
                    'icon' => 'trash-alt',
                    'style' => 'btn-danger',
                    'title' => Yii::t('app', 'Delete selected items'),
                ],
            ],
        ];
    }

    public function defaultColumns()
    {
        return [
            'image' => [
                'filter' => false,
                'attribute' => 'image',
                'format' => ['image', ['height' => '100px']],
            ],

            'status' => [
                'attribute' => 'status',
                'format' => 'status',
                'vAlign' => 'middle',
                'width' => '100px',
                'filter' => [0 => Yii::t('app', 'Inactive'), 1 => Yii::t('app', 'Active')],
            ],

            'updated_at' => [
                'attribute' => 'updated_at',
                'format' => 'dateTimeUz',
                'filter' => false,
            ],

            'created_at' => [
                'attribute' => 'created_at',
                'format' => 'dateTimeUz',
                'filter' => false,
            ],

            'serialColumn' => [
                'class' => 'kartik\grid\SerialColumn',
                'width' => '70px',
            ],

            'checkboxColumn' => [
                'class' => 'kartik\grid\CheckboxColumn',
                'width' => '20px',
            ],

            'radioColumn' => [
                'class' => 'kartik\grid\RadioColumn',
                'width' => '20px',
            ],

            'actionColumn' => [
                'class' => 'soft\adminty\ActionColumn',
                'width' => '100px',
                'dropdown' => true,
            ],
        ];
    }


}