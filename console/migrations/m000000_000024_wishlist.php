<?php
/**
 * Create by: Vladislav Gladyr
 * Site: lockit.com.ua
 * Email: wild.savedo@gmail.com
 * Date : 13.09.2021
 * Time: 06:45
 * User: WyTcorporation
 */

class m000000_000024_wishlist extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('wishlist', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'title' => $this->string(255)->defaultValue('Мой список желаний'),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->Null(),
            'created_ip' => $this->string()->notNull(),
            'updated_ip' => $this->string()->Null(),
        ]);

        $this->addForeignKey('wishlist-user-id', 'wishlist', 'user_id', 'user', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('wishlist');
    }
}