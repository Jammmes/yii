<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Event;
use app\objects\EventAccessChecker;
use app\objects\viewModels\EventView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\EventSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $viewModel EventView */

$this->title = 'События';
$this->params['breadcrumbs'][] = $this->title;

$isAllowedToWriteCallback = function (app\models\Event $event) {
    return (new \app\objects\EventAccessChecker())->isAllowedToWrite($event);
};

?>
<div class="event-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Новое событие', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php if ($this->beginCache('view_event_index'. \yii::$app->user->getId(), $viewModel->getCacheParams())):?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            [
                'label' => "Автор события",
                'format' => 'raw',
                'value' => function (Event $model) use ($viewModel) {
                    return $viewModel->getUserLink($model);
                }
            ],
            [
                'attribute' => 'start_at',
                'format' =>  ['date', 'dd.MM.YYYY HH:mm:ss'],
            ],
            [
                'attribute' => 'end_at',
                'format' =>  ['date', 'dd.MM.YYYY HH:mm:ss'],
            ],



            ['class' => 'yii\grid\ActionColumn'
                ,
                'visibleButtons' => [
                    'view' => function (\app\models\Event $model) {
                        return (new EventAccessChecker())->isAllowedToRead($model);
                    },
                    'update' => $isAllowedToWriteCallback,
                    'delete' => $isAllowedToWriteCallback,
                ],
            ],

        ],
    ]); ?>
        <?php $this->endCache();?>
    <?php endif;?>
</div>
