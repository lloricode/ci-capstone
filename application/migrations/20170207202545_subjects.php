<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
 */
class Migration_Subjects extends CI_Migration
{


        const CI_DB_TABLE = 'subjects';

        public function __construct($config = array())
        {
                parent::__construct($config);
        }

        public function up()
        {
                $this->down();
                $fields = array(
                    'subject_id'          => array(
                        'type'           => 'TINYINT',
                        'constraint'     => '11',
                        'unsigned'       => TRUE,
                        'auto_increment' => TRUE
                    ),
                    'subject_code'        => array(
                        'type'       => 'VARCHAR',
                        'constraint' => '10',
                        'unique'     => TRUE
                    ),
                    'subject_description' => array(
                        'type'       => 'VARCHAR',
                        'constraint' => '50',
                        'unique'     => TRUE
                    ),
                    'subject_unit'        => array(
                        'type'       => 'INT',
                        'constraint' => '11',
                    ),
                    'course_id'           => array(
                        'type'       => 'INT',
                        'constraint' => '11',
                    ),
                    /**
                     * who add subject
                     */
                    'user_id'             => array(
                        'type'       => 'INT',
                        'constraint' => '11',
                    ),
                    'created_at'          => array(
                        'type'       => 'VARCHAR',
                        'constraint' => '100',
                    ),
                    'deleted_at'          => array(
                        'type'       => 'VARCHAR',
                        'constraint' => '100',
                    ),
                    'updated_at'          => array(
                        'type'       => 'VARCHAR',
                        'constraint' => '100',
                    ),
                );

                $this->dbforge->add_key('subject_id', TRUE);

                $this->dbforge->add_field($fields);
                $this->dbforge->create_table(self::CI_DB_TABLE);
        }

        public function down()
        {
                $this->dbforge->drop_table(self::CI_DB_TABLE, TRUE);
        }

}
