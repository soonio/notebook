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
  GRANT ALL PRIVILEGES ON `dbname`.* TO 'developer'@'%' WITH GRANT OPTION;
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
  	EXECUTE ON `dbname`.* TO 'developer'@'%' WITH GRANT OPTION;
  
  // 撤销用户的授权
  REVOKE ALL PRIVILEGES ON `*`.* FROM 'developer'@'%';
  
  // 查看授权结果
  SHOW GRANTS FOR 'developer'@'%';
  
  // 刷新权限
  flush privileges;
  ```

## 几种join的区别
  - inner join  
    - 多个表都有信息的时候才能显示某条查询结果
  - left join & right join  
    - 查询结果以主表为标准，带上left(right)表的信息  

## MySQL中的链接查询

  - ON a.colunmu = b.column 可以使用USING (column_name)代替
  - INNER JIOIN 强制类型条件,会过滤左表或者右表中不相匹配的数据
  - OUTER JOIN 可选择性条件,无论匹配与否都不过该表滤任何数据行
  - 不仅在select中可以使用join语法,在update和delete也可以使用

## MySQL合并查询(UNION)

```sql
SELECT f.country
FROM flags as f
INNER JOIN colors as c USING (color)
WHERE c.is_dark = 1
UNION (ALL/DISTINCT)
SELECT f.country
FROM flags as f
INNER JOIN colors as c USING (color)
WHERE c.is_primary = 1
```
!> UNION语句主要用来为某SQL查询合并多个SELECT语句的结果. ALL和DISTINCT 前者列出所有,后者自动去重,若不写,默认DISTINCT

## MySQL查询的GROUP BY
GROUP BY对选择的数据进行聚合,并且可以使用标量函数
GROUP_CONCAT(column) 连接成一行

WITH ROLLUP 是GROUP UP的额外关键字
--使查询结果中的数据行将包含每个GROUP BY列的聚合的行
HAVING
--可以针对标量函数限制聚合数据行列表

## MySQL中的逻辑运算符和流程控制
!> MySQL所有逻辑只有三种状态 即 TRUE FALSE NULL,运算符运算结果也将是以上三种状态

- 逻辑运算符  
  逻辑运算符AND OR XOR 是双目运算符 NOT 是单目预算符
- 流程控制  
  四个用于流程控制的函数 IF() CASE IFNULL() NULLIF()
