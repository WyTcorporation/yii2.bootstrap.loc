<?php
/**
 * Create by: Vladislav Gladyr
 * Site: lockit.com.ua
 * Email: wild.savedo@gmail.com
 * Date : 13.09.2021
 * Time: 06:47
 * User: WyTcorporation
 */

class m000000_000025_wishlist_items extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('wishlist_items', [
            'id' => $this->primaryKey(),
            'wishlist_id' => $this->integer()->notNull(),
            'product_id' => $this->integer()->notNull(),
            'name' => $this->string(255)->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->Null(),
            'created_by' => $this->integer()->notNull(),
            'updated_by' => $this->integer()->Null(),
            'created_ip' => $this->string()->notNull(),
            'updated_ip' => $this->string()->Null(),
        ]);

        $this->addForeignKey('wishlist-items-wishlist-id', 'wishlist_items', 'wishlist_id', 'wishlist', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('wishlist_items');
    }
}