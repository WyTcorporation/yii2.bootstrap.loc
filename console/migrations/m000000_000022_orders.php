<?php
/**
 * Create by: Vladislav Gladyr
 * Site: lockit.com.ua
 * Email: wild.savedo@gmail.com
 * Date : 13.09.2021
 * Time: 06:32
 * User: WyTcorporation
 */

class m000000_000022_orders extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('orders', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'name' => $this->string(255)->notNull(),
            'email' => $this->string(255)->notNull(),
            'phone' => $this->string(255)->notNull(),
            'address' => $this->integer()->Null(),
            'qty' => $this->integer()->notNull(),
            'sum' => $this->float(11,2)->notNull(),
            'payment' => $this->integer()->Null(),
            'shipping' => $this->integer()->Null(),
            'status' => $this->integer()->defaultValue(0),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->Null(),
            'created_ip' => $this->string()->notNull(),
            'updated_ip' => $this->string()->Null(),
        ]);

        $this->addForeignKey('orders-user-id', 'orders', 'user_id', 'user', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('orders');
    }
}