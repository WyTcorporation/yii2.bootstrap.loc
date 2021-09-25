<?php
/**
 * Create by: Vladislav Gladyr
 * Site: lockit.com.ua
 * Email: wild.savedo@gmail.com
 * Date : 12.09.2021
 * Time: 18:03
 * User: WyTcorporation
 */


class m000000_000019_options extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('options', [
            'id' => $this->primaryKey(),
            'type_id' => $this->integer()->notNull(),
            'content' => $this->text()->Null(),
            'active' => $this->integer()->defaultValue(0),
            'status' => $this->integer()->defaultValue(0),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->Null(),
            'created_by' => $this->integer()->notNull(),
            'updated_by' => $this->integer()->Null(),
            'created_ip' => $this->string()->notNull(),
            'updated_ip' => $this->string()->Null(),
        ]);

        $this->insert('options', [
            'type_id' => 4,
            'content' => '',
            'active' => 1,
            'status' => 1,
            'created_at'=>1631445738,
            'created_by'=>1,
            'created_ip'=>'127.0.0.1',
        ]);

        $this->addForeignKey('options-type-id', 'options', 'type_id', 'type', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('options');
    }
}