<?phpuse yii\helpers\Html;use soft\kartik\SDetailView;/* @var $this soft\web\SView */$this->title = $model->title;$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Post Categories'), 'url' => ['index']];$this->params['breadcrumbs'][] = $this->title;?><div class="post-category-view">    <p>       <?= \soft\helpers\SHtml::updateButton($model->id) ?>    </p>    <?= \soft\adminty\DetailView::widget([        'model' => $model,        'attributes' => [            'title_uz',            'title_ru',            'slug',            'status',        ],    ]) ?></div>