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

        private function _semesters()
        {
                $return = '';
                $this->load->helper('school');
                foreach (semesters() as $k => $v)
                {
                        $return .= '"' . $k . '",';
                }
                return trim($return, ',');
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
                        'type'       => 'INT',
                        'constraint' => '11',
                        'null'       => FALSE,
                        'unique'     => TRUE,
                    ),
                    'course_id'              => array(
                        'type'       => 'INT',
                        'constraint' => '11',
                        'null'       => FALSE
                    ),
                    'curriculum_id'          => array(
                        'type'       => 'INT',
                        'constraint' => '11',
                        'null'       => FALSE
                    ),
                    'enrollment_school_year' => array(
                        'type'       => 'VARCHAR',
                        'constraint' => '10',
                        'null'       => TRUE
                    ),
                    'enrollment_semester'    => array(
                        'type' => 'ENUM(' . $this->_semesters() . ')',
                        'null' => TRUE
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
                        'type'       => 'INT',
                        'constraint' => '11',
                        'null'       => FALSE
                    ),
                    'created_user_id'        => array(
                        'type'       => 'INT',
                        'constraint' => '11',
                        'unsigned'   => TRUE,
                        'null'       => FALSE
                    ),
                    'deleted_at'             => array(
                        'type'       => 'INT',
                        'constraint' => '11',
                        'null'       => TRUE
                    ),
                    'deleted_user_id'        => array(
                        'type'       => 'INT',
                        'constraint' => '11',
                        'unsigned'   => TRUE,
                        'null'       => TRUE
                    ),
                    'updated_at'             => array(
                        'type'       => 'INT',
                        'constraint' => '11',
                        'null'       => TRUE
                    ),
                    'updated_user_id'        => array(
                        'type'       => 'INT',
                        'constraint' => '11',
                        'unsigned'   => TRUE,
                        'null'       => TRUE
                    )
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
