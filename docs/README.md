#referecens 
- [Nette Utility Classes](https://github.com/nette/utils)
- [ReverseRegex - Use Regular Expressions to generate text strings ](https://github.com/icomefromthenet/ReverseRegex)
- [Faker - A PHP library that generates fake data for you](https://github.com/FakerPHP/Faker)
  ```
   <<Core>> := <<Extension>> := <<Provider>> := <<Generator>> 
   BarCode     Address          Address         ChanceGenerator
   Blood       BarCode          Color           UniqueGenerator
   ...         ...              ...             ...
   ```
# Interface
- **schema**: column/attribute, row/tuple, table/relation
- **domain**: int, float, date, datetime, string, set, dict, list, range
- **formatter**: sprintf, regexp, sql_values
- **collection**: sequence, random, biased_random
- **dependency**: functional, multivalued-functional, user-defined 

# Base
- `generator`, `provider`, `container*`, `extension`
- `validator`, `exceptor`, `guesser`, `fomatter`
- `faker_array()`
- `faker_table()`
- `weighted_rand()`
- `array_rand()`
- `set_eq`
- `seq_eq`

  
## References
1. [PSR-11: Container Interface] (https://www.php-fig.org/psr/psr-11/)
2. [] ()

# PHP native array functions 

## random

- `shuffle`: 配列をシャッフルする
- `array_rand`: 配列からランダムに**キー**を一つ以上取得する

## fill, update

- `array_fill`: 列を指定した値で埋める
- `array_fill_keys`: キーを指定して、配列を値で埋める
- `array_pad`: 指定長、指定した値で配列を埋める
- `array_push`: 要素を配列の最後に追加する
- `array_pop`: 配列の末尾から要素を取り出す
- `array_shift`: 配列の先頭から要素を取り出す
- `array_unshift`: 要素を配列の最初に加える
- `array_replace`: 配列の要素を置き換える
- `array_replace_recursive`: 配列の要素を再帰的に置き換える
- `array_splice`: 配列の一部を削除し、他の要素で置換する
- `array_change_key_case`: 配列のすべてのキーの大文字小文字を変更する

## n-ary operations

- `array_merge`: 複数の配列をマージする
- `array_merge_recursive`: 配列を再帰的にマージする
- `array_combine`: 一方の配列をキーとして、もう一方の配列を値として、新しい配列を生成する
- `array_intersect_assoc`: 配列の共通項を計算する
- `array_intersect_key`: キーを基準にして配列の共通項を計算する
- `array_intersect_uassoc`: コールバック関数を用いて 配列の共通項を計算する
- `array_intersect_ukey`: キーを基準にし、コールバック関数を用いて 配列の共通項を計算する
- `array_intersect`: 配列の共通項を計算する
- `array_uintersect_assoc`: データの比較にコールバック関数を用いて配列の共通項を計算する
- `array_uintersect_uassoc`:添字の比較にユーザーが指定したコールバック関数を用いて配列の共通項を計算する
- `array_uintersect`: データの比較にコールバック関数を用いて配列の共通項を計算する
- `array_diff`: 配列の差を計算する
- `array_diff_key`: キーを基準にして配列の差を計算する
- `array_diff_assoc`: 配列の差を計算する
- `array_diff_ukey`: キーを基準にし、コールバック関数を用いて配列の差を計算する
- `array_diff_uassoc`: ユーザーが指定したコールバック関数を利用し配列の差を計算する
- `array_udiff_uassoc`: データと添字の比較にコールバック関数を用いて配列の差を計算する
- `array_udiff`: データの比較にコールバック関数を用いて配列の差を計算する

```
    array_intersect             use Value, not callback
    array_uintersect            use Value, callback receives Value
    array_intersect_key         use Key, not callback
    array_intersect_ukey        use Key, callback receives Key
    array_intersect_assoc       use Both, not callback
    array_intersect_uassoc      use Both, callback receives Key ONLY
    array_uintersect_assoc      use Both, callback receives Value ONLY
    array_uintersect_uassoc     use Both, One callback receives the Key, the other receives the Value.

    array_diff             use Value, not callback
    array_udiff            use Value, callback receives Value
    array_diff_key         use Key, not callback
    array_diff_ukey        use Key, callback receives Key
    array_diff_assoc       use Both, not callback
    array_diff_uassoc      use Both, callback receives Key ONLY
    array_udiff_assoc      use Both, callback receives Value ONLY
    array_udiff_uassoc     use Both, One callback receives the Key, the other receives the Value.
```

## generate, extract, transform
- `array`: 配列を生成する
- `range`: ある範囲の要素を含む配列を作成する
- `compact`: 変数名とその値から配列を作成する
- `array_keys`: 配列のキーすべて、あるいはその一部を返す
- `array_values`: 配列の全ての値を返す
- `array_flip`: 配列のキーと値を反転する
- `array_slice`: 配列の一部を抽出する
- `array_chunk`: 配列を分割する
- `array_column`: 入力配列から単一のカラムの値を返す
- `array_unique`: 配列から重複した値を削除する

## search

- `array_filter`: コールバック関数を使用して、配列の要素をフィルタリングする
- `array_search`: 指定した値を配列で検索し、見つかった場合に対応する最初のキーを返す
- `in_array`: 配列に値があるかチェックする
- `array_key_exists`, `key_exists`: 指定したキーまたは添字が配列にあるかどうかを調べる

## sort

- `sort`: 配列を昇順にソートする
- `rsort`: 配列を降順にソートする
- `asort`: 連想キーと要素との関係を維持しつつ配列を昇順にソートする
- `arsort`: 連想キーと要素との関係を維持しつつ配列を降順にソートする
- `ksort`: 配列をキーで昇順にソートする
- `krsort`: 配列をキーで降順にソートする
- `natsort`: "自然順"アルゴリズムで配列をソートする
- `natcasesort `: 大文字小文字を区別しない"自然順"アルゴリズムを用いて配列をソートする
- `usort`: ユーザー定義の比較関数を使用して、配列を値でソートする
- `uasort`: ユーザー定義の比較関数で配列をソートし、連想インデックスを保持する
- `uksort`: ユーザー定義の比較関数を用いて、キーで配列をソートする
- `array_multisort`: 複数または多次元の配列をソートする
- `array_reverse`: 要素を逆順にした配列を返す

## traverse, iterate 
- `each`: 配列から現在のキーと値のペアを返して、カーソルを進める
- `current`, `pos`: 配列内の現在の要素を返す
- `next`: 配列の内部ポインタを進める
- `prev`: 内部の配列ポインタをひとつ前に戻す
- `end`: 配列の内部ポインタを最終要素にセットする
- `reset`: 配列の内部ポインタを先頭の要素にセットする
- `key`: 配列から現在要素のキーを取り出す　
- `array_key_first`: 配列の最初のキーを得る
- `array_key_last`: 配列の最後のキーを得る
- `array_map`: 指定した配列の要素にコールバック関数を適用する
- `array_walk`: 配列の全ての要素にユーザー定義の関数を適用する
- `array_walk_recursive`: 配列の全ての要素に、ユーザー関数を再帰的に適用する

## aggregate
- `count`, `sizeof`: 配列または Countable オブジェクトに含まれるすべての要素の数を数える
- `array_count_values`: 配列内に存在する、異なる値の出現回数を数える
- `array_sum`: 配列の中の値の合計を計算する
- `array_product`: 配列の値の積を計算する
- `array_reduce`: コールバック関数を繰り返し配列に適用し、配列をひとつの値にまとめる

## misc

- `array_is_list()`: 指定された配列がリストかどうかをチェックする
- `is_array()`:  変数が配列かどうかをチェックする
- `explode()`: 文字列を区切り文字列により分割する
- `implode()`, `join()`: 配列要素を区切り文字列により連結する
- `preg_split()`: 正規表現で文字列を分割する
- `extract`: 配列からシンボルテーブルに変数をインポートする
- `list`: 配列と同様の形式で、複数の変数への代入を行う

## array to varibles

- `[$a, $b] = [1, 3]`
- `['name'=>$name, 'age'=>$age] = ['name'='Tom', 'age'=>21, 'tel'=>'123-4567']`

```php
<?php
$data = [
    ["id" => 1, "name" => 'Tom'],
    ["id" => 2, "name" => 'Fred'],
];
foreach ($data as ["id" => $id, "name" => $name]) {
    echo "id: $id, name: $name\n";
}
echo PHP_EOL;
list(1 => $second, 3 => $fourth) = [1, 2, 3, 4];
echo "$second, $fourth\n";
```
Output:
```
id: 1, name: Tom
id: 2, name: Fred

2, 4
```