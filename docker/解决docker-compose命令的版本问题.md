## 执行命令
```bash
qingliu@qingliu ~/stone> sudo docker-compose up -d
ERROR: client version 1.38 is too new. Maximum supported API version is 1.37
```

## docker-compose.yml
```yml
version: '3.7'
```

## 解决方法

降低yml文件中的version即可
