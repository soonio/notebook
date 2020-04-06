

## 拉取镜像
```
docker pull redis
```

## 启动命令
```bash
docker run  -d \
  --name redis \
  -v /data/redis:/data \
  -p 6379:6379 \
  --restart unless-stopped \
  redis redis /data/redis.conf --appendonly yes
```
注: /data目录下有redis.conf文件

## 目录说明
本地 /data/redis: 用于存储redis的持久化数据

## redis-5.0.4 配置文件
[redis](redis.conf)
不要忘记设置密码和开放云服务器端口哦
