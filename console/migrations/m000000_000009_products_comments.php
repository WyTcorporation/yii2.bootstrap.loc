<?php
/**
 * Create by: Vladislav Gladyr
 * Site: lockit.com.ua
 * Email: wild.savedo@gmail.com
 * Date : 12.09.2021
 * Time: 22:22
 * User: WyTcorporation
 */

class m000000_000009_products_comments extends \yii\db\Migration
{
    public function up()
    {

        $this->createTable('products_comments', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer()->notNull(),
            'name' => $this->string(255)->notNull(),
            'comment' => $this->text()->notNull(),
            'rating' => $this->integer()->notNull(),
            'active' => $this->integer()->defaultValue(0),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->Null(),
            'created_ip' => $this->string()->notNull(),
            'updated_ip' => $this->string()->Null(),
        ]);

        $this->addForeignKey('products-comments-product-id', 'products_comments', 'product_id', 'products', 'id', 'CASCADE', 'CASCADE');

    }

    public function down()
    {
        $this->dropTable('products_comments');
    }
}