
## 删除可能存在的表
```
drop table IF EXISTS a_table;
drop table IF EXISTS b_table;
```

## 创建表
```
CREATE TABLE `a_table` (
  `a_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `a_name` varchar(255) DEFAULT NULL,
  `a_sex` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`a_id`)
) ENGINE=InnoDB AUTO_INCREMENT=504 DEFAULT CHARSET=utf8;

CREATE TABLE `b_table` (
  `b_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `b_2id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`b_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

```

## 插入数据
```
INSERT INTO a_table(a_name, a_sex) VALUES ('zhangsan', 1);

-- 重复执行这一句
INSERT INTO a_table SELECT null,substring(MD5(RAND()),1,20) as n, FLOOR(7 + (RAND() * 6)) as s FROM a_table;

```

## 查看数据
```
SELECT * from a_table WHERE a_name = 'dae3b8e76f03a7dfdea2'


SELECT * from a_table WHERE a_id = 1500000

```