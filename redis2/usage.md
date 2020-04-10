## Hscan

```php
$key = "{$day}:{$hour}";
$redis = Utils::redis();

// TODO 统计每小时
while (true) {
  $res = $redis->hScan($key, $cursor, null, 100);

  foreach ($res as $k => $v) {
    $redis->hDel($key, $k);
  }
  print_r([count($res), $cursor]);
  if (!$cursor) break;
}
print_r('结束了');
```

