<?php
/**
 * Create by: Vladislav Gladyr
 * Site: lockit.com.ua
 * Email: wild.savedo@gmail.com
 * Date : 13.09.2021
 * Time: 07:13
 * User: WyTcorporation, WyTcorp, WyTco
 */

class m000000_000031_np_region extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('np_region', [
            'id' => $this->primaryKey(),
            'name' => $this->text()->notNull(),
            'Ref' => $this->string(255)->notNull(),
            'AreasCenter' => $this->string(255)->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->Null(),
            'created_ip' => $this->string()->notNull(),
            'updated_ip' => $this->string()->Null(),
        ]);
    }

    public function down()
    {
        $this->dropTable('np_region');
    }
}