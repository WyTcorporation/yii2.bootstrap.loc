<?php
/**
 * Create by: Vladislav Gladyr
 * Site: lockit.com.ua
 * Email: wild.savedo@gmail.com
 * Date : 12.09.2021
 * Time: 22:20
 * User: WyTcorporation
 */

class m000000_000005_products_models extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('products_models', [
            'id' => $this->primaryKey(),
            'active' => $this->integer()->defaultValue(0),
        ]);
    }

    public function down()
    {
        $this->dropTable('products_models');
    }
}