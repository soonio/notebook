## 构建

```bash
docker build -t image:version .
```

## 运行

```bash
docker run -it --rm -p 80:80 -v $(pwd):/home --name=test image:version sh
```

## 进入

```bash
docker exec -it test sh
```

## 拉取镜像

```bash
docker pull redis
```

## 日志删除

```bash
#!/bin/sh

case $1 in
'info')
    logs=$(find /var/lib/docker/containers/ -name *-json.log)
    for log in $logs
    do
        ls -lh $log | awk '{print $5}'
        $log | egrep '([^<>/\\\|:""\*\?]+)\.\w+$'
    done
    ;;
'delete')
    logs=$(find /var/lib/docker/containers/ -name *-json.log)
    for log in $logs
        do
            echo "clean logs : $log"
            cat /dev/null > $log
        done
    ;;
*)
    echo "no valid parameter!!!";
esac
```

