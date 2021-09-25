<?php
/**
 * Create by: Vladislav Gladyr
 * Site: lockit.com.ua
 * Email: wild.savedo@gmail.com
 * Date : 13.09.2021
 * Time: 06:40
 * User: WyTcorporation
 */

class m000000_000023_orders_items extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('orders_items', [
            'id' => $this->primaryKey(),
            'order_id' => $this->integer()->notNull(),
            'product_id' => $this->integer()->notNull(),
            'name' => $this->string(255)->notNull(),
            'img' => $this->string(255)->defaultValue('no-image.png'),
            'slug' => $this->string(255)->notNull(),
            'price' => $this->float(11,2)->notNull(),
            'qty_item' => $this->integer()->notNull(),
            'sum_item' => $this->float(11,2)->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->Null(),
            'created_ip' => $this->string()->notNull(),
            'updated_ip' => $this->string()->Null(),
        ]);

        $this->addForeignKey('orders-items-user-id', 'orders_items', 'order_id', 'orders', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('orders_items');
    }
}