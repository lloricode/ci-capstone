<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
 */
class Migration_Alter_user extends CI_Migration
{


        private $table;

        public function __construct($config = array())
        {
                parent::__construct($config);
                $this->config->load('ion_auth', TRUE);
                $tables = $this->config->item('tables', 'ion_auth');

                $this->table = $tables['users'];
        }

        public function up()
        {
                $fields = array(
                    'session_id' => array(
                        'type'       => 'VARCHAR',
                        'constraint' => '100',
                        'null'       => TRUE
                    ),
                );
                $this->dbforge->add_column($this->table, $fields);
        }

}
