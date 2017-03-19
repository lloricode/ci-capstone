<?php

defined('BASEPATH') or exit('No direct script access allowed');

class User_model extends MY_Model
{

        public function __construct()
        {
                $this->table       = 'users';
                $this->primary_key = 'id';

                $this->_relations();
                $this->_config();

                parent::__construct();
        }

        private function _config()
        {
                $this->timestamps        = TRUE; //(bool) $this->config->item('my_model_timestamps');
                $this->return_as         = 'object'; //$this->config->item('my_model_return_as');
                $this->timestamps_format = 'timestamp'; //$this->config->item('my_model_timestamps_format');


                $this->cache_driver         = 'file'; //$this->config->item('my_model_cache_driver');
                $this->cache_prefix         = 'cicapstone'; //$this->config->item('my_model_cache_prefix');
                /**
                 * some of field is not required, so remove it in array when no value, in inside the *->from_form()->insert() in core MY_Model,
                 */
                //  $this->remove_empty_before_write = TRUE;//(bool) $this->config->item('my_model_remove_empty_before_write');
                $this->delete_cache_on_save = TRUE; //(bool) $this->config->item('my_model_delete_cache_on_save');
        }

        private function _relations()
        {
//                $this->has_one['students_subjects'] = array(
//                    'foreign_model' => 'Students_subjects_model',
//                    'foreign_table' => 'students_subjects',
//                    'foreign_key'   => 'user_id',
//                    'local_key'     => 'id'
//                );
//                $this->has_one['subject_offers']    = array(
//                    'foreign_model' => 'Subject_offer_model',
//                    'foreign_table' => 'subject_offers',
//                    'foreign_key'   => 'subject_offer_id',
//                    'local_key'     => 'subject_offer_id'
//                );

                /**
                 * pivot
                 */
                // $this->has_many_pivot['...'] allows establishing MANY TO MANY or more MANY TO MANY relationship(s) between models/tables with the use of a PIVOT TABLE
                $this->has_many_pivot['groups'] = array(
                    'foreign_model'     => 'Group_model',
                    'pivot_table'       => 'users_groups',
                    'local_key'         => 'id',
                    'pivot_local_key'   => 'user_id', /* this is the related key in the pivot table to the local key
                      this is an optional key, but if your column name inside the pivot table
                      doesn't respect the format of "singularlocaltable_primarykey", then you must set it. In the next title
                      you will see how a pivot table should be set, if you want to  skip these keys */
                    'pivot_foreign_key' => 'group_id', /* this is also optional, the same as above, but for foreign table's keys */
                    'foreign_key'       => 'id',
                    'get_relate'        => FALSE /* another optional setting, which is explained below */
                );
                // or $this->has_many_pivot['posts'] = array('Posts_model','foreign_primary_key','local_primary_key');
                // ATTENTION! The pivot table name must be composed of the two table names separated by "_" the table names having to to be alphabetically ordered (NOT users_posts, but posts_users).
                // Also the pivot table must contain as identifying columns the columns named by convention as follows: table_name_singular + _ + foreign_table_primary_key.
                // For example: considering that a post can have multiple authors, a pivot table that connects two tables (users and posts) must be named posts_users and must have post_id and user_id as identifying columns for the posts.id and users.id tables.
        }

}
