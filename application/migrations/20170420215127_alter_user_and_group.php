<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
 */
class Migration_Alter_user_and_group extends CI_Migration
{


        private $table_users;
        private $table_groups;

        public function __construct($config = array())
        {
                parent::__construct($config);
                $this->config->load('ion_auth', TRUE);
                $tables = $this->config->item('tables', 'ion_auth');

                $this->table_users  = $tables['users'];
                $this->table_groups = $tables['groups'];
        }

        public function up()
        {
                $this->_users();
                $this->_groups();
        }

        private function _users()
        {
                /**
                 * add
                 */
                $fields = array(
                    'gen_code'   => array(
                        'type'       => 'VARCHAR',
                        'constraint' => '100',
                        'null'       => TRUE
                    ),
                    'updated_at' => array(
                        'type'       => 'int',
                        'constraint' => '11',
                        'unsigned'   => TRUE,
                        'null'       => TRUE
                    )
                );
                $this->dbforge->add_column($this->table_users, $fields);

                /**
                 * modify
                 */
                $this->db->query('ALTER TABLE `' . $this->table_users . '` ADD UNIQUE(`username`);');
                $this->db->query('ALTER TABLE `' . $this->table_users . '` CHANGE `email` `email` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL;');
                $this->db->query('ALTER TABLE `' . $this->table_users . '` ADD UNIQUE(`email`);');

                /**
                 * update password CI Login
                 */
                $this->db->set('password', '$2y$08$m8P3WHDASe.hDP4Jn6J9iut/YsshOKD3xuzuVpjiTKeFf146Mfgoi');
                $this->db->where('username', 'administrator');
                $this->db->update($this->table_users);
        }

        private function _groups()
        {
                $this->db->set('name', 'faculty');
                $this->db->where('name', 'members');
                $this->db->update($this->table_groups);
        }

}
