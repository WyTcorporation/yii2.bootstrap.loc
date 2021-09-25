<?php
/**
 * Create by: Vladislav Gladyr
 * Site: lockit.com.ua
 * Email: wild.savedo@gmail.com
 * Date : 13.09.2021
 * Time: 07:14
 * User: WyTcorporation, WyTcorp, WyTco
 */

class m000000_000032_np_warehouses extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('np_warehouses', [
            'id' => $this->primaryKey(),
            'name' => $this->text()->notNull(),
            'Ref' => $this->string(255)->notNull(),
            'CityRef' => $this->string(255)->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->Null(),
            'created_ip' => $this->string()->notNull(),
            'updated_ip' => $this->string()->Null(),
        ]);
    }

    public function down()
    {
        $this->dropTable('np_warehouses');
    }
}