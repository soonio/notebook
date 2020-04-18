## 启动命令
```bash
# 创建空的redis配置文件，可以把本文中简化版的配置文件写入redis.conf
mkdir -p /data/db/redis && touch /data/db/redis/redis.conf

docker run  -d \
  --name redis \
  -v /data/db/redis/data:/data \
  -v /data/db/redis/redis.conf:/etc/redis.conf \
  -p 6379:6379 \
  --restart unless-stopped \
  redis /etc/redis.conf --appendonly yes
```
注: /data目录下有redis.conf文件

## 目录说明
本地 /data/redis: 用于存储redis的持久化数据

## 安全

- 设置密码
- 指定IP访问

## 配置文件

[redis5.0.4配置文件](https://github.com/ruoge3s/ruoge3s.github.io/blob/master/docker/redis.conf)

## 简化版配置文件

```

# bind 127.0.0.1

protected-mode yes
port 6379

tcp-backlog 511

timeout 0

tcp-keepalive 300

daemonize no
supervised no

pidfile /var/run/redis_6379.pid

loglevel notice

logfile ""

databases 16

always-show-logo yes

save 900 1
save 300 10
save 60 10000

stop-writes-on-bgsave-error yes

rdbcompression yes
rdbchecksum yes
dbfilename dump.rdb
dir ./

replica-serve-stale-data yes

replica-read-only yes
repl-diskless-sync no
repl-diskless-sync-delay 5
repl-disable-tcp-nodelay no
replica-priority 100

requirepass 123456

lazyfree-lazy-eviction no
lazyfree-lazy-expire no
lazyfree-lazy-server-del no
replica-lazy-flush no

appendonly no
appendfilename "appendonly.aof"
appendfsync everysec
no-appendfsync-on-rewrite no

auto-aof-rewrite-percentage 100
auto-aof-rewrite-min-size 64mb

aof-load-truncated yes

aof-use-rdb-preamble yes

lua-time-limit 5000

slowlog-log-slower-than 10000
slowlog-max-len 128

latency-monitor-threshold 0
notify-keyspace-events ""

hash-max-ziplist-entries 512
hash-max-ziplist-value 64
list-max-ziplist-size -2
list-compress-depth 0
set-max-intset-entries 512
zset-max-ziplist-entries 128
zset-max-ziplist-value 64
hll-sparse-max-bytes 3000

stream-node-max-bytes 4096
stream-node-max-entries 100

activerehashing yes

client-output-buffer-limit normal 0 0 0
client-output-buffer-limit replica 256mb 64mb 60
client-output-buffer-limit pubsub 32mb 8mb 60

hz 10
dynamic-hz yes
aof-rewrite-incremental-fsync yes
rdb-save-incremental-fsync yes
```

