

## 配置

```json
# /etc/docker/daemon.json
{
  "log-driver": "json-file",
  "log-opts": {
    "max-size": "10m",
    "max-file": "7" 
  }
}
```

[配置参考地址](https://docs.docker.com/config/containers/logging/json-file/)

## 查询bash

```bash
#!/bin/sh

logs=$(find /var/lib/docker/containers/ -name *-json.log)  

for log in $logs
	do
		ls -lh $log
	done
```


## 删除bash
```bash

#!/bin/sh
logs=$(find /var/lib/docker/containers/ -name *-json.log)

for log in $logs
	do
		echo "clean logs : $log"
		cat /dev/null > $log
	done
```

