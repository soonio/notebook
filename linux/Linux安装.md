
1. 安装centOS
   
     最小安装:628M->256M
        分区:boot-200m|swap-2G|root-other

2. 关闭防火墙

    关闭iptables    setup命令
    
    关闭selinux     vi /etc/selinux/config    selinux=disabled 重启生效

3. 启动网络
    
    ```
    vi /etc/sysconfig/network-scripts/ifcfg-eth0 ->ONBOOT="yes"
    service restart network
    ```

4. 配置yum

5. 安装samba