
#   Linux常识：

## 1. 文件命名规则
	Windows:   / \ | ? * < >  CON  以点开头，默认都不能作为文件名使用
	Linux：除了/之外，所有的字符都合法
	
	有些字符最好不要用：空格、制表符、退格符、@#$&()- 等 (空格是命令间的分隔符)
	避免使用点(.) 作为普通文件名的第一个字符(点开头的是Linux隐藏文件)大小写敏感

## 2. linux命令的格式
    命令  [选项]  [参数]
    例：ls	即	list	显示目录下内容
        命令名称：ls
        命令英文原意：list
        命令所在路径：/bin/ls
        执行权限：所有用户
        功能描述：显示目录文件

    ls      直接回车，显示当前目录下内容
    ls -l   长格式显示		(缩略选项用一个减号，完整选项用两个减号)
    -rw-------    1   root    root    1190    08-10 23:37     anaconda-ks.cfg

    第一项：	权限位	
    第二项： 1		引用计数
    第三项： root		所有者
    第四项： root   	属组
    第五项： 大小	
    第六项：	最后一次修改时间
    第七项：	文件名
    
    ls命令常用组合：
    ls  -a   	显示所有文件（包含隐藏文件）
    ls  -al		多个参数可合并简写（大多可无序组合）
    ls  -h		文件大小显示为常见大小单位	B	KB	MB
    ls  -d		显示目录本身，而不是里面的子文件
    
### 文件颜色及类型
    1）默认色代表普通文件。  例：install.log
    2）绿色代表可执行文件。  例：rc.news
    3）红色代表tar包 文件。 例：vim-7.1.tar.bz2
    4）蓝色代表目录文件。  例：aa
    5）洋红代表图象文件。  例：Sunset.jpg
    6）青色代表链接文件。  例：rc4.d     （此类文件相当于快捷方式）
    7）黄色代表设备文件。  例：fd0
    8）背景红色代表损坏的链接文件。例：rc4.d
    
    更多的文件颜色规则详见：/etc/DIR_COLOR

## 3. 常见文件类型
    - 	普通文件
    l	链接文件
    d	目录文件
	
## 4. 命令提示符：
    [root@localhost src]#
    [当前登录用户@主机名 当前所在目录]#
    
        #		超级用户
        $		普通用户

    当前所在目录：		~		用户家目录	
        管理员		/root
        普通用户		/home/用户名

## 5. Linux系统严格区分大小写，包括命令和文件名

# 一 	目录操作命令

##  1）	cd	切换所在目录
    
    命令名称：cd
    命令英文原意：change directory
    命令所在路径：shell内置命令
    执行权限：所有用户

    cd  /usr/local/src

    相对路径：参照当前所在目录，进行查找。一定要先确定当前所在目录。   						cd  ../usr/local/src
    绝对路径：从根目录开始指定，逐级递归查找。在任何目录下，都能进入指定位置。
    cd  /usr/local/src	
    建议：初学者多使用绝对路径。

    cd  ~		进入当前用户的家目录		/root		/home/aa/
    cd			进入当前用户的家目录
    cd  -		进入上次目录
    cd  ..		进入上一级目录
    cd  .		进入当前目录

##  2)	pwd	显示当前所在目录
    命令名称：pwd
    命令英文原意：print working directory
    命令所在路径：/bin/pwd
    执行权限：所有用户

##  3）	linux常见目录
    /		根目录
    /bin	命令保存目录（普通用户就可以读取的命令）
    /boot	启动目录，启动相关文件
    /dev	设备文件保存目录
    /etc	配置文件保存目录
    /home	普通用户的家目录
    /lib	系统库保存目录
    /mnt	挂载目录
    /root	超级用户的家目录
    /tmp	临时目录	（重启后可清空）
    /sbin	命令保存目录（超级用户才能使用的目录）
    /proc	记录服务器内存及cpu情况的的动态文件系统
    /sys	同上
    /usr	系统软件资源目录
        /usr/bin/		    系统命令（普通用户）
        /usr/sbin/		    系统命令（超级用户）
        /usr/local/		    常用安装软件目录
    /var    系统相关文档内容
        /var/log/		    系统日志位置
        /var/spool/mail/	系统默认邮箱位置
        /var/lib/mysql/		默认安装的mysql的库文件目录
        
##  4）	建立目录
    mkdir  目录名
    命令名称：mkdir
    命令英文原意：make directories
    命令所在路径：/bin/mkdir
    执行权限：所有用户
    
    mkdir  -p  11/22/33/44		-p	递归
    
##  5）	删除目录
    rmdir  目录			只能删除空目录
    命令名称：rmdir
    命令英文原意：remove empty directories
    命令所在路径：/bin/rmdir
    执行权限：所有用户

    rm  文件名		删除文件

    rm  -rf	目录		删除文件和目录
        -r  			递归，删除目录
        -f			强制，取消询问模式

#   文件操作命令

##  1）创建空文件或修改文件时间
    touch  文件名
    命令名称：touch
    命令所在路径：/bin/touch
    执行权限：所有用户

##  2）删除
    rm  -rf  文件名
        -r  删除目录
        -f	强制
    命令名称：rm
    命令英文原意：remove
    命令所在路径：/bin/rm
    执行权限：所有用户
    
##  3）cat  文件名		查看文件内容。从头到尾
    命令名称：cat
    命令所在路径：/bin/cat
    执行权限：所有用户

    -n	列出行号
    
##  4）more  文件名	分屏显示文件内容
    命令名称：more
    命令所在路径：/bin/more
    执行权限：所有用户

    空格向下翻页			b   向上翻页		q  退出
    
##  5） head  文件名 	显示文件头
    命令名称：head
    命令所在路径：/usr/bin/head
    执行权限：所有用户

    head  -n  行数   文件名		指定显示文件头几行
    head  -n  20  文件名
    head  -20  文件名
    
    tail -n 行数 文件名		指定显示文件尾行
    
##  6）	链接文件		
    ln
    命令名称：ln
    命令英文原意：link
    命令所在路径：/bin/ln
    执行权限：所有用户
    
    ln  -s  源文件  目标文件			//软链接，相当于windows快捷方式
    ln		源文件	目标文件			//硬链接，拷贝加同步更新，
                                    //不能给目录，不能跨分区
    文件名都推荐写绝对路径，否则软连接移后失效		

#   文件和目录都能操作的命令
    
##  1）复制
    命令名称：cp
    命令英文原意：copy
    命令所在路径：/bin/cp
    执行权限：所有用户
    
    cp  源文件  目标位置
    
        -r  复制目录
        -p	连带文件属性复制
        -d	若源文件是链接文件，则复制链接属性
        -a	相当于  -pdr
    
    cp  aa  /tmp/		原名复制
    cp  aa  /tmp/bb		改名复制
    
    
##  2）剪切或改名
    命令名称：mv
    命令英文原意：move
    命令所在路径：/bin/mv
    执行权限：所有用户
    
    mv  源文件  目标位置
    mv  /root/aa  /tmp/
    mv  aa  bb

#   权限管理（难点）
##  1. 分析权限位
    -rw-r--r--   1   root root     0 08-11 01:45 abc
    
    权限位是十位
    第一位：	代表文件类型
        -	普通文件
        d	目录文件
        l	链接文件	
    
    后九位：属主权限u    属组权限g     其他人权限o
    
        r	读		4
        w	写		2
        x	执行	    1
    
## 2. 修改权限
    chmod
    命令名称：chmod
    命令英文原意：change the permissions mode of a file
    命令所在路径：/bin/chmod
    执行权限：所有用户
    
    逻辑描述法：
    chmod  u+x  aa		aa文件的属主加上执行权限
    chmod  u-x  aa		aa文件的属主减去执行权限
    chmod  g+w,o+w  aa	多个身份用“，”分隔
    chmod  u=rwx  aa		aa文件的属主不考虑当前权限直接赋予指定权限
    chmod  a-x	aa		a代表所有身份（u,g,o）
    
    数字描述法：
    chmod  755  aa		
    chmod  644  aa
    

	
    问：root用户创建一个目录(默认rwxr-xr-x)，在目录中新建一个文件，然后将新建的文件设为777，普通用户能否删除该文件?
    答：
	useradd 用户名	#添加用户
    passwd 用户名	#为用户设置密码
    重新开一个终端，用新建的用户登录进行实验
	
    结果：失败
	
    原因：rwx权限对于目录和文件，实际意义是不一样的

	文件:	
	r	cat  more  head  tail   	查看文件内容
	w	echo  vi					修改文件内容
	x	sh 	(execute)				执行	
	目录:
	r	ls  find  tree			列出文件
	w	touch  mkdir  rm		创建删除文件
	x	cd						进入目录

    结论：
    对文件有写权限，只代表可以修改这个文件，要想删除文件，需要对文件所在目录有写权限。
	只要对目录有写权限，目录中的文件，就算是root创建的，普通用户一样能删除。
	

    赋予权限要合理
	对目录w权限，就意味着需要有rwx
    对脚本执行，需要rx 并对该目录有rx权限

##  3. 修改属主和属组
    
    命令名称：chown
    命令英文原意：change file ownership
    命令所在路径：/bin/chown
    执行权限：所有用户
    
    chown  用户名  文件名	改变文件属主
    
    chown  user1  aa			user1必须存在
    
    chown  user1:user1  aa	改变属主同时改变属组	
    
    chgrp  组名	文件名		改变文件属组
    
    -R  
    
    问：为何新建文件权限644，新建目录755？

##  4. 创建文件的默认权限掩码值

    umask	显示0022
    第一位特殊权限位，不提
    其他为三类用户的权限掩码值，用做大权限777减去掩码值
          777
         - 022
    --------------
          755
    就是创建文件的默认权限
    
    疑问：
    新建目录mkdir 	test		默认是755权限
    新建文件touch 	file     	默认是644权限
    
    解答：
    Linux安全机制，不给新建文件X权限。

#   帮助命令

##  1 man (查看有文件实体的命令的帮助)

    命令名称：man
    命令英文原意：manual
    命令所在路径：/usr/bin/man
    执行权限：所有用户

##  2 help(查看shell内核命令)

#   查找命令

##  1 whereis 查找命令的命令，同时看到帮助文档位置

    命令名称：whereis	
    命令所在路径：/usr/bin/whereis
    执行权限：所有用户
    which	相同，可看到命令别名

##  2 find	搜索文件命令	
		
    正则知识：
    通配符——常用于文件查找
    *		任意字符任意多个
    ?		任意字符一个
    [] 	指范围值
    ^		反向匹配
    正则表达式——常用于内容查找
    . 	除换行外任意符号
    *		任意个
    ? 	0或1个
    ^		开头

    命令名称：find
    命令所在路径：/usr/bin/find
    执行权限：所有用户

    1.按照文件名查找
        find  查找位置   -name  文件名
        find  	/  		-name  aabbcc		精确查找文件aabbcc
        find	/etc	-name	init*		查找在/etc下以init开头的文件			
    2.按照用户
        -user  用户名		按照属主用户名查找文件
        -group  组名		按照属组组名查找文件				
    3.按照文件大小
        -size		+50k：大于50k，-50k：小于50k，50k：等于50k		k	M
        find  /  -size  +50k	查找/下大于50k的文件
        默认单位512Byte
    4.按照类型
        -type 类型 		按照文件类型查找		f：普通		d：目录		l：链接
    5.按照权限
        find  /root  -perm  644		按照权限查找		
    6.按照文件名（不区分大小写）
        -iname			按照文件名查找，不区分大小写
    7.按照i节点
        -inum			按照i节点查找
        find / -inum 	2739078

    逻辑连接符	-a（and）	-o（or）
        多条件查找，条件之间可加逻辑连接符
        find /etc –size -10M	-a	-size	+1M	查找小于10M并大于1M的文件
    
    对查找到的文件，进一步处理
	find  ...  -exec 命令 {}  \;

    {}	表示find查询的结果集
    \	是转义符  表示一个命令或符号使用其本身的意义，不使用别名
    ;	分号是表示语句的结束
    {} \;	固定格式，只能这样写。注意中间的空格。

    转义符的作用是什么？
	在linux中有一个别名机制，如rm删除文件，执行的却是rm -i(用which rm 可以查看命令别名)，使用rm删除文件前会提示，就是因为rm -i这个参数。如果想使用命令原意，可以在加\转义，
    如：\rm test.txt   则不会提示，直接删除


    实例：
    找到文件后查看详情:
    find /etc -name inittab -exec ls -l  {}  \;
    find /etc -name init* -a -type f -exec ls -l {} \;  要过滤掉目录，只列出文件，否则ls会列出很多文件
    
    找到testfile后，直接删除，默认不需要确认，直接删除，也不需要加-f选项
    find /test -name testfile -exec rm {}  \;
    
    找samlee用户的所有文件并删除
    find /home -user samlee -exec rm –r  {}  \;
    
    找samlee用户的所有文件并删除，删除前会一个提示确认
    find /home -user samlee -ok rm -r {} \;

    结合使用:查二进制文件并显示详情
    find /etc -name init* -a -type f -exec ls -l {} \;


##  3 grep	“字符串”  文件名	查找符合条件的字串行。
    命令名称：grep
    命令所在路径：/bin/grep
    执行权限：所有用户
    
    grep  -i  “root”  /etc/passwd
        -v		反向选择
        -i 		忽略大小写
    
    find:	在系统当中搜索符合条件的文件名，如果需要匹配，使用通配符匹配。通配符是完全匹配。
    grep：	在文件当中搜索符合条件的字符串，如果需要匹配，使用正则表达式匹配，正则表达式是包含匹配

七	压缩和解压缩
		
    .gz		.bz2		linux可以识别的常见压缩格式	
    .tar.gz	.tar.bz2	常见的压缩和打包命令
    
    压缩同时打包
        tar  -zcvf  压缩文件名  源文件
        tar  -zcvf  aa.tar.gz  aa
            -z  压缩.gz格式		-j	压缩.bz2格式
            -c：打包
            -v：显示压缩过程
            -f：指定压缩包名
        注意：选项f必须在最后，否则报错。
        tar  -zxvf  压缩文件名			解压缩同时解打包
            -x	解压缩
    
    查看不解包
        tar  -ztvf  aa.tar.gz		查看不解包
        tar  -jtvf  aa.tar.bz2
            -t  只查看，不解压
    
        tar -jxvf root.tar.bz2 -C /tmp/	指定解压缩位置

#   网络命令
## 1 ping	测试网络连通性
    命令名称：ping
    命令所在路径：/bin/ping
    执行权限：所有用户
    
    ping  -c  次数  ip		探测网络通畅
    
##  2 ifconfig  		查询本机网络信息
    
    类似windows中的ipconfig	/all
    
    命令名称：ifconfig
    命令英文原意：interface configure
    命令所在路径：/sbin/ifconfig
    执行权限：root
    可临时修改网卡IP地址
    ifconfig	eth0	192.168.1.1		mask 255.255.255.0
    

#   关闭和重启命令
    
## 1 shutdown  -h  now			没有特殊情况，使用此命令
    -h	关机
    -r	重启
    
    shutdown  -r  now		等同于	reboot
    
    命令名称：shutdown
    命令所在路径：/sbin/shutdown
    执行权限：root	
    
##  reboot
    命令名称：reboot
    命令所在路径：/sbin/reboot
    执行权限：root
		
#   挂载命令
    
    linux所有存储设备都必须挂载使用，包括硬盘。硬盘开机自动挂载，但多媒体（光盘，U盘等）需要手动挂载。
    命令名称：mount
    命令所在路径：/bin/mount
    执行权限：所有用户
    
    光盘挂载
    /dev/sda1	第一个scsi硬盘的第一分区
    /dev/cdrom	光盘设备软连接		（方便记忆）
    /dev/hdc	光盘设备名			centos  5.5
    /dev/sr0	光盘设备名			centos 	6.x
    以上三个文件都是一回事儿，版本不同而已。
    mount  -t  文件系统  设备描述文件  挂载点（已经存在空目录）
    mount  -t  iso9660  /dev/cdrom  /mnt/cdrom
    
    光盘卸载
    umount  /dev/cdrom 
    umount  /mnt/cdrom 		强调：退出挂载目录，才能卸载
    
    U盘挂载：虚拟机USB设备存在，鼠标焦点在虚拟机内部，而不是外部主机，否则被外部主机识别为U盘
    fdisk  -l	查看设备识别情况，U盘插入后会识别为sdb
    mount  -t  vfat  /dev/sdb1  /mnt/usb
    
    CentOS6.x系列挂载时不需要制定-t类型也能自动识别挂载成功！！

服务器管理规范：
	越是安全等级要求高的服务器，越是严格限制用户等级，不能所有人都是root，远程服务器不能关机。
	服务器不允许在负载高峰执行高负载命令。例如杀毒、大数据压缩解压缩，复制，全盘搜索。
