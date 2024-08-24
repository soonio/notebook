### 设置配置

```bash
mysql_config_editor set --login-path=db1 --user=root  --host=192.168.0.100 --port=3306 --password
mysql_config_editor set --login-path=db2 --user=root  --host=192.168.0.200 --port=3306 --password
mysql_config_editor set --login-path=db3 --user=root  --host=192.168.0.250 --port=3306 --password
```
> 注意需要手动输入密码

### 删除配置
```bash
mysql_config_editor remove db3
```

### mysqldump参数说明

  如 `mysqldump --login-path=db1 cms --set-gtid-purged=OFF -R -E -r cms.backup.sql`  
  - --login-path=db1 使用设置的db1的配置
  - --set-gtid-purged=OFF GTID (Global Transaction IDentifier) 是全局事务标识，
  - -R 备份routines
  - -E 备份events
  - -r cms.backup.sql 备份到cms.backup.sql文件中



### 一键备份命令
```bash
export database="cms"
export backup="$database.backup.$(date +'%Y%m%d.%H%M%S').sql" \
&& echo "备份文件名称 $backup" \
&& echo "[$(date +'%Y-%m-%d %H:%M:%S')] 开始创建备份" \
&& mysqldump --login-path=db1 $database --set-gtid-purged=OFF -R -E -r "$backup" \
&& echo "[$(date +'%Y-%m-%d %H:%M:%S')] 开始备份恢复" \
&& mysql --login-path=db2 -c --default-character-set=utf8mb4 -D $database < "$backup" \
&& echo "[$(date +'%Y-%m-%d %H:%M:%S')] 完成备份恢复"
```
