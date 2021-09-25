<?php
/**
 * Create by: Vladislav Gladyr
 * Site: lockit.com.ua
 * Email: wild.savedo@gmail.com
 * Date : 12.09.2021
 * Time: 22:23
 * User: WyTcorporation
 */

class m000000_000020_translations extends \yii\db\Migration
{
    public function up()
    {

        $this->createTable('translations', [
            'id' => $this->primaryKey(),
            'language_id' => $this->integer()->notNull(),
            'translation_id' => $this->integer()->notNull(),
            'type_id' => $this->integer()->notNull(),
            'content_id' => $this->integer()->notNull(),
            'content' => $this->text()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->Null(),
            'created_by' => $this->integer()->notNull(),
            'updated_by' => $this->integer()->Null(),
            'created_ip' => $this->string()->notNull(),
            'updated_ip' => $this->string()->Null(),
        ]);

        $this->batchInsert('translations', ['language_id','translation_id','type_id','content_id','content','created_at','created_by','created_ip'],[
            [1,1,5,1,'Бренд',1,1,1],
        ]);

        $this->addForeignKey('translation-user-id', 'translations', 'language_id', 'languages', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('translation-type-id', 'translations', 'type_id', 'type', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('translation-content-id', 'translations', 'content_id', 'content', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('translation');
    }
}