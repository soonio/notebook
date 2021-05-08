# 数据表误删除恢复

## 前言

  不小心的操作把一个生产环境小活动项目所有数据表删除了，而恰好数据表也没有备份，所以想起了mysql的binlog日志。  
  本次操作是一次真实的恢复经历

## 先看mysql是否开启binlog日志

  ```sql
  show variables like 'log_%';
  ```
  > 通过该命令可以查看到`log_bin=ON`，所以才有以下的操作
  > 
  > 同时看到 `log_bin_index=/var/lib/mysql/mysql-bin.index`，说明binlog都在`/var/lib/mysql`目录中

## 查看当前使用的binglog文件
  ```bash
  mysql> show master status;
  # 输出如下内容，可知当前正在使用的二进制文件为mysql-bin.000010
  # File	            Position	  Binlog_Do_DB	Binlog_Ignore_DB	Executed_Gtid_Set
  # mysql-bin.000010	426510720     xxx               xxxx                xxxxx
  ```
  > 当前的二进制日志文件为`/var/lib/mysql/mysql-bin.000010`

## 第一次从二进制文件中恢复

  ```bash
  # 从二进制文件mysql-bin.000010中读取4月9号～5月7号执行的sql记录并保存为/home/log_sqls.sql
  mysqlbinlog \
    --no-defaults \
    --base64-output=decode-rows -v \
    --start-datetime='2021-04-09 15:40:00' \
    --stop-datetime='2021-05-07 09:21:00'\
    --database matrix2 \
    /var/lib/mysql/mysql-bin.000010 > /home/log_sqls.sql
  
  # 使用mysql命令恢复binlog_raw3.sql到matrix2中[需要输入密码]
  mysql -u root -p matrix2 < /home/log_sqls.sql
  ```

  > 在执行第一次恢复时，发现binlog日志中修改表结构的sql没有执行

## 第二次从二进制文件中恢复

  > 吸收第一次的经验教训，并在log_sqls.sql中找到了缺失的修改表sql时间，以此为时间点，分两次进行输出恢复，25号之前，和之后的

  ```shell
  # 生成所有的sql记录
  mysqlbinlog \
    --no-defaults \
    --base64-output=decode-rows -v \
    --start-datetime='2021-04-01 15:40:00' \
    --stop-datetime='2021-05-07 09:21:00' \
    --database matrix2 \
    /var/lib/mysql/mysql-bin.000010 > /home/all.sql

  # 生成4月9~4月25的
  mysqlbinlog \
    --no-defaults \
    --base64-output=decode-rows -v \
    --start-datetime='2021-04-09 15:40:00' \
    --stop-datetime='2021-04-25 14:37:55' \
    --database matrix2 \
    /var/lib/mysql/mysql-bin.000010 > /home/part1.sql

  # 把25号之前的进行恢复
  mysql -u root -p matrix2 < /home/part1.sql
  ```
  执行这个过程中缺失的修改表结构的语句
  ```sql
  ALTER TABLE `matrix2`.`activity_match_logs`
  ADD COLUMN `m_meet` tinyint(4) NOT NULL DEFAULT 0 COMMENT '男接受面基' AFTER `reason`,
  ADD COLUMN `f_meet` tinyint(4) NOT NULL DEFAULT 0 COMMENT '女接受面基' AFTER `m_meet`;

  ALTER TABLE `matrix2`.`profiles`
  ADD COLUMN `qq` varchar(255) NOT NULL DEFAULT '' COMMENT 'qq' AFTER `wechat`;
  ```
  继续恢复第二部分
  ```shell
  mysqlbinlog \
    --no-defaults \
    --base64-output=decode-rows -v \
    --start-datetime='2021-04-25 14:37:55' \
    --stop-datetime='2021-05-07 09:21:00' \
    --database matrix2 \
    /var/lib/mysql/mysql-bin.000010 > /home/part2.sql

  mysql -u root -p matrix2 < /home/part2.sql
  ```

## 恢复完以后，发现部分table的数据并没有真正的恢复

  查看all.sql文件,发现以下内容，这他妈谁受得了。

  ```sql
  BEGIN
  /*!*/;
  # at 351576689
  #210409 17:41:58 server id 1  end_log_pos 351576758 CRC32 0x33058e65    Table_map: `matrix2`.`oauths` mapped to number 7886
  # at 351576758
  #210409 17:41:58 server id 1  end_log_pos 351576844 CRC32 0x9f01345c    Write_rows: table id 7886 flags: STMT_END_F
  ### INSERT INTO `matrix2`.`oauths`
  ### SET
  ###   @1=1
  ###   @2=1
  ###   @3='谢谢谢谢谢谢谢谢'
  ###   @4='1'
  ###   @5=1617961318
  ###   @6=1617961318
  --
  ```
  
  使用grep把关于oauth表的数据全部抓取出来
  ```bash
  grep -B3 -A7 -w oauths all.sql > oauth.sql
  ```
  > 其中-B3 -A7 有oauths出现的前三行和后7行都读取出来

  使用php解析褚oauth.sql中有效的数据
  ```php
  # f.php
  date_default_timezone_set('Asia/Shanghai');
  $fh = fopen('./oauth.sql', "r");

  while (!feof($fh)) {
    $line = fgets($fh);
    if (substr($line, 0, 3) == '###') {
        $data = [];
        if (substr($line, 4, 3) == 'SET') {
            $idl    = fgets($fh);
            $typel  = fgets($fh);
            $slugl  = fgets($fh);
            $uidl   = fgets($fh);
            $ctl    = fgets($fh);
            $utl    = fgets($fh);

            $id     = explode('=', rtrim(substr($idl, 7), "\n"))[1];
            $type   = explode('=', rtrim(substr($typel, 7), "\n"))[1];
            $slug   = explode('=', rtrim(substr($slugl, 7), "\n"))[1];
            $uid    = trim(explode('=', rtrim(substr($uidl, 7), "\n"))[1], '\'');

            $ctl    = date('Y-m-d H:i:s', explode('=', rtrim(substr($ctl, 7), "\n"))[1]);
            $utl    = date('Y-m-d H:i:s', explode('=', rtrim(substr($utl, 7), "\n"))[1]);
            echo sprintf('INSERT INTO oauths VALUES(%d, %d, %s, %d, "%s", "%s");', $id, $type, $slug, $uid, $ctl, $utl) . PHP_EOL;
        }
    }
  }
  fclose($fh);
  ```
  
  ```bash
  php f.php > valid-oauth.sql
  mysql -u root -p matrix2 < valid-oauth.sql
  ```

## 后来还发现参加活动的数据部分丢失

  ```bash
  # 抓去所有的
  grep -w activity_logs all.sql > al.sql
  
  # 发现al.sql中的sql没有结尾符号，通过sed命令给每条sql添加上`;`
  cat al.sql | sed 's/^//;s/$/;/' > valid-al.sql
  ```

## 大功告成，恢复完毕。幸亏删库了没跑路。

