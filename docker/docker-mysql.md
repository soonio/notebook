

## MariaDB
```bash
docker run \
    -v /data/mariadb/:/var/lib/mysql \
    -p 3306:3306 \
    -e MYSQL_ROOT_PASSWORD=123456 \
    --privileged=true \
    --restart unless-stopped \
    --name mariadbs \
    -d mariadb:latest
```
## MySQL 
```bash
docker run \
    -v /data/db/mysql/data:/var/lib/mysql \
    -v /data/db/mysql/backup:/data \
    -v /data/db/mysql/conf.d:/etc/mysql/conf.d \
    -p 3306:3306 \
    -e MYSQL_ROOT_PASSWORD=123456 \
    --privileged=true \
    --restart unless-stopped \
    --name mysql \
    -d mysql:8.0.16
```
> mysql如果指定版本或者lasted的话，会导致wine中的navicat客户端无法链接的问题，暂不知道原因

> 备份文件恢复，可以通过复制文件到宿主机/data/mysql中，然后在容器中使用 mysql -u root -p dbname < /var/lib/mysql/demo.sql进行快速恢复

> 查看容器中mysql读取配置的顺序 `mysqld --verbose --help | grep -A 1 'Default options'`

修改mysql8的配置，直接PHP的简单链接方式
/data/db/mysql/conf.d/docker.cnf 
```ini
[mysqld]
skip-host-cache
skip-name-resolve

default_authentication_plugin=mysql_native_password
```



## 数据库安全

- 修改root账户只能本地登录



- 创建新用户用于使用

  ```
  // 创建用户
  CREATE USER 'developer'@'%' IDENTIFIED BY '123456';
  
  // 删除用户
  DROP USER developer @'%';
  
  // 给用户授权所有权限
  GRANT ALL PRIVILEGES ON dbname.* TO 'developer' @'%' WITH GRANT OPTION;
  // 授权部分权限
  GRANT SELECT,
  	INSERT, UPDATE,
  	DELETE,
  	DROP,
  	CREATE,
  	INDEX,
  	ALTER,
  	REFERENCES,
  	CREATE TEMPORARY TABLES,
  	LOCK TABLES,
  	EXECUTE ON `converyor-test`.* TO 'developer' @'%' WITH GRANT OPTION;
  
  // 撤销用户的授权
  REVOKE ALL PRIVILEGES ON *.* FROM 'developer' @'%';
  
  // 查看授权结果
  SHOW GRANTS FOR 'developer' @'%';
  
  // 刷新权限
  flush privileges;
  ```

  

