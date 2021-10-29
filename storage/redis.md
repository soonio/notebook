## 数据类型及其用法

### string(字符串)

### hash(key-map)

### set(集合)

### zset(有序集合)

### list(列表)

### geospatial(地理位置)

### bitmap(位图)

## 配置

### 密码设置
### 持久化

## 常见问题

### 分布式锁应用
### 雪崩和穿透问题解决


## 用法
### Hscan
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
