<?php

defined('BASEPATH') or exit('no direct script allowed');

if (!function_exists('my_day'))
{

        /**
         * 
         * @return String Sun,Mon
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        function my_day()
        {
                $time = time();
                return mdate('%D', $time);
        }

}

if (!function_exists('days'))
{

        /**
         * 
         * @param type $row
         * @return string
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        function days($row)
        {
                $d    = array(
                    'm'  => 'M',
                    't'  => 'T',
                    'w'  => 'W',
                    'th' => 'TH',
                    'f'  => 'F',
                    's'  => 'Sat',
                    'su' => 'Sun',
                );
                $days = '';
                foreach ($d AS $k => $v)
                {
                        $tmp = 'schedule_' . $k;
                        if ($row->$tmp)
                        {
                                $days .= $v;
                        }
                }
                if ($days == '')
                {
                        $days = '--';
                }
                return $days;
        }

}
if (!function_exists('days_for_db'))
{

        /**
         * note: don't use LANG, this is use for table
         * @return type
         */
        function days_for_db()
        {
                return array(
                    'Sun' => 'sunday',
                    'M'   => 'monday',
                    'T'   => 'tuesday',
                    'W'   => 'wednesday',
                    'TH'  => 'thursday',
                    'F'   => 'friday',
                    'Sat' => 'saturday'
                );
        }

}
if (!function_exists('subject_offers_days'))
{

        /**
         * ALL days SCHEDULE of subject offer
         * 
         * @param object_row $sub_off_obj 
         * @return string sample: MWF ,TTH ,Sat ,Sun ,MTTHF ,etc..
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        function subject_offers_days($sub_off_obj)
        {

                /**
                 * storing data to be return later
                 */
                $days__ = '';
                /**
                 * loop in days
                 */
                foreach (days_for_db() as $key => $day)
                {
                        /**
                         * in current row, check all days if TRUE, then append DAY KEY, else FALSE nothing to append 
                         *
                         * loop in columns in subject_offer table from database
                         * 
                         * example:
                         * $ubject_off_obj->subject_offer_monday, etc...
                         */
                        if ($sub_off_obj->{'subject_offer_line_' . $day})
                        {
                                /**
                                 * append key
                                 */
                                $days__ .= $key;
                        }
                }
                return $days__;
        }

}