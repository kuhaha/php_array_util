<?php

/**
 * File-level docblock.
 */

declare(strict_types=1);

namespace Ksu\PHPUtil;

class Util {
    public static function jpdate(string $date, bool $withtime=false,bool $withyear=true): string
    {
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

    public static function slice_by_key(array $items, array $keys): array 
    {
        $sliced = [];
        foreach(is_array($keys) ? $keys : [$keys] as $k){
            $sliced[] = $items[$k];
        }
        return $sliced;
    }

    /** transform a row to a Key-Value Pair */
    public static function associate(array $data, string $key_field, ?callable $callback=null): array
    {
        $options = [];
        foreach($data as $row){
            $key = $row[$key_field];
            $value = is_callable($callback) ? $callback($data) : $data;
            $options[$key] = $value;
        }
        return $options;
    }
        
    public static function unifom_rand(array $items, int $n=1): array
    {
        $rand_keys = array_rand($items, $n);
        return self::slice_by_key($items, $rand_keys);
    }


    /** weighted_rand() : returns n elements from an array selected randpmly at unform
     * Example: weighted_rand(['J'=>10, 'Q'=>25, 'K'=>15, 'A'=>50], 2) => ['Q','K']
     */
    public static function weighted_rand(array $prob_items, int $n=1) : ?array 
    {        
        $n_item = count($prob_items); 
        if ($n < 1 or $n > $n_item){
            return null;
        }
        $keys = array_keys($prob_items);   
        $comb_keys = self::combination($keys, $n);  
        $comb_values = [];
        foreach ($comb_keys as $i=>$comb_key){
            $comb_prob = array_map(fn($a):float=>$prob_items[$a], $comb_key);
            $comb_values[$i] = array_product($comb_prob);
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

    static function combination(array $items, int $n) : ?array
    {
        $items = array_values(array_unique($items));
        $n_item = count($items); 
        if ($n < 1 or $n > $n_item){
            return null;
        }
        $m = $n_item - $n + 1;
        $matrix = [];
        for($i=0; $i < $n; $i++){
            foreach(array_slice($items, $i, $m) as $j=>$item){
                $matrix[$i][$j] = $item;
            }
        }
        $result = [];
        for ($i = 0; $i < $m; $i++){
            $result[] = array_column($matrix, $i);
        }        
        return $result;
    }
    static function permutation(array $items, int $n) : ?array
    {
        $items = array_values(array_unique($items));
        $n_item = count($items); 
        if ($n < 1 or $n > $n_item){
            return null;
        }
        $result = [];
        if($n == 1){
            foreach($items as $item){
                $result[] = [$item];
            }
            return $result;
        }
    
        if($n > 1){
            foreach($items as $key => $item){
                // $item を除いた配列を作成
                $newArr = array_filter($items, function($k) use($key) {
                    return $k !== $key;
                }, ARRAY_FILTER_USE_KEY);
                // 再帰処理 二次元配列が返ってくる
                $recursion = self::permutation($newArr, $n - 1);
                foreach($recursion as $one_set){
                    array_unshift($one_set, $item);
                    $result[] = $one_set;
                }
            }
        }    
        return $result;
    }
}