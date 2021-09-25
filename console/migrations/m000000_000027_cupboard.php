<?php
/**
 * Create by: Vladislav Gladyr
 * Site: lockit.com.ua
 * Email: wild.savedo@gmail.com
 * Date : 13.09.2021
 * Time: 07:04
 * User: WyTcorporation
 */

class m000000_000027_cupboard extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('cupboard', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'code' => $this->text()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->Null(),
            'created_by' => $this->integer()->notNull(),
            'updated_by' => $this->integer()->Null(),
            'created_ip' => $this->string()->notNull(),
            'updated_ip' => $this->string()->Null(),
        ]);

        $this->addForeignKey('cupboard-user-id', 'cupboard', 'user_id', 'user', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('cupboard');
    }
}