<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
 */
class Migration_Language extends CI_Migration
{


        const CI_DB_TABLE = 'language';

        public function __construct($config = array())
        {
                parent::__construct($config);
        }

        public function up()
        {
                $this->down();
                $fields = array(
                    'language_id'    => array(
                        'type'           => 'TINYINT',
                        'constraint'     => '11',
                        'unsigned'       => TRUE,
                        'auto_increment' => TRUE
                    ),
                    'user_id'        => array(
                        'type'       => 'INT',
                        'constraint' => '11',
                    ),
                    'language_value' => array(
                        'type'       => 'VARCHAR',
                        'constraint' => '10',
                    ), 'created_at'     => array(
                        'type'       => 'VARCHAR',
                        'constraint' => '100',
                    ),
                    'deleted_at'     => array(
                        'type'       => 'VARCHAR',
                        'constraint' => '100',
                    ),
                    'updated_at'     => array(
                        'type'       => 'VARCHAR',
                        'constraint' => '100',
                    ),
                );

                $this->dbforge->add_key(self::CI_DB_TABLE . '_id', TRUE);
                $this->dbforge->add_field($fields);
                $this->dbforge->create_table(self::CI_DB_TABLE, TRUE);
        }

        public function down()
        {
                $this->dbforge->drop_table(self::CI_DB_TABLE, TRUE);
        }

}
