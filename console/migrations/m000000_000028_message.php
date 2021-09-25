<?php
/**
 * Create by: Vladislav Gladyr
 * Site: lockit.com.ua
 * Email: wild.savedo@gmail.com
 * Date : 13.09.2021
 * Time: 07:07
 * User: WyTcorporation
 */


class m000000_000028_message extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('message', [
            'id' => $this->primaryKey(),
            'from' => $this->integer()->Null(),
            'to' => $this->integer()->Null(),
            'text' => $this->text()->Null(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->Null(),
            'created_by' => $this->integer()->notNull(),
            'updated_by' => $this->integer()->Null(),
            'created_ip' => $this->string()->notNull(),
            'updated_ip' => $this->string()->Null(),
        ]);
    }

    public function down()
    {
        $this->dropTable('message');
    }
}