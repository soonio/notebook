```php

$dbms = 'mysql';
$host = '127.0.0.1:3306';
$dbName = 'dbname';
$user = 'root';
$pass = '123456';

$dsn = "$dbms:host=$host;dbname=$dbName";

$pdo = new PDO($dsn, $user, $pass); //初始化一个PDO对象

$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// 设置结果集
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
$res=$pdo->query('select * from tablename limit 1');
foreach ($res as $key => $value) {
    print_r([$key, $value]);
}
```
