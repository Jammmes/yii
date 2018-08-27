<?php

use yii\db\Migration;

/**
 * Class m180827_052408_table_event
 */
class m180827_052408_table_event extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $options = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable('event',[
            'id'=> $this->primaryKey()->comment('ИД'),
            'name'=>$this->string(255)->comment('Название события'),
            'start_at'=>$this->timestamp()->defaultValue(date('Y-m-d H:i:s'))->comment('Начало события'),
            'end_at'=>$this->timestamp()->defaultValue(date('Y-m-d H:i:s'))->comment('Окончание события'),
            'created_at'=>$this->timestamp()->notNull()->defaultValue(date('Y-m-d H:i:s'))->comment('Запись создана'),
            'updated_at'=>$this->timestamp()->notNull()->defaultValue(date('Y-m-d H:i:s'))->comment('Запись  изменена'),
        ],$options);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('event');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180827_052408_table_event cannot be reverted.\n";

        return false;
    }
    */
}
