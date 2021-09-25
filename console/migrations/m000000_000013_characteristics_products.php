<?php
/**
 * Create by: Vladislav Gladyr
 * Site: lockit.com.ua
 * Email: wild.savedo@gmail.com
 * Date : 12.09.2021
 * Time: 22:29
 * User: WyTcorporation
 */
class m000000_000013_characteristics_products extends \yii\db\Migration
{
    public function up()
    {

        $this->createTable('characteristics_products', [
            'id' => $this->primaryKey(),
            'characteristics_options_id' => $this->integer()->notNull(),
            'product_id' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey('characteristics-products-options-id', 'characteristics_products', 'characteristics_options_id', 'characteristics_options', 'id', 'CASCADE', 'CASCADE');

        $this->addForeignKey('characteristics-products-product-id', 'characteristics_products', 'product_id', 'products', 'id', 'CASCADE', 'CASCADE');

    }

    public function down()
    {
        $this->dropTable('characteristics_products');
    }
}