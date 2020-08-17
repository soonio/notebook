命令用法记录

redis笨方法批量删除

```bash
docker run -it --rm redis redis-cli -h 192.168.1.9 -a 12345 -n 6 keys xxx* > a.txt \
&& awk '{cmd="docker run -it --rm redis redis-cli -h 192.168.1.9 -a 12345 -n 6 del "$2;print cmd}' a.txt > b.txt \
&& sed -i 's/"//g' b.txt \
&& sed -i 's/|/\\|/g' b.txt \
&& chmod +x b.txt
```

高贵冷艳的方法

```bash
docker run -it --rm redis5 redis-cli -h 192.168.1.9 -a 12345 -n 0 -p 6379 EVAL "local keys = redis.call('keys', ARGV[1]) for i=1,#keys,5000 do redis.call('del', unpack(keys, i, math.min(i+4999, #keys))) end return #keys" 0 s:*
```

