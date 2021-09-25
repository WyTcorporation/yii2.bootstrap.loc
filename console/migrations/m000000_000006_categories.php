<?php
/**
 * Create by: Vladislav Gladyr
 * Site: lockit.com.ua
 * Email: wild.savedo@gmail.com
 * Date : 12.09.2021
 * Time: 19:27
 * User: WyTcorporation
 */

class m000000_000006_categories extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('categories', [
            'id' => $this->primaryKey(),
            'parent_id' => $this->integer()->Null(),
            'slug' => $this->string()->notNull()->unique(),
            'img' => $this->string()->defaultValue('no-image.png'),
            'gallery' => $this->text()->Null(),
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
        $this->dropTable('categories');
    }
}