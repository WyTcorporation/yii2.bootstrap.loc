<?php
/**
 * Create by: Vladislav Gladyr
 * Site: lockit.com.ua
 * Email: wild.savedo@gmail.com
 * Date : 13.09.2021
 * Time: 07:09
 * User: WyTcorporation, WyTcorp, WyTco
 */


class m000000_000029_notes extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('notes', [
            'id' => $this->primaryKey(),
            'text' => $this->text()->Null(),
            'date' => $this->integer()->notNull(),
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
        $this->dropTable('notes');
    }
}