<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
 */
class Migration_Requisite extends CI_Migration
{


        const CI_DB_TABLE = 'requisites';

        public function __construct($config = array())
        {
                parent::__construct($config);
        }

        public function up()
        {
                $this->down();
                $fields = array(
                    'requisite_id'          => array(
                        'type'           => 'INT',
                        'constraint'     => 8,
                        'unsigned'       => TRUE,
                        'null'           => FALSE,
                        'auto_increment' => TRUE
                    ),
                    'requisite_type'        => array(
                        'type' => 'ENUM("co","pre")',
                        'null' => FALSE
                    ),
                    /**
                     * foreign
                     */
                    'curriculum_subject_id' => array(//main subject
                        'type'       => 'INT',
                        'constraint' => '11',
                        'unsigned'   => TRUE,
                        'null'       => FALSE
                    ),
                    'subject_id'            => array(//requsite subject
                        'type'       => 'INT',
                        'constraint' => '11',
                        'unsigned'   => TRUE,
                        'null'       => FALSE
                    ),
                    //------------------------------------
                    'created_at'            => array(
                        'type'       => 'INT',
                        'constraint' => '11',
                        'null'       => FALSE
                    ),
                    'created_user_id'       => array(
                        'type'       => 'INT',
                        'constraint' => '11',
                        'unsigned'   => TRUE,
                        'null'       => FALSE
                    ),
                    'deleted_at'            => array(
                        'type'       => 'INT',
                        'constraint' => '11',
                        'null'       => TRUE
                    ),
                    'deleted_user_id'       => array(
                        'type'       => 'INT',
                        'constraint' => '11',
                        'unsigned'   => TRUE,
                        'null'       => TRUE
                    ),
                    'updated_at'            => array(
                        'type'       => 'INT',
                        'constraint' => '11',
                        'null'       => TRUE
                    ),
                    'updated_user_id'       => array(
                        'type'       => 'INT',
                        'constraint' => '11',
                        'unsigned'   => TRUE,
                        'null'       => TRUE
                    )
                );



                $this->dbforge->add_key('requisite_id', TRUE);

                $this->dbforge->add_field($fields);
                $this->dbforge->create_table(self::CI_DB_TABLE, TRUE);
        }

        public function down()
        {
                $this->dbforge->drop_table(self::CI_DB_TABLE, TRUE);
        }

}
