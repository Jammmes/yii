<?php

namespace app\objects\viewModels;

use app\models\Event;
use app\objects\EventAccessChecker;
use yii\caching\DbDependency;
use yii\helpers\Html;

class EventView
{
    /**
     * Является ли текущий пользователь авторов события
     *
     * @param Event $model
     * @return bool
     */
    public function isAuthor(Event $model): bool
    {
        return (new EventAccessChecker)->isAllowedToWrite($model);
    }

    /**
     * @param Event $model
     * @return string
     */
    public function getDateString(Event $model): string
    {
        return date('d.m.Y H:i', strtotime($model->created_at));
    }

    /**
     * @param Event $model
     * @return string
     */
    public function getUserLink(Event $model): string
    {
        return Html::a($model->user->username, ['user/view', 'id' => $model->user_id]);
    }

    /**
     * @return array
     */
    public function getCacheParams(): array
    {
        $dependency = new DbDependency();
        $dependency->sql = 'SELECT COUNT(id) FROM event';

        return [
            'duration' => 0,
            'dependency' => $dependency
        ];
    }
}
