<?php
/**
 * Create by: Vladislav Gladyr
 * Site: lockit.com.ua
 * Email: wild.savedo@gmail.com
 * Date : 12.09.2021
 * Time: 22:26
 * User: WyTcorporation
 */

class m000000_000015_content extends \yii\db\Migration
{
    public function up()
    {

        $this->createTable('content', [
            'id' => $this->primaryKey(),
            'content' => $this->string()->notNull(),
        ]);

        $this->batchInsert('content', ['content'],[
            ['name'],
            ['short_content'],
            ['content'],
            ['keywords'],
            ['description'],
        ]);

    }

    public function down()
    {
        $this->dropTable('content');
    }
}