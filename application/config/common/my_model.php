<?php

/*
  |
  | ----------------------------------------------
  |                   MY_MODEL
  | ----------------------------------------------
  |
  |
 */

/**
 * formats
 */
$config['my_model_timestamps']        = TRUE;
$config['my_model_return_as']         = 'object';
$config['my_model_timestamps_format'] = 'timestamp';

/**
 * insert behavior
 */
$config['my_model_remove_empty_before_write'] = TRUE;
/**
 * database cache
 */
/**
 * comment by :@avenerir 
 * @link https://github.com/avenirer
 */
//By default, MY_Model uses the files (CodeIgniter's file driver) to cache result. If you want to change the way it stores the cache, you can change the $cache_driver property to whatever CodeIgniter cache driver you want to use.
$config['my_model_cache_driver']              = 'file';
//With $cache_prefix, you can prefix the name of the caches. By default any cache made by MY_Model starts with 'mm' + _ + "name chosen for cache"
$config['my_model_cache_prefix']              = 'cicapstone';
//  If you use caching often and you don't want to be forced to delete cache manually, you can enable $this->delete_cache_on_save by setting it to TRUE. If set to TRUE the model will auto-delete all cache related to the model's table whenever you write/update/delete data from that table.
$config['my_model_delete_cache_on_save']      = TRUE;
