<?php
/**
 * Create by: Vladislav Gladyr
 * Site: lockit.com.ua
 * Email: wild.savedo@gmail.com
 * Date : 12.09.2021
 * Time: 20:42
 * User: WyTcorporation
 */

class m000000_000008_characteristics extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('characteristics', [
            'id' => $this->primaryKey(),
            'filter_status' => $this->integer()->defaultValue(0),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->Null(),
            'created_by' => $this->integer()->notNull(),
            'updated_by' => $this->integer()->Null(),
            'created_ip' => $this->string()->notNull(),
            'updated_ip' => $this->string()->Null(),
        ]);

        $this->batchInsert('characteristics', ['filter_status','created_at','created_by','created_ip'],[
            ['1','1','1','1'],
        ]);

    }

    public function down()
    {
        $this->dropTable('characteristics');

    }
}