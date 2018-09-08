<?php

namespace app\objects;

use app\models\Access;
use app\models\Event;

class EventAccessChecker
{
    /**
     * @param Event $event
     *
     * @return bool
     */
    public function isAllowedToWrite(Event $event): bool
    {
        return \Yii::$app->user->getId() === (int)$event->user_id;
    }
    /**
     * @param Event $event
     *
     * @return bool
     */
    public function isAllowedToRead(Event $event): bool
    {
        if ($this->isAllowedToWrite($event)) {
            return true;
        }
        $userId = \Yii::$app->user->getId();
        $count = (int)Access::find()
            ->andWhere(
                [
                    'event_id' => $event->id,
                    'user_id' => $userId,
                ]
            )
            ->count('id');
        return $count > 0;
    }
}

