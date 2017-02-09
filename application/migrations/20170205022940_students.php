<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
 */
class Migration_Students extends CI_Migration
{


        const CI_DB_TABLE     = 'students';
        const CI_DB_TABLE_COL = 'student_';

        public function __construct($config = array())
        {
                parent::__construct($config);
        }

        public function up()
        {
                $this->down();
                $fields = array(
                    self::CI_DB_TABLE_COL . 'id'                      => array(
                        'type'           => 'TINYINT',
                        'constraint'     => '11',
                        'unsigned'       => TRUE,
                        'auto_increment' => TRUE
                    ),
                    /**
                     * personal info
                     */
                    self::CI_DB_TABLE_COL . 'firstname'               => array(
                        'type'       => 'VARCHAR',
                        'constraint' => '50',
                    ),
                    self::CI_DB_TABLE_COL . 'middlename'              => array(
                        'type'       => 'VARCHAR',
                        'constraint' => '50',
                    ),
                    self::CI_DB_TABLE_COL . 'lastname'                => array(
                        'type'       => 'VARCHAR',
                        'constraint' => '50',
                    ),
                    self::CI_DB_TABLE_COL . 'gender'                  => array(
                        'type'       => 'VARCHAR',
                        'constraint' => '6',
                    ),
                    self::CI_DB_TABLE_COL . 'birthdate'               => array(
                        'type'       => 'VARCHAR',
                        'constraint' => '50',
                    ),
                    self::CI_DB_TABLE_COL . 'birthplace'              => array(
                        'type'       => 'VARCHAR',
                        'constraint' => '50',
                    ),
                    self::CI_DB_TABLE_COL . 'civil_status'            => array(//single,marriage
                        'type'       => 'VARCHAR',
                        'constraint' => '50',
                    ),
                    self::CI_DB_TABLE_COL . 'nationality'             => array(
                        'type'       => 'VARCHAR',
                        'constraint' => '50',
                    ),
                    /**
                     * contact info
                     */
                    #address
                    #######################
                    self::CI_DB_TABLE_COL . 'guardian_fullname'       => array(
                        'type'       => 'VARCHAR',
                        'constraint' => '50',
                    ),
                    self::CI_DB_TABLE_COL . 'permanent_address'       => array(
                        'type'       => 'VARCHAR',
                        'constraint' => '250',
                    ),
                    self::CI_DB_TABLE_COL . 'address_town'            => array(
                        'type'       => 'VARCHAR',
                        'constraint' => '250',
                    ),
                    self::CI_DB_TABLE_COL . 'address_region'          => array(
                        'type'       => 'VARCHAR',
                        'constraint' => '250',
                    ),
                    self::CI_DB_TABLE_COL . 'guardian_address'        => array(
                        'type'       => 'VARCHAR',
                        'constraint' => '50',
                    ),
                    #number/emails
                    #######################
                    self::CI_DB_TABLE_COL . 'personal_contact_number' => array(
                        'type'       => 'VARCHAR',
                        'constraint' => '50',
                    ),
                    self::CI_DB_TABLE_COL . 'guardian_contact_number' => array(
                        'type'       => 'VARCHAR',
                        'constraint' => '50',
                    ),
                    self::CI_DB_TABLE_COL . 'personal_email'          => array(
                        'type'       => 'VARCHAR',
                        'constraint' => '50',
                    ),
                    self::CI_DB_TABLE_COL . 'guardian_email'          => array(
                        'type'       => 'VARCHAR',
                        'constraint' => '50',
                    ),
                    /**
                     * school info
                     */
                    self::CI_DB_TABLE_COL . 'school_id'               => array(
                        'type'       => 'VARCHAR',
                        'constraint' => '9',
                        'unique'     => TRUE
                    ),
                    self::CI_DB_TABLE_COL . 'year_level'              => array(
                        'type'       => 'INT',
                        'constraint' => '11',
                    ),
                    self::CI_DB_TABLE_COL . 'enrolled'                => array(
                        'type'       => 'TINYINT',
                        'constraint' => '1',
                        'default'    => FALSE
                    ),
                    /**
                     * other
                     */
                    self::CI_DB_TABLE_COL . 'active'                  => array(
                        'type'       => 'TINYINT',
                        'constraint' => '1',
                        'default'    => FALSE
                    ),
                    'course_id'                                       => array(
                        'type'       => 'INT',
                        'constraint' => '11',
                    ),
                    'created_at'                                      => array(
                        'type'       => 'VARCHAR',
                        'constraint' => '100',
                    ),
                    'deleted_at'                                      => array(
                        'type'       => 'VARCHAR',
                        'constraint' => '100',
                    ),
                    'updated_at'                                      => array(
                        'type'       => 'VARCHAR',
                        'constraint' => '100',
                    ),
                );


                $this->dbforge->add_field($fields);

                $this->dbforge->add_key(self::CI_DB_TABLE_COL . 'id', TRUE);
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
                $this->load->model('Student_model');

                /**
                 * 80 sample record
                 */
                for ($i = 1; $i < 80; $i++)
                {
                        $this->school_id->initialize(6, 5);

                        $data = array(
                            self::CI_DB_TABLE_COL . 'firstname'               => 'Firsname' . random_string('alpha', 3),
                            self::CI_DB_TABLE_COL . 'middlename'              => 'Middlename' . random_string('alpha', 3),
                            self::CI_DB_TABLE_COL . 'lastname'                => 'Lastname' . random_string('alpha', 3),
                            self::CI_DB_TABLE_COL . 'school_id'               => $this->school_id->generate(),
                            self::CI_DB_TABLE_COL . 'gender'                  => ($i % 2 == 0) ? 'Male' : 'Female',
                            self::CI_DB_TABLE_COL . 'permanent_address'       => ' permanent addreee' . random_string('alnum', 3),
                            self::CI_DB_TABLE_COL . 'birthdate'               => '0' . random_string('nozero', 1) . '-2' . random_string('nozero', 1) . '-19' . random_string('nozero', 2),
                            self::CI_DB_TABLE_COL . 'year_level'              => random_string('nozero', 1),
                            self::CI_DB_TABLE_COL . 'enrolled'                => (bool) (random_string('nozero', 1) % random_string('nozero', 1) == 0),
                            self::CI_DB_TABLE_COL . 'active'                  => (bool) (random_string('nozero', 1) % random_string('nozero', 1) == 0),
                            'course_id'                                       => random_string('nozero', 1),
                            self::CI_DB_TABLE_COL . 'address_town'            => 'Town' . random_string('alpha', 3),
                            self::CI_DB_TABLE_COL . 'address_region'          => 'Region' . random_string('alpha', 3),
                            self::CI_DB_TABLE_COL . 'personal_contact_number' => '+639' . random_string('numeric', 2) . '-' . random_string('numeric', 4) . '-' . random_string('numeric', 3),
                            self::CI_DB_TABLE_COL . 'personal_email'          => random_string('alnum', 15) . '@' . random_string('alpha', 3) . '.' . random_string('alpha', 3),
                        );

                        $this->Student_model->insert($data);
                }
        }

        public function down()
        {
                $this->dbforge->drop_table(self::CI_DB_TABLE, TRUE);
        }

}
