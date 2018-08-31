<?php

use yii\db\Migration;
use app\models\Event;

/**
 * Class m180831_093110_add_field_user_id_into_event
 */
class m180831_093110_add_field_user_id_into_event extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $eventTable = Event::tableName();

        $this->addColumn($eventTable,'user_id',$this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $eventTable = Event::tableName();

        $this->dropColumn($eventTable,'user_id');

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180831_093110_add_field_user_id_into_event cannot be reverted.\n";

        return false;
    }
    */
}
