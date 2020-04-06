# PHP连续数字索引引发的问题及解决方式


## 问题说明
数据状态map
```php
$map = [
    0 => '正常',
    1 => '处理中',
    2 => '已完成'
];

var_dump($map);

echo json_encode($map, JSON_UNESCAPED_UNICODE);
```
json输出结果就有问题了，索引丢失了..
```log
array(3) {
  [0]=>
  string(6) "正常"
  [1]=>
  string(9) "处理中"
  [2]=>
  string(9) "已完成"
}
["正常","处理中","已完成"]
```

## 解决方案

```php
function tranNumericKey2string(array $array)
{
    $tmp = new \stdClass();
    foreach ($array as $key => $value)
    {
        $tmp->{"{$key}"} = $value;
    }
    return $tmp;
}

echo json_encode(tranNumericKey2string($map), JSON_UNESCAPED_UNICODE);
```
```log
{"0":"正常","1":"处理中","2":"已完成"}
```
