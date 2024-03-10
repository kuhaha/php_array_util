<?php
namespace ksu;

class Util {
    public static function jpdate($date, $withtime=false, $withyear=true){
        $wdays = ['日','月','火','水','木','金','土'];
        $_date = new \DateTimeImmutable($date);
        $w = $_date->format('w');
        $y = $_date->format('Y');
        $time = $withtime ? $_date->format('H:i') : '';
        if ($withyear){
            $nengo = $y > 2019 ? '令和'.$y-2018 : '平成'. $y-1998;
            return $nengo . $_date->format('年n月d日('). $wdays[$w]. ')' . $time;
        }
        return $_date->format('n月d日(') . $wdays[$w]. ')' . $time;
    }

    /** transform a row list to a KVP list: Key-Value Pair */
    public static function toKVP($data, $key_field, $value_field)
    {
        $options = [];
        foreach($data as $row){
            $key = $row[$key_field];
            $value = $row[$value_field];
            $options[$key] = $value;
        }
        return $options;
    }
        
    public static function unifom_rand($items, $n=1)
    {
        $rand_keys = array_rand($items, $n);
        return self::slice_by_key($items, $rand_keys);
    }

    public static function slice_by_key($items, $keys)
    {
        $sliced = [];
        foreach(is_array($keys)?$keys:[$keys] as $k){
            $sliced[] = $items[$k];
        }
        return $sliced;
    }

    /** weighted_rand() : returns n elements from an array selected randpmly at unform
     * Example: weighted_rand(['J'=>10, 'Q'=>25, 'K'=>15, 'A'=>50], 2) => ['Q','K']
     */
    public static function weighted_rand($prob_items, $n=1) 
    {        
        $n_item = count($prob_items); 
        if ($n < 1 or $n > $n_item){
            return null;
        }
        $keys = array_keys($prob_items);
        $total = array_sum($prob_items);    
        $new_items = array_map(fn($v):float=>$v/$total, $prob_items);        
        $comb_keys = self::combination($keys, $n);  
        $comb_values = [];
        foreach ($comb_keys as $i=>$comb_key){
            $comb_prob = array_map(fn($a):float=>$new_items[$a], $comb_key);
            $comb_values[$i] = array_product( $comb_prob);
        } 
        
        $total = array_sum($comb_values);
        $stop_at = rand(0, 100); 
        $curr_prob = 0;         
        foreach ($comb_keys as $i=>$item) {
            $curr_prob += 100 * $comb_values[$i] / $total; 
            if ($curr_prob >= $stop_at) {
                return $item;
            }
        }  
        return null;
    }

    static function combination($items, $n)
    {
        $items = array_values(array_unique($items));
        $n_item = count($items); 
        if ($n < 1 or $n > $n_item){
            return null;
        }
        $m = $n_item - $n + 1;
        $matrix = [];
        foreach (range(0, $n-1) as $i){
            foreach(array_slice($items, $i, $m) as $j=>$item){
                $matrix[$i][$j] = $item;
            }
        }
        // print_r($matrix);
        
        $result = [];
        foreach (range(0, $m-1) as $i){
            $result[] = array_column($matrix, $i);
        }        
        // print_r($result);
        return $result;

    }
}