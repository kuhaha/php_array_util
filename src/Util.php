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

    static function toja(string $date, bool $withweek=false, bool $withtime=false, bool $withyear=true)
    {
        $formatter = new \IntlDateFormatter(
            'ja_JP@calendar=japanese', 
            \IntlDateFormatter::FULL,
            \IntlDateFormatter::FULL, 
            'Asia/Tokyo',
            \IntlDateFormatter::TRADITIONAL
        );
        $yy = $withyear ? 'Gy年' : '';
        $tt = $withtime ? 'HH:mm' : '';
        $ww = $withweek ? '(EE)' : '';
        $formatter->setPattern($yy . 'M月d日' . $ww . $tt);
        $dt = new \DateTime($date);
        return $formatter->format($dt);
    }

    /**
     * Undocumented function
     *
     * @param array $array
     * @param array $keys
     * @return array
     */
    public static function array_slice_by_key(array $array, array $keys) : array 
    {
        $sliced = [];
        foreach(is_array($keys) ? $keys : [$keys] as $k){
            $sliced[] = $array[$k];
        }
        return $sliced;
    }

    /**
     * Array slice function that works with associative arrays (keys):
     * $arr = ['name'=>'Nathan', 'age'=>20, 'height'=>6];
     * array_slice_assoc($arr, ['name','age']); will return ['name'=>'Nathan','age'=>20]
     * 
     * @param array $array
     * @param array $keys
     * @return array
     */
    static function array_slice_assoc(array $array, array $keys) : array
    {
        return array_intersect_key($array, array_flip($keys));
    }


    /**
     * Transform array to a key-value pair:
     * [['id'=1, 'name'=>'tom', 'age'=>34],...] will return [1=>'tom', 2=>'taro',...]
     * 
     * @param array $array
     * @param string $key_field
     * @param callable|null $callback
     * @return array
     */
    public static function associate(array $array, string $key_field, ?callable $callback=null): array
    {
        $options = [];
        foreach($array as $row){
            $key = $row[$key_field];
            $value = is_callable($callback) ? $callback($array) : $array;
            $options[$key] = $value;
        }
        return $options;
    }
    
    /**
     * Choose n items from array uniformly at random  
     *
     * @param array $array
     * @param integer $n
     * @return array
     */
    public static function uniform_rand(array $array, int $n=1): array
    {
        $rand_keys = array_rand($array, $n);
        return self::array_slice_by_key($array, $rand_keys);
    }

    /**
     * Choose n items from array with a probability proportional to its weight  
     * Example: weighted_rand(['J'=>10, 'Q'=>25, 'K'=>15, 'A'=>50], 2) => ['Q','K']
     * 
     * @param array $prob_items
     * @param integer $n
     * @return array|null
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

    /**
     * returns combinations of size r from n items
     *
     * @param array $array
     * @param integer $r
     * @return array|null
     */
    static function combination(array $array, int $r) : ?array
    {
        $array = array_values(array_unique($array));
        $n = count($array);
        if($r < 1 || $n < $r) return null; 
        if ($r == 1) return array_chunk($array, 1);
        $result = [];
        for ($i = 0; $i < $n - $r + 1; $i++){
            $sliced = array_slice($array, $i + 1);
            $comb = combination($sliced, $r - 1);
            foreach ($comb as $one_set){
                array_unshift($one_set, $array[$i]);
                $result[] = $one_set;
            }
        }            
        return $result;
    }

    static function transpose($array) {
        return array_map(null, ...$array);
    }
   
}