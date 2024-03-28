<?php

/**
 * File-level docblock.
 */

declare(strict_types=1);

namespace Ksu\PHPUtil;

class Util {

    static function ja_date(string $date, bool $withweek=false, bool $withtime=false, bool $withyear=true)
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
     * Transform a row-based array to a key-value pair:
     * associate([['id'=1, 'name'=>'tom', 'age'=>34],...],'id',fn($v)=>$v['name']) 
     * will return [1=>'tom', 2=>'taro',...]
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
     * Return n items from array chosen uniformly at random  
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
     * Return n items chosen from array with a probability proportional to its weight  
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
     * returns combinations of size r
     *
     * @param array $array
     * @param integer $r
     * @return array|null
     */
    public static function combination(array $array, int $r) : ?array
    {
        $array = array_values(array_unique($array));
        $n = count($array);
        if($r < 1 || $n < $r) return null; 
        if ($r == 1) return array_chunk($array, 1);
        $result = [];
        for ($i = 0; $i < $n - $r + 1; $i++){
            $sliced = array_slice($array, $i + 1);
            $comb = static::combination($sliced, $r - 1);
            foreach ($comb as $one_set){
                array_unshift($one_set, $array[$i]);
                $result[] = $one_set;
            }
        }            
        return $result;
    }

    /**
     * Return combinations of all sizes
     *
     * @param array $array
     * @return array|null
     */
    public static function combinations(array $array) : ?array
    {
        $array = array_values(array_unique($array));
        $n = count($array);
        $result = [];
        for ($r = 1; $r <= $n; $r++){
            $comb = static::combination($array, $r);
            $result = array_merge($result, $comb);
        }
        return $result;
    }


    /**
     * Return Cartesian product of two sets
     *
     * @param array $array1
     * @param array $array2
     * @return array
     */
    public static function product(array $array1, array $array2): array
    {
        $array1 = array_values(array_unique($array1));
        $array2 = array_values(array_unique($array2));
        $result = [];
        foreach ($array1 as $a1){
            foreach ($array2 as$a2){
                $result[] = array($a1, $a2);
            }
        }
        return $result;
    }

    /**
     * Return Cartesian product of n sets
     *
     * @param array ...$array
     * @return array|null
     */
    public static function products(array ...$array): ?array
    {
        $array1 = array_chunk(array_values(array_unique($array[0])), 1);
        for ($i = 1; $i < count($array); $i++){
            $array2 = array_values(array_unique($array[$i]));
            $result = [];
            foreach ($array1 as $a1){
                foreach ($array2 as$a2){
                    $one = $a1;
                    array_push($one, $a2);
                    $result[] = $one;
                }
            }
            $array1 = $result;

        }
        return $array1;
    }

    public static function transpose($array) {
        return array_map(null, ...$array);
    }
   
}