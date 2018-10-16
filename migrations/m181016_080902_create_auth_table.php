<?php

use yii\db\Migration;

/**
 * Handles the creation of table `auth`.
 */
class m181016_080902_create_auth_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('auth', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->defaultValue(0),
            'source' => $this->string(),
            'source_id' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('auth');
    }
}
