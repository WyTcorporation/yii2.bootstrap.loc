<?php
/**
 * Create by: Vladislav Gladyr
 * Site: lockit.com.ua
 * Email: wild.savedo@gmail.com
 * Date : 12.09.2021
 * Time: 22:25
 * User: WyTcorporation
 */
class m000000_000016_type extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('type', [
            'id' => $this->primaryKey(),
            'type' => $this->string()->notNull(),
        ]);

        $this->batchInsert('type', ['type'],[
            ['categories'],
            ['products'],
            ['pages'],
            ['languages'],
            ['characteristics'],
            ['characteristics-options'],
            ['products-models'],
            ['options'],
            ['shop'],
            ['stock'],
            ['blog'],
            ['undefined'],
        ]);


    }

    public function down()
    {
        $this->dropTable('type');

    }
}