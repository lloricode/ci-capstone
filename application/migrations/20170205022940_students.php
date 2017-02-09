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
                        'null'       => FALSE
                    ),
                    self::CI_DB_TABLE_COL . 'middlename'              => array(
                        'type'       => 'VARCHAR',
                        'constraint' => '50',
                        'null'       => FALSE
                    ),
                    self::CI_DB_TABLE_COL . 'lastname'                => array(
                        'type'       => 'VARCHAR',
                        'constraint' => '50',
                        'null'       => FALSE
                    ),
                    self::CI_DB_TABLE_COL . 'gender'                  => array(
                        'type' => 'ENUM("male","female")',
                        'null' => FALSE
                    ),
                    self::CI_DB_TABLE_COL . 'birthdate'               => array(
                        'type'       => 'VARCHAR',
                        'constraint' => '50',
                        'null'       => FALSE
                    ),
                    self::CI_DB_TABLE_COL . 'birthplace'              => array(
                        'type'       => 'VARCHAR',
                        'constraint' => '50',
                        'null'       => FALSE
                    ),
                    self::CI_DB_TABLE_COL . 'civil_status'            => array(
                        'type'       => 'VARCHAR',
                        'constraint' => '50',
                        'null'       => FALSE
                    ),
                    self::CI_DB_TABLE_COL . 'nationality'             => array(
                        'type'       => 'VARCHAR',
                        'constraint' => '50',
                        'null'       => FALSE
                    ),
                    /**
                     * contact info
                     */
                    #address
                    #######################
                    self::CI_DB_TABLE_COL . 'guardian_fullname'       => array(
                        'type'       => 'VARCHAR',
                        'constraint' => '50',
                        'null'       => FALSE
                    ),
                    self::CI_DB_TABLE_COL . 'permanent_address'       => array(
                        'type'       => 'VARCHAR',
                        'constraint' => '250',
                        'null'       => FALSE
                    ),
                    self::CI_DB_TABLE_COL . 'address_town'            => array(
                        'type'       => 'VARCHAR',
                        'constraint' => '250',
                        'null'       => FALSE
                    ),
                    self::CI_DB_TABLE_COL . 'address_region'          => array(
                        'type'       => 'VARCHAR',
                        'constraint' => '250',
                        'null'       => FALSE
                    ),
                    self::CI_DB_TABLE_COL . 'guardian_address'        => array(
                        'type'       => 'VARCHAR',
                        'constraint' => '50',
                        'null'       => FALSE
                    ),
                    #number/emails
                    #######################
                    self::CI_DB_TABLE_COL . 'personal_contact_number' => array(
                        'type'       => 'VARCHAR',
                        'constraint' => '50',
                        'null'       => FALSE
                    ),
                    self::CI_DB_TABLE_COL . 'guardian_contact_number' => array(
                        'type'       => 'VARCHAR',
                        'constraint' => '50',
                        'null'       => FALSE
                    ),
                    self::CI_DB_TABLE_COL . 'personal_email'          => array(
                        'type'       => 'VARCHAR',
                        'constraint' => '50',
                        'null'       => FALSE,
                        'unique'     => TRUE,
                    ),
                    self::CI_DB_TABLE_COL . 'guardian_email'          => array(
                        'type'       => 'VARCHAR',
                        'constraint' => '50',
                        'null'       => FALSE
                    ),
                    /**
                     * school info
                     */
                    self::CI_DB_TABLE_COL . 'school_id'               => array(
                        'type'       => 'VARCHAR',
                        'constraint' => '9',
                        'unique'     => TRUE,
                        'null'       => FALSE
                    ),
                    //------------------------------------
                    'created_at'                                      => array(
                        'type'       => 'VARCHAR',
                        'constraint' => '100',
                        'null'       => FALSE
                    ),
                    'created_user_id'                                 => array(
                        'type'       => 'INT',
                        'constraint' => '11',
                        'null'       => FALSE
                    ),
                    'deleted_at'                                      => array(
                        'type'       => 'VARCHAR',
                        'constraint' => '100',
                        'null'       => TRUE
                    ),
                    'delete_user_id'                                  => array(
                        'type'       => 'INT',
                        'constraint' => '11',
                        'null'       => TRUE
                    ),
                    'updated_at'                                      => array(
                        'type'       => 'VARCHAR',
                        'constraint' => '100',
                        'null'       => TRUE
                    ),
                    'update_user_id'                                  => array(
                        'type'       => 'INT',
                        'constraint' => '11',
                        'null'       => TRUE
                    ),
                );


                $this->dbforge->add_field($fields);

                $this->dbforge->add_key(self::CI_DB_TABLE_COL . 'id', TRUE);
                $this->dbforge->create_table(self::CI_DB_TABLE, TRUE);
        }

        public function down()
        {
                $this->dbforge->drop_table(self::CI_DB_TABLE, TRUE);
        }

}
