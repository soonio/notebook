## 免密登录

### 创建密钥

```bash
ssh-keygen	
```

> 一般情况下，一路enter就好，默认生成到当前用的家目录的.ssh文件夹

### 发送公钥

```bash
ssh-copy-id root@192.168.1.110
```

> 需要确认一下和要输入一次密码，如果不想远程服务器询问，可以修改

### 核验

```bash
ssh root@192.168.1.110
# 结果发现无需密码即可登录
```

## 使用私钥登录

> 和免密登录类似

### 生成密钥

```bash
ssh-keygen -C "goodman@qq.com" -f ./filenane
```

> -C 备注的意思，在公钥中加上备注便于在服务器上区分是谁的公钥
>
> -f 生成的文件名称

### 上传公钥到服务器

```bash
ssh-copy-id -i ~/filenane.pub root@192.168.1.110
```

## 使用私钥登录服务器

```bash
ssh -i ~/filenane root@192.168.1.110
```





