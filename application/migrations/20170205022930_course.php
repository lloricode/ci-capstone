<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
 */
class Migration_Course extends CI_Migration
{


        const CI_DB_TABLE = 'courses';

        public function __construct($config = array())
        {
                parent::__construct($config);
        }

        public function up()
        {
                $this->down();
                $fields = array(
                    'course_id'          => array(
                        'type'           => 'TINYINT',
                        'constraint'     => '11',
                        'unsigned'       => TRUE,
                        'auto_increment' => TRUE
                    ),
                    'course_code'        => array(
                        'type'       => 'VARCHAR',
                        'constraint' => '50',
                        'unique'     => TRUE
                    ),
                    'course_description' => array(
                        'type'       => 'VARCHAR',
                        'constraint' => '50',
                    ),
                    'created_at'         => array(
                        'type'       => 'VARCHAR',
                        'constraint' => '100',
                    ),
                    'deleted_at'         => array(
                        'type'       => 'VARCHAR',
                        'constraint' => '100',
                    ),
                    'updated_at'         => array(
                        'type'       => 'VARCHAR',
                        'constraint' => '100',
                    ),
                );



                $this->dbforge->add_key('course_id', TRUE);

                $this->dbforge->add_field($fields);
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
                $this->load->model('Course_model');

                /**
                 * 80 sample record
                 */
                for ($i = 1; $i < 80; $i++)
                {
                        $data = array(
                            'course_code'        => 'c' . random_string('alpha', 3),
                            'course_description' => 'Desc' . random_string('alpha', 5)
                        );

                        $this->Course_model->insert($data);
                }
        }

        public function down()
        {
                $this->dbforge->drop_table(self::CI_DB_TABLE, TRUE);
        }

}
