<?php
/**
 * Create by: Vladislav Gladyr
 * Site: lockit.com.ua
 * Email: wild.savedo@gmail.com
 * Date : 12.09.2021
 * Time: 09:07
 * User: WyTcorporation
 */

class m000000_000017_language extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('languages', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()->unique(),
            'code' => $this->string()->notNull()->unique(),
            'active' => $this->integer()->defaultValue(0),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->Null(),
            'created_by' => $this->integer()->notNull(),
            'updated_by' => $this->integer()->Null(),
            'created_ip' => $this->string()->notNull(),
            'updated_ip' => $this->string()->Null(),
        ]);

        $this->batchInsert('languages', ['name', 'code', 'active', 'created_at', 'created_by', 'created_ip'], [
            ['Русский', 'ru', 1, 1631445738, 1, '127.0.0.1'],
            ['Українська', 'ua', 1, 1631445738, 1, '127.0.0.1'],
            ['English', 'en', 1, 1631445738, 1, '127.0.0.1'],
        ]);
    }

    public function down()
    {
        $this->dropTable('languages');
    }
}