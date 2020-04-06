# 使用shell登陆远程服务器

## 脚本
```bash
#!/usr/bin/expect

set user root
set host 100.100.100.100
set password 123456
set dsn $user@$host
set notice [format "$dsn's password"];
set timeout 30
spawn ssh $dsn
expect "$notice"
send "$password\r"
interact
```
