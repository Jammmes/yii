<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\objects\EventAccessChecker;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\EventSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

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

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            [
                'attribute' => 'start_at',
                'format' =>  ['date', 'dd.MM.YYYY HH:mm:ss'],
            ],
            [
                'attribute' => 'end_at',
                'format' =>  ['date', 'dd.MM.YYYY HH:mm:ss'],
            ],
            [
                'attribute' => 'user.username',
                'label' => 'Автор события',
                'format' => 'text',
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
</div>
