<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
 */
class Migration_Subject_remove_unique_desc extends CI_Migration
{

        public function __construct($config = array())
        {
                parent::__construct($config);
        }

        public function up()
        {
                /**
                 * modify
                 */
                //$this->db->query('ALTER TABLE `subjects` REMOVE UNIQUE(`subject_description`);');

        }


}
