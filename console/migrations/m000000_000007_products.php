<?php
/**
 * Create by: Vladislav Gladyr
 * Site: lockit.com.ua
 * Email: wild.savedo@gmail.com
 * Date : 12.09.2021
 * Time: 20:56
 * User: WyTcorporation
 */

class m000000_000007_products extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('products', [
            'id' => $this->primaryKey(),
            'category_id' => $this->integer()->notNull(),
            'models_id' => $this->integer()->Null(),
            'price' => $this->float(11,2)->notNull(),
            'img' => $this->string(255)->defaultValue('no-image.png'),
            'gallery' => $this->text()->Null(),
            'slug' => $this->string(255)->notNull(),
            'vendor_code' => $this->string(255)->notNull(),
            'currency_code' => $this->string(3)->defaultValue('UAH'),
            'hit' => $this->integer()->defaultValue(0),
            'new' => $this->integer()->defaultValue(0),
            'sale' => $this->integer()->defaultValue(0),
            'active' => $this->integer()->defaultValue(0),
            'payment' => $this->integer()->defaultValue(0)->Null(),
            'status_stock' => $this->integer()->defaultValue(0),
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
        $this->dropTable('products');
    }
}