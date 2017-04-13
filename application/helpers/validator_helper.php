<?php

defined('BASEPATH') or exit('no direct script allowed');

if ( ! function_exists('is_not_conflict_subject_offer'))
{

        function is_not_conflict_subject_offer($sched1, $sched2)
        {
                $fucult_room_subject = TRUE;
                for ($i = 1; $i <= 2; $i ++ )
                {
                        foreach (array('faculty', 'room', 'subject') as $v)
                        {
                                if ( ! isset(${'sched' . $i}[$v]))
                                {
                                        $fucult_room_subject = FALSE;
                                        break;
                                }
                        }
                }
                return ! (
                        //--
                        (//big start
                        //1
                        ($sched1['start'] <= $sched2['start'] &&
                        $sched1['start'] <= $sched2['end'] &&
                        $sched1['end'] > $sched2['start'] &&
                        $sched1['end'] <= $sched2['end'])
                        //--
                        OR
                        //2
                        ( $sched1['start'] >= $sched2['start'] &&
                        $sched1['start'] < $sched2['end'] &&
                        $sched1['end'] >= $sched2['start'] &&
                        $sched1['end'] >= $sched2['end'])
                        //--
                        OR
                        //3
                        ( $sched1['start'] <= $sched2['start'] &&
                        $sched1['start'] < $sched2['end'] &&
                        $sched1['end'] > $sched2['start'] &&
                        $sched1['end'] >= $sched2['end'])
                        //--
                        OR
                        //4
                        ( $sched1['start'] >= $sched2['start'] &&
                        $sched1['start'] < $sched2['end'] &&
                        $sched1['end'] > $sched2['start'] &&
                        $sched1['end'] <= $sched2['end'])
                        //--
                        )//big end
                        //--
                        /*
                         * foreign
                         */ &&
                        ( ($fucult_room_subject) ? (
                        (
                        //--
                        ($sched1['faculty'] == $sched2['faculty'] )
                        //--
                        &&
                        //--
                        ($sched1['room'] == $sched2['room'])
                        //--
                        &&
                        //--
                        ($sched1['subject'] == $sched2['subject'])
                        )
                        //--
                        ) : TRUE )
                        /*
                         * end-foreign
                         */
                        //--
                        &&
                        //days
                        (
                        //-
                        ( $sched1['monday'] == $sched2['monday'] && 1 == $sched2['monday'] ) OR
                        //-
                        ( $sched1['tuesday'] == $sched2['tuesday'] && 1 == $sched2['tuesday']) OR
                        //-
                        ( $sched1['wednesday'] == $sched2['wednesday'] && 1 == $sched2['wednesday']) OR
                        //-
                        ( $sched1['thursday'] == $sched2['thursday'] && 1 == $sched2['thursday']) OR
                        //-
                        ( $sched1['friday'] == $sched2['friday'] && 1 == $sched2['friday']) OR
                        //-
                        ( $sched1['saturday'] == $sched2['saturday'] && 1 == $sched2['saturday']) OR
                        //-
                        ( $sched1['sunday'] == $sched2['sunday'] && 1 == $sched2['sunday'])
                        )
                        );
        }

}