<?php
/**
 * Create by: Vladislav Gladyr
 * Site: lockit.com.ua
 * Email: wild.savedo@gmail.com
 * Date : 13.09.2021
 * Time: 07:01
 * User: WyTcorporation
 */


class m000000_000030_np_cities extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('np_cities', [
            'id' => $this->primaryKey(),
            'name' => $this->text()->notNull(),
            'Ref' => $this->string(255)->notNull(),
            'Region' => $this->string(255)->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->Null(),
            'created_ip' => $this->string()->notNull(),
            'updated_ip' => $this->string()->Null(),
        ]);
    }

    public function down()
    {
        $this->dropTable('np_cities');
    }
}