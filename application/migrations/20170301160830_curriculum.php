<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
 */
class Migration_Curriculum extends CI_Migration
{


        const CI_DB_TABLE = 'curriculums';

        public function __construct($config = array())
        {
                parent::__construct($config);
        }

        public function up()
        {
                $this->down();
                $fields = array(
                    'curriculum_id'                    => array(
                        'type'           => 'INT',
                        'constraint'     => 8,
                        'unsigned'       => TRUE,
                        'null'           => FALSE,
                        'auto_increment' => TRUE
                    ),
                    'curriculum_description'           => array(
                        'type'       => 'VARCHAR',
                        'constraint' => '50',
                        'null'       => FALSE
                    ),
                    'curriculum_effective_school_year' => array(
                        'type'       => 'VARCHAR',
                        'constraint' => '9',
                        'null'       => FALSE
                    ),
                    'curriculum_effective_semester'    => array(
                        'type'       => 'VARCHAR',
                        'constraint' => '9',
                        'null'       => FALSE
                    ),
                    'curriculum_status'                => array(
                        'type'       => 'TINYINT',
                        'constraint' => '1',
                        'unsigned'   => TRUE,
                        'null'       => FAlSE,
                        'default'    => FALSE
                    ),
                    /**
                     * foreign
                     */
                    'course_id'                        => array(
                        'type'       => 'INT',
                        'constraint' => '11',
                        'unsigned'   => TRUE,
                        'null'       => FALSE
                    ),
                    //------------------------------------
                    'created_at'                       => array(
                        'type'       => 'VARCHAR',
                        'constraint' => '100',
                        'null'       => FALSE
                    ),
                    'created_user_id'                  => array(
                        'type'       => 'INT',
                        'constraint' => '11',
                        'unsigned'   => TRUE,
                        'null'       => FALSE
                    ),
                    'deleted_at'                       => array(
                        'type'       => 'VARCHAR',
                        'constraint' => '100',
                        'null'       => TRUE
                    ),
                    'deleted_user_id'                  => array(
                        'type'       => 'INT',
                        'constraint' => '11',
                        'unsigned'   => TRUE,
                        'null'       => TRUE
                    ),
                    'updated_at'                       => array(
                        'type'       => 'VARCHAR',
                        'constraint' => '100',
                        'null'       => TRUE
                    ),
                    'updated_user_id'                  => array(
                        'type'       => 'INT',
                        'constraint' => '11',
                        'unsigned'   => TRUE,
                        'null'       => TRUE
                    ),
                );



                $this->dbforge->add_key('curriculum_id', TRUE);

                $this->dbforge->add_field($fields);
                $this->dbforge->create_table(self::CI_DB_TABLE, TRUE);
        }

        public function down()
        {
                $this->dbforge->drop_table(self::CI_DB_TABLE, TRUE);
        }

}
