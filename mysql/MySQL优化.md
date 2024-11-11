## 1 优化方式

  - 表设计:范式,存储引擎,字段类型
  - 功能上:索引,缓存,分区
  - SQL语句:合理的SQL
  - 架构:主从复制、负载均衡、读写分离、分表、分库

## 2 表设计
  - 范式
    - 第一范式  
        指数据库表的每一个列都是不可分割的基本数据项,猎德原子性.同一列中不能有多个值,即试题中的某个属性不能有多个值或者不能有重复的属性.  
        在任何一个关系数据库中,第一范式是对关系模型的基本要求,不满足第一范式的数据库就不是关系型数据库
    - 第二范式  
        指在满足第一范式的条件下,数据库表中的每个实例或行必须可以被唯一地区分.为实现区分通常需要为表加上一个列,以存储各个实例的唯一标识.即不能出现重复的一条数据表的记录.  
        第二范式要求实体的属性完全依赖与主关键字.所谓完全依赖是指不能存在仅依赖转主关键字一部分的属性.  
    - 第三范式  
        指在满足第二范式的条件下,要求一个数据库表中不包含已在其他表中已包含的非主关键字信息.不能有数据冗余.  
        逆范式 增加冗余,减少表链接,增加效率.
    
  - 存储引擎(show engines;)
    > 存储引擎是真正存储数据的地方

    - MyISAM(MySQL5.5)
        不支持事物、表级锁、数据和索引分开存储、适合高速插入和检索(insert,select操作)、可压缩、支持全文索引
    - InnoDB
        事务处理、行级锁、按照主键排序、支持外键,维护数据完整性(逐渐淡化)、考虑CPU效率和处理大数据的最佳性能、数据和索引存储在一起、5.6.4之后开始支持全文索引
    - 锁概念-因为资源争夺
        读锁(共享锁) – 多个进程可以同时读取某个表  
        写锁(独占锁) – 仅单个进程可以操作数据  
        MyISQM表级锁:开销小,加锁时间短.  
        InnoDB行级锁:开销大,加锁时间长
    - MyISAM和InnoDB的比较
        InnoDB:数据完整性好,并发性好.支持事物,是默认表引擎,适合银行转账等数据安全要就较高的应用  
        MyISAM:压缩存储,适合insert和select的高并发插入应用,  
        除非InnoDB不支持的特性,否则优先选择InnoDB存储引擎.  
    - 其他存储引擎
        Archive 档型. Insert select日志  
        Memory	 存行.支持insert,update,delete,select数据不能过大.  
        Merge	合并多个相同结构的MyISAM表.应用于项目中的水平拆分.单表记录过大.  
  - 字段类型(主要三个)
    - 数值型(整数和浮点数)
        整数 tinyint1 smallint2 mediumint3 int4 bigint8
        Unsigned
        浮点数(float4,double8)
        定点数 decimal 用于金钱项目时
    - 字符串型
    - 时间型(选择字段类型, 满足要求、尽量节省空间、char固定长度)

## 3 功能上
  - 索引
    > 索引也是一种结构.从数据记录里提出关键字,可以是某列,某些列,或者是列的一部分,关键字和数据记录仍然保持原来的关联关系
    ```sql
    -- 1.添加PRIMARY KEY（主键索引）  
    ALTER TABLE `table_name` ADD PRIMARY KEY ( `column` )
    -- 2.添加UNIQUE(唯一索引)   
    ALTER TABLE `table_name` ADD UNIQUE ( `column` )
    -- 3.加INDEX(普通索引) 
    ALTER TABLE `table_name` ADD INDEX index_name ( `column` ) 
    -- 4.添加FULLTEXT(全文索引)
    ALTER TABLE `table_name` ADD FULLTEXT ( `column`)
    -- 5.添加多列索引 
    ALTER TABLE `table_name` ADD INDEX index_name ( `column1`, `column2`, `column3` )
    -- 删除索引
    ALTER TABLE `table_name` DROP INDEX|UNIQUE|PRIMARY KEY `index_name` (column list);
    ```
  !> 索引的使用:SQL执行计划 SQL前加explain查看执行计划、检索时使用 WHERE、排序时使用 order by 、索引覆盖 查询时索引覆盖了数据   
  使用索引时需要注意的地方:列独立、左原则、或者两端都必须建立索引索引才有效、不使用索引的情况 查询结果均匀分布时

  - 分区  
	分区适合数据量一亿条以上的表、需要检验环境是否支持分区(未测试过)

  - 查询缓存  
    ```shell
    mysql> show variables like '%query_cache%';
    +------------------------------+---------+
    | Variable_name                | Value   |
    +------------------------------+---------+
    | have_query_cache             | YES     |
    | query_cache_limit            | 1048576 |
    | query_cache_min_res_unit     | 4096    |
    | query_cache_size             | 1048576 |
    | query_cache_type             | OFF     |
    | query_cache_wlock_invalidate | OFF     |
    +------------------------------+---------+
    6 rows in set (0.00 sec)
    ```
    !> query_cache_type | OFF | 未开启查询缓存需要在配置文件设置 query_cache_type=On|1

  - 慢日志查询
    ```
    mysql> show variables like "%slow%";
    | Variable_name             | Value      |
    | log_slow_admin_statements | OFF        |
    | log_slow_slave_statements | OFF        |
    | slow_launch_time          | 2          |时间设定
    | slow_query_log            | OFF        |是否开启
    | slow_query_log_file       | 	慢日志记录 |
    5 rows in set (0.00 sec)
    ```
## 4 SQL语句
	  TODO 根据经验总结
## 5 架构上
    TODO 根据经验总结
	
