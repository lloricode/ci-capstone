<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
 */
class Migration_Enrollment_status extends CI_Migration
{


        const CI_DB_TABLE = 'enrollment_status';

        public function __construct($config = array())
        {
                parent::__construct($config);
        }

        public function up()
        {
                //$this->down();
                $fields = array(
                    'status'          => array(
                        'type'       => 'TINYINT',
                        'constraint' => '1',
                        'unsigned'   => TRUE,
                        'null'       => FAlSE
                    ),
                    //------------------------------------
                    'created_at'      => array(
                        'type'       => 'INT',
                        'constraint' => '11',
                        'null'       => FALSE
                    ),
                    'created_user_id' => array(
                        'type'       => 'INT',
                        'constraint' => '11',
                        'unsigned'   => TRUE,
                        'null'       => FALSE
                    )
                );

                $this->dbforge->add_field($fields);
                $this->dbforge->create_table(self::CI_DB_TABLE, TRUE);
        }

        public function down()
        {
                $this->dbforge->drop_table(self::CI_DB_TABLE, TRUE);
        }

}
