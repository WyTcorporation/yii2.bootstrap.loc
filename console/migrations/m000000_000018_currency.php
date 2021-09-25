<?php
/**
 * Create by: Vladislav Gladyr
 * Site: lockit.com.ua
 * Email: wild.savedo@gmail.com
 * Date : 12.09.2021
 * Time: 21:53
 * User: WyTcorporation
 */

class m000000_000018_currency extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('currency', [
            'id' => $this->primaryKey(),
            'name' => $this->string(32)->notNull(),
            'symbol' => $this->string(32)->notNull(),
            'code' => $this->string(3)->notNull(),
            'rate' => $this->float(11,2)->notNull(),
            'decimal_places' => $this->string(9)->defaultValue(2),
            'is_default' => $this->integer()->defaultValue(0),
            'sort' => $this->integer()->Null(),
            'status' => $this->integer()->Null(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->Null(),
            'created_by' => $this->integer()->notNull(),
            'updated_by' => $this->integer()->Null(),
            'created_ip' => $this->string()->notNull(),
            'updated_ip' => $this->string()->Null(),
        ]);

        $this->batchInsert('currency', [
            'name',
            'symbol',
            'code',
            'rate',
            'decimal_places',
            'is_default',
            'sort',
            'status',
            'created_at',
            'updated_at',
            'created_by',
            'updated_by',
            'created_ip'
        ], [
            [
                'Гривна',
                '₴',
                'UAH',
                1,
                '2',
                1,
                1,
                1,
                1632580945,
                1632580945,
                1,
                1,
                '127.0.0.1'
            ],
            [
                'Доллар',
                '$',
                'USD',
                27.3,
                '2',
                0,
                2,
                1,
                1632580986,
                1632580986,
                1,
                1,
                '127.0.0.1'
            ],
            [
                'Евро',
                '€',
                'EUR',
                32.4,
                '2',
                0,
                3,
                1,
                1632581057,
                1632581057,
                1,
                1,
                '127.0.0.1'
            ],
        ]);
    }

    public function down()
    {
        $this->dropTable('currency');
    }
}