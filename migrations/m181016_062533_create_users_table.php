<?php

use yii\db\Migration;

/**
 * Handles the creation of table `users`.
 */
class m181016_062533_create_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('users', [
            'id' => $this->primaryKey(),
            'email' => $this->string()->notNull(),
            'username' => $this->string()->notNull(),
            'password' => $this->string()->notNull(),
            'full_name' => $this->string(),
            'phone_number' => $this->string(),
            'password_reset_token' => $this->string(),
            'auth_key' => $this->string(),
            'access_token' => $this->string(),
            'user_image' => $this->string(),
            'user_level' => "enum('member', 'admin')",
            'status' => $this->integer()->defaultValue(0),
            'created_at' => $this->dateTime()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('users');
    }
}
