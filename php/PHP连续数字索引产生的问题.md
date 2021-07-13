## 问题说明

```php
$map = [
    0 => '正常',
    1 => '处理中',
    2 => '已完成'
];
echo json_encode($map, JSON_UNESCAPED_UNICODE);
// 输出 ["正常","处理中","已完成"]
```
> json输出结果就有问题了，索引丢失了..

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
// 输出 {"0":"正常","1":"处理中","2":"已完成"}
```
