<?php

namespace app\objects\viewModels;

use app\models\Event;
use app\models\User;
use yii\helpers\BaseArrayHelper;

class AccessUpdateView
{
    private $time;

    /**
     * AccessUpdateView constructor.
     */
    public function __construct()
    {
        $this->time = (int)\Yii::$app->params['cacheTime'];
    }

    /**
     * @return array
     */
    public function getUserOptions(): array
    {
        return BaseArrayHelper::map(User::find()->cache($this->time)->all(), 'id', 'username');
    }

    /**
     * @return array
     */
    public function getEventOptions(): array
    {
        return BaseArrayHelper::map(Event::find()->cache($this->time)->all(), 'id', 'name');
    }
}
