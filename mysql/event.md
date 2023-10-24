## MySQL的事件

```mysql
# 查看是否开启了事件调度
SHOW VARIABLES LIKE '%event_scheduler%';

# 列出事件列表
SHOW EVENTS;

# 列出事件最后执行事件
SELECT EVENT_SCHEMA, EVENT_NAME, LAST_EXECUTED
FROM information_schema.EVENTS
where EVENT_SCHEMA in ('seer_test', 'seer')
order by EVENT_SCHEMA;
```