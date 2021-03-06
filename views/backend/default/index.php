<?php

/**
 * Products list view.
 *
 * @var \yii\base\View $this View
 * @var \yii\data\ActiveDataProvider $dataProvider Data provider
 * @var \yii3ds\promotions\models\backend\EventSearch $searchModel Search model
 * @var array $statusArray Statuses array
 */

use yii3ds\themes\admin\widgets\Box;
use yii3ds\themes\admin\widgets\GridView;
use yii3ds\promotions\Module;
use yii\grid\ActionColumn;
use yii\grid\CheckboxColumn;
use yii\helpers\Html;
use yii\jui\DatePicker;

$this->title = Module::t('promotions', 'BACKEND_INDEX_TITLE');
$this->params['subtitle'] = Module::t('promotions', 'BACKEND_INDEX_SUBTITLE');
$this->params['breadcrumbs'] = [
    $this->title
];
$gridId = 'promotions-grid';
$gridConfig = [
    'id' => $gridId,
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        [
            'class' => CheckboxColumn::classname()
        ],
        'id',
        'title_th',
        'title_en',
        'price',
        'price_special',
        'created_at',
        'image' => [
            
            'format' => ['image',['width'=>'100','height'=>'100']],
            'value' => function ($model) {                      
                    return  $model->image;
            },
        ]
    ]
];

$boxButtons = $actions = [];
$showActions = false;

if (Yii::$app->user->can('BCreateProducts')) {
    $boxButtons[] = '{create}';
}
if (Yii::$app->user->can('BUpdateProducts')) {
    $actions[] = '{update}';
    $showActions = $showActions || true;
}
if (Yii::$app->user->can('BDeleteProducts')) {
    $boxButtons[] = '{batch-delete}';
    $actions[] = '{delete}';
    $showActions = $showActions || true;
}

if ($showActions === true) {
    $gridConfig['columns'][] = [
        'class' => ActionColumn::className(),
        'header'=>'Actions',
        'template' => implode(' ', $actions),
        'contentOptions' => ['style' => 'width:60px;']
    ];
}
$boxButtons = !empty($boxButtons) ? implode(' ', $boxButtons) : null; ?>

<div class="row">
    <div class="col-xs-12">
        <?php Box::begin(
            [
                'title' => $this->params['subtitle'],
                'bodyOptions' => [
                    'class' => 'table-responsive'
                ],
                'buttonsTemplate' => $boxButtons,
                'grid' => $gridId
            ]
        ); ?>
        <?= GridView::widget($gridConfig); ?>
        <?php Box::end(); ?>
    </div>
</div>