<?php
/**
 * Created by PhpStorm.
 * User: kmrb20181113
 * Date: 2021/3/11
 * Time: 15:18
 */

namespace YxTools;


class TimeHandle
{
    /*
     * 根据年份，获取月份开始到月份结束的时间。
     */
    public function getMonthData($year){

        $data = array();
        if($year!=date('y')){
            $moth_lenth = date('m');
        }else{
            $moth_lenth = 12;
        }
        for ($i=1;$i<=$moth_lenth;$i++){
            if($i<10){
                $start = date($year."-0".$i."-01");
                if($i<9){
                    $end = date($year."-0".($i+1)."-01");
                }else{
                    $end = date($year."-".($i+1)."-01");
                }

            }else{
                $start = date($year."-".$i."-01");
                if($i<12){
                    $end = date($year."-".($i+1)."-01");
                }else{
                    $end = date(($year+1)."-01-01");
                }
            }
            $data[$year][$i]['start'] = $start;
            $data[$year][$i]['end'] = $end;

        }
         return $data;
    }

}