<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
 */
class Migration_Subject_offer_line extends CI_Migration
{


        const CI_DB_TABLE = 'subject_offer_line';

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
                    'subject_offer_line_id'        => array(
                        'type'           => 'INT',
                        'constraint'     => 8,
                        'unsigned'       => TRUE,
                        'null'           => FALSE,
                        'auto_increment' => TRUE
                    ),
                    'subject_offer_line_start'     => array(
                        'type' => 'TIME',
                        'null' => FALSE
                    ),
                    'subject_offer_line_end'       => array(
                        'type' => 'TIME',
                        'null' => FALSE
                    ),
                    /**
                     * true if with this day
                     */
                    'subject_offer_line_monday'    => array(
                        'type'       => 'TINYINT',
                        'constraint' => '1',
                        'default'    => '0',
                        'null'       => FALSE
                    ),
                    'subject_offer_line_tuesday'   => array(
                        'type'       => 'TINYINT',
                        'constraint' => '1',
                        'default'    => '0',
                        'null'       => FALSE
                    ),
                    'subject_offer_line_wednesday' => array(
                        'type'       => 'TINYINT',
                        'constraint' => '1',
                        'default'    => '0',
                        'null'       => FALSE
                    ),
                    'subject_offer_line_thursday'  => array(
                        'type'       => 'TINYINT',
                        'constraint' => '1',
                        'default'    => '0',
                        'null'       => FALSE
                    ),
                    'subject_offer_line_friday'    => array(
                        'type'       => 'TINYINT',
                        'constraint' => '1',
                        'default'    => '0',
                        'null'       => FALSE
                    ),
                    'subject_offer_line_saturday'  => array(
                        'type'       => 'TINYINT',
                        'constraint' => '1',
                        'default'    => '0',
                        'null'       => FALSE
                    ),
                    'subject_offer_line_sunday'    => array(
                        'type'       => 'TINYINT',
                        'constraint' => '1',
                        'default'    => '0',
                        'null'       => FALSE
                    ),
                    /**
                     * TYPE
                     */
                    'subject_offer_line_lec'       => array(
                        'type'       => 'TINYINT',
                        'constraint' => '1',
                        'default'    => '0',
                        'null'       => FALSE
                    ),
                    'subject_offer_line_lab'       => array(
                        'type'       => 'TINYINT',
                        'constraint' => '1',
                        'default'    => '0',
                        'null'       => FALSE
                    ),
                    /**
                     * faculty (who instructor assigned to teach this subject_offer)
                     */
                    /**
                     * other relations
                     */
                    'subject_offer_id'             => array(
                        'type'       => 'INT',
                        'constraint' => '11',
                        'unsigned'   => TRUE,
                        'null'       => FALSE
                    ),
                    //----------------------------------------------xxxxx
                    'user_id'                      => array(
                        'type'       => 'INT',
                        'constraint' => '11',
                        'unsigned'   => TRUE,
                        'null'       => FALSE
                    ),
                    'subject_id'                   => array(
                        'type'       => 'INT',
                        'constraint' => '11',
                        'unsigned'   => TRUE,
                        'null'       => FALSE
                    ),
                    'room_id'                      => array(
                        'type'       => 'INT',
                        'constraint' => '11',
                        'unsigned'   => TRUE,
                        'null'       => FALSE
                    ),
                    'subject_offer_semester'       => array(
                        'type' => 'ENUM(' . $this->_semesters() . ')',
                        'null' => FALSE
                    ),
                    'subject_offer_school_year'    => array(
                        'type'       => 'VARCHAR',
                        'constraint' => '9',
                        'null'       => FALSE
                    ),
                    /**
                     * dates
                     */
                    //------------------------------------
                    'created_at'                   => array(
                        'type'       => 'INT',
                        'constraint' => '11',
                        'null'       => FALSE
                    ),
                    'created_user_id'              => array(
                        'type'       => 'INT',
                        'constraint' => '11',
                        'unsigned'   => TRUE,
                        'null'       => FALSE
                    ),
                    'deleted_at'                   => array(
                        'type'       => 'INT',
                        'constraint' => '11',
                        'null'       => TRUE
                    ),
                    'deleted_user_id'              => array(
                        'type'       => 'INT',
                        'constraint' => '11',
                        'unsigned'   => TRUE,
                        'null'       => TRUE
                    ),
                    'updated_at'                   => array(
                        'type'       => 'INT',
                        'constraint' => '11',
                        'null'       => TRUE
                    ),
                    'updated_user_id'              => array(
                        'type'       => 'INT',
                        'constraint' => '11',
                        'unsigned'   => TRUE,
                        'null'       => TRUE
                    )
                );

                $this->dbforge->add_key('subject_offer_line_id', TRUE);

                $this->dbforge->add_field($fields);
                $this->dbforge->create_table(self::CI_DB_TABLE, TRUE);
        }

        public function down()
        {
                $this->dbforge->drop_table(self::CI_DB_TABLE, TRUE);
        }

}
