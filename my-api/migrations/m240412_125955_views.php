<?php

use yii\db\Migration;

/**
 * Class m240412_125955_views
 */
class m240412_125955_views extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('views', [
            'id' => $this->primaryKey(),
            'count'=>$this->integer(),
            'website_views'=>$this->integer(),
            'time_spent'=>$this->integer(),
            'btn_clicked'=>$this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m240412_125955_views cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240412_125955_views cannot be reverted.\n";

        return false;
    }
    */
}
