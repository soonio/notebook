## 数据库安全

- 修改root账户只能本地登录

  ```sql
  UPDATE `user` SET `Host`= '127.0.0.1' WHERE `User` = 'root' AND `Host` = '%';
  
  flush privileges;
  ```

- 快速创建新的数据库
  ```sql
  # 创建
  CREATE DATABASE `dbname` CHARACTER SET 'utf8mb4' COLLATE 'utf8mb4_unicode_ci';
  # 删除
  DROP DATABASE `dbname`;
  ```

- 创建新用户用于使用

  ```sql
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
