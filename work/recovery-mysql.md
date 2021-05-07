# 数据表误删除恢复


## 从mysql binlog中导出log sql

```bash
mysql> show master status;
# 输出如下内容，可知当前正在使用的二进制文件为mysql-bin.000010
# File	            Position	  Binlog_Do_DB	Binlog_Ignore_DB	Executed_Gtid_Set
# mysql-bin.000010	426510720     xxx               xxxx                xxxxx


# 从二进制文件mysql-bin.000010中读取4月9号～5月7号执行的sql，并写入binlog_raw3.sql
mysqlbinlog \
  --no-defaults \
  --base64-output=decode-rows -v \
  --start-datetime='2021-04-09 15:40:00' \
  --stop-datetime='2021-05-07 09:21:00'\
  --database matrix2 \
  /var/lib/mysql/mysql-bin.000010 > /home/binlog_raw3.sql
  
# 使用mysql命令恢复binlog_raw3.sql到matrix2中[需要输入密码]
mysql -u root -p matrix2 < /home/binlog_raw3.sql
```

```shell

mysqlbinlog --no-defaults --base64-output=decode-rows -v   --start-datetime='2021-04-01 15:40:00'   --stop-datetime='2021-05-07 09:21:00'  --database matrix2   /var/lib/mysql/mysql-bin.000010 > /home/all.sql

mysqlbinlog --no-defaults --base64-output=decode-rows -v   --start-datetime='2021-04-09 15:40:00'   --stop-datetime='2021-04-25 14:37:55'  --database matrix2   /var/lib/mysql/mysql-bin.000010 > /home/binlog_raw4.sql

mysql -u root -p matrix2 < /home/binlog_raw4.sql

ALTER TABLE `matrix2`.`activity_match_logs`
ADD COLUMN `m_meet` tinyint(4) NOT NULL DEFAULT 0 COMMENT '男接受面基' AFTER `reason`,
ADD COLUMN `f_meet` tinyint(4) NOT NULL DEFAULT 0 COMMENT '女接受面基' AFTER `m_meet`;

ALTER TABLE `matrix2`.`profiles`
ADD COLUMN `qq` varchar(255) NOT NULL DEFAULT '' COMMENT 'qq' AFTER `wechat`;

mysqlbinlog --no-defaults --base64-output=decode-rows -v   --start-datetime='2021-04-25 14:37:55'   --stop-datetime='2021-05-07 09:21:00'  --database matrix2   /var/lib/mysql/mysql-bin.000010 > /home/binlog_raw5.sql

mysql -u root -p matrix2 < /home/binlog_raw5.sql

mysqlbinlog --no-defaults --base64-output=decode-rows -v --start-position "358164856" --stop-position "405193995" --database matrix2  /var/lib/mysql/mysql-bin.000010 > /home/o2.sql

mysql -u root -p < /home/oauths.sql

grep -B3 -A7 -w oauths all.sql > oauth.sql
grep -w activity_logs all.sql > table.sql
```

```php

$file_handle = fopen('./oauth.sql', "r");

date_default_timezone_set('Asia/Shanghai');

while (!feof($file_handle)) {
    $line = fgets($file_handle);
    if (substr($line, 0, 3) == '###') {
        $data = [];
        if (substr($line, 4, 3) == 'SET') {
            $idl = fgets($file_handle);
            $typel = fgets($file_handle);
            $slugl = fgets($file_handle);
            $uidl = fgets($file_handle);
            $ctl = fgets($file_handle);
            $utl = fgets($file_handle);

            $id = explode('=', rtrim(substr($idl, 7), "\n"))[1];
            $type = explode('=', rtrim(substr($typel, 7), "\n"))[1];
            $slug = explode('=', rtrim(substr($slugl, 7), "\n"))[1];
            $uid = trim(explode('=', rtrim(substr($uidl, 7), "\n"))[1], '\'');

            $ctl = date('Y-m-d H:i:s', explode('=', rtrim(substr($ctl, 7), "\n"))[1]);
            $utl = date('Y-m-d H:i:s', explode('=', rtrim(substr($utl, 7), "\n"))[1]);

//            $uid = (int)$uid;
//
//            echo "$uid\n";

            //INSERT INTO oauths VALUES(10086, 1, 'xx', 1, '2021-04-14 09:28:57', '2021-04-14 09:28:57')

            echo sprintf('INSERT INTO oauths VALUES(%d, %d, %s, %d, "%s", "%s");', $id, $type, $slug, $uid, $ctl, $utl) . PHP_EOL;

        }
    }
}
fclose($file_handle);

//echo date('Y-m-d H:i:s');


```