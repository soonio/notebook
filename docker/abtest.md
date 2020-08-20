## 基于docker的ab压测



```bash
docker pull mocoso/apachebench

# 最后一个斜杠必须写
docker run --rm mocoso/apachebench ab -n 1000 -c 200 http://192.168.1.10/
```

