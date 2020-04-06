
# samba 介绍


# samba安装配置
    
环境
> CentOS Linux release 7.3.1611 (Core)   
> samba

1. 使用yum 安装 samba

> yum install samba
        查看命令：rpm -qa | grep samba
        启动命令：/bin/systemctl start smb

    2. 关闭防火墙 ：
        systemctl stop firewalld.service #停止firewall
        systemctl disable firewalld.service #禁止firewall开机启动
        firewall-cmd --state #查看默认防火墙状态（关闭后显示notrunning，开启后显示running）
    
    3. 关闭 selinux：
        vi /etc/selinux/config

## samba 简单创建一个共享(三步)		
    
    作用：文件共享(需要文件权限为777)
    
    1) 创建系统用户并设置密码
        useradd username    #创建系统用户
        passwd password     #创建用户密码
    
    2) 添加到samba用户并设置密码
        smbpasswd -a username
    3) 配置共享的目录
        /etc/samba/smb.conf

## 相关知识：
    查看当前登陆用户所属组		命令 groups
    查看当前登录用户			命令 whoami
    查看某个用户属于那个组		命令 groups username
    /etc/group				文件 包含所有组名及组成员
    /etc/shadow和/etc/passwd 	文件 系统存在的所有用户名
    添加用户组				命令 groupadd
    删除用户组				命令 groupdel
    修改用户组信息				命令 groupmod

    修改用户所属组				usermod -g groupname username
    把单个用户加入[多个]组		usermod -G groupname1[,...] username
    把用户从组中删除			gpasswd -d username groupname


    创建文件夹				mkdir dirname
    创建文件					touch filename
    删除文件/目录				rm -rf
    删除空目录				rmdir

    清除windows访问smb记录	net use \\192.168.199.183 /del

## ACL(Access Controller List)
    作用：当文件权限不为777，设置文件/目录的附加权限，
    
    getfacl filename 获取文件acl信息
    setfacl filename 设置文件acl信息
    
    添加：
        setfacl -m u:username:rw filename	给filename文件设置acl权限给username
        setfacl -m u:username:rwx, g:groupname:r filename 设置用户和组
    
    删除：
        setfacl -x g:groupname filename
    
    继承ACL:
        setfacl -d --set g:groupname:rwx dirname

    1.创建linux用户，而不设置密码，该用户将不能登陆服务器
    2.将linux用户加入smb用户并设置密码，用户可通过smb访问文件

