<?php
/**
 * Created by PhpStorm.
 * User: cdimitzas
 * Date: 29/3/2016
 * Time: 4:07 μμ
 */

namespace app\Services\General_use_services;


class general_use_services {

    public function reindex_array($array){
        $reindexed_array = [];
        for($i=0 ; $i<count($array) ; $i++){
            $reindexed_array[$i+1] = $array[$i]->description;
        }
        return $reindexed_array;
    }

    // keeps every element and reindex only the array from 1 to n
    public function general_reindex_array($array){
        $reindexed_array = [];
        for($i=0 ; $i<count($array) ; $i++){
            $reindexed_array[$i+1] = $array[$i];
        }
        return $reindexed_array;
    }
} 