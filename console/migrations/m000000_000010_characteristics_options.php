<?php
/**
 * Create by: Vladislav Gladyr
 * Site: lockit.com.ua
 * Email: wild.savedo@gmail.com
 * Date : 12.09.2021
 * Time: 22:28
 * User: WyTcorporation
 */

class m000000_000010_characteristics_options extends \yii\db\Migration
{
    public function up()
    {

        $this->createTable('characteristics_options', [
            'id' => $this->primaryKey(),
            'characteristics_id' => $this->integer()->notNull(),
            'content' => $this->integer()->Null(),
        ]);


        $this->addForeignKey('characteristics-options-id', 'characteristics_options', 'characteristics_id', 'characteristics', 'id', 'CASCADE', 'CASCADE');


    }

    public function down()
    {

        $this->dropTable('characteristics_options');

    }
}