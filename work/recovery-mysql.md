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