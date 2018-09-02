<?php

use yii\db\Migration;

/**
 * Handles the creation of table `access`.
 */
class m180902_184348_create_access_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $options = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable('access', [
            'id' => $this->primaryKey(),
            'event_id'=>$this->integer()->notNull(),
            'user_id'=>$this->integer()->notNull(),
        ],$options);

        $this->addForeignKey('fk_access_event_id','access','event_id','event','id','CASCADE','CASCADE');
        $this->addForeignKey('fk_access_user_id','access','user_id','user','id','CASCADE','CASCADE');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_access_event_id','access');
        $this->dropForeignKey('fk_access_user_id','access');
        $this->dropTable('access');
    }
}

