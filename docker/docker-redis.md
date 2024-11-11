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



