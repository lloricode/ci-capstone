<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
 */
class Migration_Students_subjects extends CI_Migration
{


        const CI_DB_TABLE = 'students_subjects';

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
                    'student_subject_id'            => array(
                        'type'           => 'INT',
                        'constraint'     => 8,
                        'unsigned'       => TRUE,
                        'null'           => FALSE,
                        'auto_increment' => TRUE
                    ),
                    'enrollment_id'                 => array(
                        'type'       => 'INT',
                        'constraint' => '11',
                        'null'       => FALSE
                    ),
                    'subject_offer_id'              => array(
                        'type'       => 'INT',
                        'constraint' => '11',
                        'null'       => FALSE
                    ),
                    'student_subject_enroll_status' => array(
                        'type'       => 'TINYINT',
                        'constraint' => '1',
                        'unsigned'   => TRUE,
                        'null'       => FAlSE,
                        'default'    => FALSE
                    ),
                    'student_subject_drop' => array(
                        'type'       => 'TINYINT',
                        'constraint' => '1',
                        'unsigned'   => TRUE,
                        'null'       => FAlSE,
                        'default'    => FALSE
                    ),
                    'curriculum_id'                 => array(//just incase, if student shift program, so it will dectect which curriculum
                        'type'       => 'INT',
                        'constraint' => '11',
                        'unsigned'   => TRUE,
                        'null'       => FALSE
                    ),
                    'curriculum_subject_id'         => array(//easy get units
                        'type'       => 'INT',
                        'constraint' => '11',
                        'unsigned'   => TRUE,
                        'null'       => FALSE
                    ),
                    /**
                     * to find when this enrolled, and easy find what current enrolled
                     */
                    'student_subject_semester'      => array(
                        'type' => 'ENUM(' . $this->_semesters() . ')',
                        'null' => FALSE
                    ),
                    'student_subject_school_year'   => array(
                        'type'       => 'VARCHAR',
                        'constraint' => '9',
                        'null'       => FALSE
                    ),
                    //------------------------------------
                    'created_at'                    => array(
                        'type'       => 'INT',
                        'constraint' => '11',
                        'null'       => FALSE
                    ),
                    'created_user_id'               => array(
                        'type'       => 'INT',
                        'constraint' => '11',
                        'unsigned'   => TRUE,
                        'null'       => FALSE
                    ),
                    'deleted_at'                    => array(
                        'type'       => 'INT',
                        'constraint' => '11',
                        'null'       => TRUE
                    ),
                    'deleted_user_id'               => array(
                        'type'       => 'INT',
                        'constraint' => '11',
                        'unsigned'   => TRUE,
                        'null'       => TRUE
                    ),
                    'updated_at'                    => array(
                        'type'       => 'INT',
                        'constraint' => '11',
                        'null'       => TRUE
                    ),
                    'updated_user_id'               => array(
                        'type'       => 'INT',
                        'constraint' => '11',
                        'unsigned'   => TRUE,
                        'null'       => TRUE
                    )
                );



                $this->dbforge->add_key('student_subject_id', TRUE);

                $this->dbforge->add_field($fields);
                $this->dbforge->create_table(self::CI_DB_TABLE, TRUE);
        }

        public function down()
        {
                $this->dbforge->drop_table(self::CI_DB_TABLE, TRUE);
        }

}
