<?php
/**
 * Create by: Vladislav Gladyr
 * Site: lockit.com.ua
 * Email: wild.savedo@gmail.com
 * Date : 20.09.2021
 * Time: 20:54
 * User: WyTcorporation, WyTcorp, WyTco
 */

class m000000_000035_blog extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('blog', [
            'id' => $this->primaryKey(),
            'slug' => $this->string(255)->notNull(),
            'active' => $this->integer()->Null(),
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
        $this->dropTable('blog');
    }
}