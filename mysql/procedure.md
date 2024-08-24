
## 创建存储过程p_debug及其日志记录表

```sql
drop table if exists d_p_debug;

create table d_p_debug
(
    id   int auto_increment comment 'id'
        primary key,
    info varchar(1024) default ''                not null,
    at   datetime      default CURRENT_TIMESTAMP not null comment '当前时间'
)
    comment '数据库存储过程debug';

create procedure p_debug(IN _str varchar(255))
begin
    insert into d_p_debug(info) values (_str);
end;
```

## 在其他存储过程中调用

```sql
call p_debug('hello')
```