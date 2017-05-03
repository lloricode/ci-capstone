<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
 */
class Migration_Unit extends CI_Migration
{


        const CI_DB_TABLE = 'units';

        public function __construct($config = array())
        {
                parent::__construct($config);
        }

        public function up()
        {
                $this->down();
                $fields = array(
                    'unit_id'         => array(
                        'type'           => 'INT',
                        'constraint'     => 11,
                        'unsigned'       => TRUE,
                        'null'           => FALSE,
                        'auto_increment' => TRUE
                    ),
                    'unit_value'      => array(
                        'type'       => 'INT',
                        'constraint' => '2',
                        'unsigned'   => TRUE,
                        'null'       => FALSE
                    ),
                    'lec_value'       => array(
                        'type'       => 'INT',
                        'constraint' => '2',
                        'unsigned'   => TRUE,
                        'null'       => FALSE
                    ),
                    'lab_value'       => array(
                        'type'       => 'INT',
                        'constraint' => '2',
                        'unsigned'   => TRUE,
                        'null'       => FALSE
                    ),
                    /**
                     * who add subject
                     */
                    //------------------------------------
                    'created_at'      => array(
                        'type'       => 'INT',
                        'constraint' => '11',
                        'null'       => FALSE
                    ),
                    'created_user_id' => array(
                        'type'       => 'INT',
                        'constraint' => '11',
                        'unsigned'   => TRUE,
                        'null'       => FALSE
                    ),
                    'deleted_at'      => array(
                        'type'       => 'INT',
                        'constraint' => '11',
                        'null'       => TRUE
                    ),
                    'deleted_user_id' => array(
                        'type'       => 'INT',
                        'constraint' => '11',
                        'unsigned'   => TRUE,
                        'null'       => TRUE
                    ),
                    'updated_at'      => array(
                        'type'       => 'INT',
                        'constraint' => '11',
                        'null'       => TRUE
                    ),
                    'updated_user_id' => array(
                        'type'       => 'INT',
                        'constraint' => '11',
                        'unsigned'   => TRUE,
                        'null'       => TRUE
                    )
                );

                $this->dbforge->add_key('unit_id', TRUE);

                $this->dbforge->add_field($fields);
                $this->dbforge->create_table(self::CI_DB_TABLE, TRUE);
        }

        public function down()
        {
                $this->dbforge->drop_table(self::CI_DB_TABLE, TRUE);
        }

}
