<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%views}}`.
 */
class m240616_164442_create_views_table extends Migration
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
        'OS'=>$this->string(),
        'IP'=>$this->string()
    ]);
}

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%views}}');
    }
}
