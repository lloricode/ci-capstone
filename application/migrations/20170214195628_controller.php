<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
 */
class Migration_Controller extends CI_Migration
{


        const CI_DB_TABLE = 'controllers';

        public function __construct($config = array())
        {
                parent::__construct($config);
        }

        /**
         * to prevent insert none controller
         * 
         * @return string
         */
        private function enum()
        {
                $return = '';
                foreach (controllers__() as $k => $controller)
                {
                        $return .= "\"$k\",";
                }

                /**
                 * plus empty for home
                 */
                $return .= "\"\",";

                return trim($return, ',');
        }

        public function up()
        {
                $this->down();
                $fields = array(
                    'controller_id'          => array(
                        'type'           => 'MEDIUMINT',
                        'constraint'     => 8,
                        'unsigned'       => TRUE,
                        'null'           => FALSE,
                        'auto_increment' => TRUE
                    ),
                    'controller_name'        => array(
                        'type'   => 'ENUM(' . $this->enum() . ')',
                        //let make it unique while data type in enum, so good so secure
                        'unique' => TRUE,
                        'null'   => FALSE
                    ),
                    'controller_description' => array(
                        'type'       => 'VARCHAR',
                        'constraint' => '50',
                        'null'       => FALSE
                    ),
                    'controller_admin_only'  => array(
                        'type'       => 'TINYINT',
                        'constraint' => '1',
                        'default'    => '0',
                        'null'       => FALSE
                    ),
                    'controller_enrollment_open'  => array(
                        'type'       => 'TINYINT',
                        'constraint' => '1',
                        'default'    => '0',
                        'null'       => FALSE
                    ),
                    //------------------------------------
                    'created_at'             => array(
                        'type'       => 'VARCHAR',
                        'constraint' => '100',
                        'null'       => FALSE
                    ),
                );



                $this->dbforge->add_key('controller_id', TRUE);

                $this->dbforge->add_field($fields);
                $this->dbforge->create_table(self::CI_DB_TABLE, TRUE);
        }

        public function down()
        {
                $this->dbforge->drop_table(self::CI_DB_TABLE, TRUE);
        }

}
