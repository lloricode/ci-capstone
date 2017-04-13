<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
 */
class Migration_Users_last_login extends CI_Migration
{


        const CI_DB_TABLE = 'users_last_logins';

        public function __construct($config = array())
        {
                parent::__construct($config);
        }

        public function up()
        {
                $this->down();
                $fields = array(
                    'users_last_login_id' => array(
                        'type'           => 'INT',
                        'constraint'     => 8,
                        'unsigned'       => TRUE,
                        'null'           => FALSE,
                        'auto_increment' => TRUE
                    ),
                    'user_id'             => array(
                        'type'       => 'INT',
                        'constraint' => '11',
                        'null'       => FALSE
                    ),
                    'ip_address'          => array(
                        'type'       => 'VARBINARY',
                        'constraint' => '16',
                        'null'       => FALSE
                    ),
                    'agent'               => array(
                        'type'       => 'VARCHAR',
                        'constraint' => '100',
                        'null'       => FALSE
                    ),
                    'platform'            => array(
                        'type'       => 'VARCHAR',
                        'constraint' => '100',
                        'null'       => FALSE
                    ),
                    //------------------------------------
                    'created_at'          => array(
                        'type'       => 'INT',
                        'constraint' => '11',
                        'null'       => FALSE
                    )
                );



                $this->dbforge->add_key('users_last_login_id', TRUE);

                $this->dbforge->add_field($fields);
                $this->dbforge->create_table(self::CI_DB_TABLE, TRUE);
        }

        public function down()
        {
                $this->dbforge->drop_table(self::CI_DB_TABLE, TRUE);
        }

}
