<?php
/**
 * Create by: Vladislav Gladyr
 * Site: lockit.com.ua
 * Email: wild.savedo@gmail.com
 * Date : 20.09.2021
 * Time: 10:31
 * User: WyTcorporation, WyTcorp, WyTco
 */

class m000000_000034_stock extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('stock', [
            'id' => $this->primaryKey(),
            'banner' => $this->text()->Null(),
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
        $this->dropTable('stock');
    }
}