<div class="category-index">
    <?= \soft\adminty\GridView::widget([
        'dataProvider' => $dataProvider,
        'panelTemplate' => '{panelBefore}{items}',
        'panel' => [
            'before' => $this->title,
        ],
        'bordered' => true,
        'toolbarTemplate' => '{create}',
        'toolbarButtons' => [
            'create' => [
                'url' => to(['sub-category/create', 'category_id' => $model->id]),
            ],
        ],
        'cols' => [
            [
                'attribute' => 'image',
                'format' => 'thumbnail',
                'width' => '100px',
            ],
            'titleWithIcon:raw',
            'status' => [
                'width' => '50px',
            ],
            'actionColumn' => [
                'template' => "{update} {delete}",
                'controller' => '/categorymanager/sub-category',
            ],
        ],
    ]); ?>
</div>
