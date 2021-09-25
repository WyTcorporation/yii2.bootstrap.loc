<?php
/**
 * Create by: Vladislav Gladyr
 * Site: lockit.com.ua
 * Email: wild.savedo@gmail.com
 * Date : 12.09.2021
 * Time: 21:43
 * User: WyTcorporation
 */

class m000000_000014_call_back extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('call_back', [
            'id' => $this->primaryKey(),
            'telephone' => $this->string(255)->notNull(),
            'product_name' => $this->string(255)->notNull(),
            'status' => $this->integer()->defaultValue(0),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->Null(),
            'created_ip' => $this->string()->notNull(),
            'updated_ip' => $this->string()->Null(),
        ]);

    }

    public function down()
    {
        $this->dropTable('call_back');
    }
}