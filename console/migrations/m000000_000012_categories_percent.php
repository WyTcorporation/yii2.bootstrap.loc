<?php
/**
 * Create by: Vladislav Gladyr
 * Site: lockit.com.ua
 * Email: wild.savedo@gmail.com
 * Date : 12.09.2021
 * Time: 22:31
 * User: WyTcorporation
 */
class m000000_000012_categories_percent extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('categories_percent', [
            'id' => $this->primaryKey(),
            'categories_id' => $this->integer()->notNull(),
            'role' => $this->integer()->notNull(),
            'content' => $this->string()->notNull(),
        ]);

        $this->addForeignKey('categories-percent-id', 'categories_percent', 'categories_id', 'categories', 'id', 'CASCADE', 'CASCADE');


    }

    public function down()
    {
        $this->dropTable('categories_percent');
    }
}