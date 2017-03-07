<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
 */
class Migration_Enrollments extends CI_Migration
{


        const CI_DB_TABLE = 'enrollments';

        public function __construct($config = array())
        {
                parent::__construct($config);
        }

        public function up()
        {
                $this->down();
                $fields = array(
                    'enrollment_id'          => array(
                        'type'           => 'INT',
                        'constraint'     => 8,
                        'unsigned'       => TRUE,
                        'null'           => FALSE,
                        'auto_increment' => TRUE
                    ),
                    'student_id'             => array(
                        'type'       => 'TINYINT',
                        'constraint' => '11',
                        'null'       => FALSE,
                        'unique'     => TRUE,
                    ),
                    'course_id'              => array(
                        'type'       => 'TINYINT',
                        'constraint' => '11',
                        'null'       => FALSE
                    ),
                    'curriculum_id'          => array(
                        'type'       => 'TINYINT',
                        'constraint' => '11',
                        'null'       => FALSE
                    ),
                    'enrollment_school_year' => array(
                        'type'       => 'VARCHAR',
                        'constraint' => '10',
                        'null'       => FALSE
                    ),
                    'enrollment_semester'    => array(
                        'type' => 'ENUM("first","second","summer")',
                        'null' => FALSE
                    ),
                    'enrollment_year_level'  => array(
                        'type'       => 'TINYINT',
                        'constraint' => '11',
                        'null'       => FALSE
                    ),
                    'enrollment_status'      => array(
                        'type'       => 'TINYINT',
                        'constraint' => '1',
                        'null'       => FALSE,
                        'default'    => FALSE
                    ),
                    //------------------------------------
                    'created_at'             => array(
                        'type'       => 'VARCHAR',
                        'constraint' => '100',
                        'null'       => FALSE
                    ),
                    'created_user_id'        => array(
                        'type'       => 'INT',
                        'constraint' => '11',
                        'unsigned'   => TRUE,
                        'null'       => FALSE
                    ),
                    'deleted_at'             => array(
                        'type'       => 'VARCHAR',
                        'constraint' => '100',
                        'null'       => TRUE
                    ),
                    'deleted_user_id'        => array(
                        'type'       => 'INT',
                        'constraint' => '11',
                        'unsigned'   => TRUE,
                        'null'       => TRUE
                    ),
                    'updated_at'             => array(
                        'type'       => 'VARCHAR',
                        'constraint' => '100',
                        'null'       => TRUE
                    ),
                    'updated_user_id'        => array(
                        'type'       => 'INT',
                        'constraint' => '11',
                        'unsigned'   => TRUE,
                        'null'       => TRUE
                    ),
                );



                $this->dbforge->add_key('enrollment_id', TRUE);

                $this->dbforge->add_field($fields);
                $this->dbforge->create_table(self::CI_DB_TABLE, TRUE);
        }

        public function down()
        {
                $this->dbforge->drop_table(self::CI_DB_TABLE, TRUE);
        }

}
