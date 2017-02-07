<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
 */
class Migration_Schedules extends CI_Migration
{


        const CI_DB_TABLE = 'schedules';

        public function __construct($config = array())
        {
                parent::__construct($config);
        }

        public function up()
        {
                $this->down();
                $fields = array(
                    'schedule_id'          => array(
                        'type'           => 'TINYINT',
                        'constraint'     => '11',
                        'unsigned'       => TRUE,
                        'auto_increment' => TRUE
                    ),
                    'schedule_room'        => array(
                        'type'       => 'VARCHAR',
                        'constraint' => '10',
                    ),
                    'schedule_start'       => array(
                        'type'       => 'VARCHAR',
                        'constraint' => '50',
                    ),
                    'schedule_end'         => array(
                        'type'       => 'VARCHAR',
                        'constraint' => '50',
                    ),
                    'schedule_semester'    => array(
                        'type'       => 'VARCHAR',
                        'constraint' => '10',
                    ),
                    'schedule_school_year' => array(
                        'type'       => 'VARCHAR',
                        'constraint' => '10',
                    ),
                    /**
                     * true if with this day
                     */
                    'schedule_monday'      => array(
                        'type'       => 'TINYINT',
                        'constraint' => '1',
                    ),
                    'schedule_tuesday'     => array(
                        'type'       => 'TINYINT',
                        'constraint' => '1',
                    ),
                    'schedule_wednesday'   => array(
                        'type'       => 'TINYINT',
                        'constraint' => '1',
                    ),
                    'schedule_thursday'    => array(
                        'type'       => 'TINYINT',
                        'constraint' => '1',
                    ),
                    'schedule_friday'      => array(
                        'type'       => 'TINYINT',
                        'constraint' => '1',
                    ),
                    'schedule_saturday'    => array(
                        'type'       => 'TINYINT',
                        'constraint' => '1',
                    ),
                    'schedule_sunday'      => array(
                        'type'       => 'TINYINT',
                        'constraint' => '1',
                    ),
                    /**
                     * faculty (who instructor assigned to teach this schedule)
                     */
                    'user_id'              => array(
                        'type'       => 'INT',
                        'constraint' => '11',
                    ),
                    /**
                     * other relations
                     */
                    'course_id'            => array(
                        'type'       => 'INT',
                        'constraint' => '11',
                    ),
                    'subject_id'           => array(
                        'type'       => 'INT',
                        'constraint' => '11',
                    ),
                    /**
                     * dates
                     */
                    'created_at'           => array(
                        'type'       => 'VARCHAR',
                        'constraint' => '100',
                    ),
                    'deleted_at'           => array(
                        'type'       => 'VARCHAR',
                        'constraint' => '100',
                    ),
                    'updated_at'           => array(
                        'type'       => 'VARCHAR',
                        'constraint' => '100',
                    ),
                );

                $this->dbforge->add_key('schedule_id', TRUE);

                $this->dbforge->add_field($fields);
                $this->dbforge->create_table(self::CI_DB_TABLE);
        }

        public function down()
        {
                $this->dbforge->drop_table(self::CI_DB_TABLE, TRUE);
        }

}
