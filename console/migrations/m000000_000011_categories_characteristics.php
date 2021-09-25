<?php
/**
 * Create by: Vladislav Gladyr
 * Site: lockit.com.ua
 * Email: wild.savedo@gmail.com
 * Date : 12.09.2021
 * Time: 22:32
 * User: WyTcorporation
 */

class m000000_000011_categories_characteristics extends \yii\db\Migration
{
    public function up()
    {

        $this->createTable('categories_characteristics', [
            'id' => $this->primaryKey(),
            'categories_id' => $this->integer()->notNull(),
            'characteristics_id' => $this->integer()->notNull(),
        ]);


        $this->addForeignKey('categories-characteristics-categories-id', 'categories_characteristics', 'categories_id', 'categories', 'id', 'CASCADE', 'CASCADE');

        $this->addForeignKey('categories-characteristics-characteristics-id', 'categories_characteristics', 'characteristics_id', 'characteristics', 'id', 'CASCADE', 'CASCADE');

    }

    public function down()
    {
        $this->dropTable('categories_characteristics');
    }
}