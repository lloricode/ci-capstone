<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
 */
class Migration_Students extends CI_Migration
{


        const CI_DB_TABLE     = 'students';
        const CI_DB_TABLE_COL = 'student';

        public function __construct($config = array())
        {
                parent::__construct($config);
        }

        public function up()
        {
                $this->down();
                $fields = array(
                    self::CI_DB_TABLE_COL . '_id'                      => array(
                        'type'           => 'TINYINT',
                        'constraint'     => '11',
                        'unsigned'       => TRUE,
                        'auto_increment' => TRUE
                    ),
                    /**
                     * personal info
                     */
                    self::CI_DB_TABLE_COL . '_firstname'               => array(
                        'type'       => 'VARCHAR',
                        'constraint' => '50',
                    ),
                    self::CI_DB_TABLE_COL . '_middlename'              => array(
                        'type'       => 'VARCHAR',
                        'constraint' => '50',
                    ),
                    self::CI_DB_TABLE_COL . '_lastname'                => array(
                        'type'       => 'VARCHAR',
                        'constraint' => '50',
                    ),
                    self::CI_DB_TABLE_COL . '_gender'                  => array(
                        'type'       => 'VARCHAR',
                        'constraint' => '6',
                    ),
                    self::CI_DB_TABLE_COL . '_birthdate'               => array(
                        'type'       => 'VARCHAR',
                        'constraint' => '50',
                    ),
                    self::CI_DB_TABLE_COL . '_birthplace'              => array(
                        'type'       => 'VARCHAR',
                        'constraint' => '50',
                    ),
                    self::CI_DB_TABLE_COL . '_civil_status'            => array(//single,marriage
                        'type'       => 'VARCHAR',
                        'constraint' => '50',
                    ),
                    self::CI_DB_TABLE_COL . '_nationality'             => array(
                        'type'       => 'VARCHAR',
                        'constraint' => '50',
                    ),
                    /**
                     * contact info
                     */
                    #address
                    #######################
                    self::CI_DB_TABLE_COL . '_permanent_address'       => array(
                        'type'       => 'VARCHAR',
                        'constraint' => '250',
                    ),
                    self::CI_DB_TABLE_COL . '_address_town'            => array(
                        'type'       => 'VARCHAR',
                        'constraint' => '250',
                    ),
                    self::CI_DB_TABLE_COL . '_address_region'          => array(
                        'type'       => 'VARCHAR',
                        'constraint' => '250',
                    ),
                    self::CI_DB_TABLE_COL . '_guardian_address'        => array(
                        'type'       => 'VARCHAR',
                        'constraint' => '50',
                    ),
                    #######################
                    self::CI_DB_TABLE_COL . '_personal_contact_number' => array(
                        'type'       => 'VARCHAR',
                        'constraint' => '50',
                    ),
                    self::CI_DB_TABLE_COL . '_guardian_contact_number' => array(
                        'type'       => 'VARCHAR',
                        'constraint' => '50',
                    ),
                    self::CI_DB_TABLE_COL . '_personal_email'          => array(
                        'type'       => 'VARCHAR',
                        'constraint' => '50',
                    ),
                    self::CI_DB_TABLE_COL . '_guardian_email'          => array(
                        'type'       => 'VARCHAR',
                        'constraint' => '50',
                    ),
                    /**
                     * school info
                     */
                    self::CI_DB_TABLE_COL . '_school_id'               => array(
                        'type'       => 'VARCHAR',
                        'constraint' => '9',
                        'unique'     => TRUE
                    ),
                    self::CI_DB_TABLE_COL . '_year_level'              => array(
                        'type'       => 'INT',
                        'constraint' => '11',
                    ),
                    self::CI_DB_TABLE_COL . '_enrolled'                => array(
                        'type'       => 'TINYINT',
                        'constraint' => '1',
                    ),
                    /**
                     * other
                     */
                    self::CI_DB_TABLE_COL . '_active'                  => array(
                        'type'       => 'TINYINT',
                        'constraint' => '1',
                    ),
                    'course_id'                                        => array(
                        'type'       => 'INT',
                        'constraint' => '11',
                    ),
                    'created_at'                                       => array(
                        'type'       => 'VARCHAR',
                        'constraint' => '100',
                    ),
                    'deleted_at'                                       => array(
                        'type'       => 'VARCHAR',
                        'constraint' => '100',
                    ),
                    'updated_at'                                       => array(
                        'type'       => 'VARCHAR',
                        'constraint' => '100',
                    ),
                );


                $this->dbforge->add_field($fields);

                $this->dbforge->add_key(self::CI_DB_TABLE_COL . '_id', TRUE);
                $this->dbforge->create_table(self::CI_DB_TABLE);

                $this->add_sample_data();
        }

        /**
         * just generate sample data
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        private function add_sample_data()
        {
                $this->load->helper(array('string', 'date'));
                $this->load->library('school_id');

                /**
                 * 80 sample record
                 */
                for ($i = 1; $i < 80; $i++)
                {
                        $this->school_id->initialize(6, 5);

                        $data = array(
                            self::CI_DB_TABLE_COL . '_firstname'         => 'Firsname' . random_string('alpha', 3),
                            self::CI_DB_TABLE_COL . '_middlename'        => 'Middlename' . random_string('alpha', 3),
                            self::CI_DB_TABLE_COL . '_lastname'          => 'Lastname' . random_string('alpha', 3),
                            self::CI_DB_TABLE_COL . '_school_id'         => $this->school_id->generate(),
                            self::CI_DB_TABLE_COL . '_gender'            => ($i % 2 == 0) ? 'Male' : 'Female',
                            self::CI_DB_TABLE_COL . '_permanent_address' => 'addreee' . random_string('alnum', 3),
                            self::CI_DB_TABLE_COL . '_year_level'        => random_string('nozero', 1),
                            self::CI_DB_TABLE_COL . '_enrolled'          => (bool) (random_string('nozero', 1) % random_string('nozero', 1) == 0),
                            self::CI_DB_TABLE_COL . '_active'            => (bool) (random_string('nozero', 1) % random_string('nozero', 1) == 0),
                            'course_id'                                  => random_string('nozero', 1),
                            'created_at'                                 => my_datetime_format(),
                            'deleted_at'                                 => '',
                            'updated_at'                                 => ''
                        );

                        $this->db->insert(self::CI_DB_TABLE, $data);
                }
        }

        public function down()
        {
                $this->dbforge->drop_table(self::CI_DB_TABLE, TRUE);
        }

}
