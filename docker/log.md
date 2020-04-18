## 查询

```bash
#!/bin/sh

logs=$(find /var/lib/docker/containers/ -name *-json.log)  

for log in $logs
	do
		ls -lh $log
	done
```


## 删除
```bash

#!/bin/sh
logs=$(find /var/lib/docker/containers/ -name *-json.log)

for log in $logs
	do
		echo "clean logs : $log"
		cat /dev/null > $log
	done
```

