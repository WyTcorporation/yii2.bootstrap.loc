<?php
/**
 * Create by: Vladislav Gladyr
 * Site: lockit.com.ua
 * Email: wild.savedo@gmail.com
 * Date : 12.09.2021
 * Time: 09:07
 * User: WyTcorporation
 */

class m000000_000021_pages extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('pages', [
            'id' => $this->primaryKey(),
            'slug' => $this->string()->notNull(),
            'active' => $this->integer()->defaultValue(0),
            'status' => $this->integer()->defaultValue(0),
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
        $this->dropTable('pages');
    }
}