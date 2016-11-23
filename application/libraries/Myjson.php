<?php

/**
 * 
 * 
 * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
 */
defined('BASEPATH') or exit('no direct script allowed');

class Myjson {

    public function __construct() {
        
    }

    /**
     * beautifier for returned json_encode() 
     * just to make easy read data in debugging
     * 
     * note: still developing, but it still helps you now just to read the json result
     * 
     * @param string json out that cant read easy
     * @return string json output readable by human
     */
    public function beautifier($json) {

        //convert ordinary string to array
        //so we cant iterate the string through foreach{} using array
        $json_arr = str_split($json);

        //this will be the storage string
        $t = '';
        $squarey_tab = $querly_tab = 1;
        $last_querly = '';
        $last_sqaue = '';
        $last_char = '';

        //when use new line <br />
        $down = FALSE;

        foreach ($json_arr as $v) {
            if ($v == '{') {
                if ($last_querly == '{') {
                    $squarey_tab++;
                }
                $last_querly = '{';
                $t .= '<br />' . $this->space($squarey_tab) . $v . '<br />';
                $down = TRUE;
            } elseif ($v == '}') {
                if ($last_querly == '}') {
                    $squarey_tab--;
                }
                $last_querly = '}';
                $t .= '<br />' . $this->space($squarey_tab) . $v . '<br />';
                $down = TRUE;
            } elseif ($v == ',') {
                $t .= ',<br />' . $this->space($squarey_tab);
            } else {
                if ($down) {
                    //     $squarey_tab++;
                    $t .= $this->space($squarey_tab);
                }
                $t .= $v;
                $down = FALSE;
            }
            $last_char = $v;
        }
        return '<pre>' . $t . '</pre>';
    }

    /**
     * just to give you a space tab in html output
     * 
     * @param int length of space
     * @return string space you want to live in this world! :D
     */
    private function space($end) {
        $tmp = '';
        $end = 5 * $end;
        for ($i = 0; $i < $end; $i++) {
            $tmp .= '&nbsp;';
        }
        return $tmp;
    }

}
