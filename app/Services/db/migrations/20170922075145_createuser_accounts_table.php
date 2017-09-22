<?php

use Phinx\Migration\AbstractMigration;

class CreateuserAccountsTable extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function up()
    {
        $users=$this->table('user_accounts');
        $users
            ->addColumn('user_id', 'integer')
            ->addColumn('provider', 'string', array('limit' => 50))
            ->addColumn('puid','string', array('limit' => 50)) //user id on provider
            ->addColumn('created_at', 'timestamp', array('default' => 'CURRENT_TIMESTAMP'))
            ->addColumn('updated_at', 'timestamp', array('null' => true))
            ->save();
    }
    public function down(){
        $this->dropTable('user_accounts');
    }
}
