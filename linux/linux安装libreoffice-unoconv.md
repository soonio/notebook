
## 1. 查询一下系统自带的安装包

```
[root@izwz9g9o4m3lz11os7jy9uz ~]# yum search libreoffice
Loaded plugins: fastestmirror
Loading mirror speeds from cached hostfile
===========================N/S matched: libreoffice ===========================
libreoffice-TexMaths.x86_64 : A LaTex Equation Editor for LibreOffice
···
libreoffice.x86_64 : Free Software Productivity Suite
···
```

## 2. 安装libreoffice.x86_64
找到以下文件
```
libreoffice.x86_64 : Free Software Productivity Suite
```

```
yum install libreoffice.x86_64
```

## 3. 启动服务
```
[root@izwz9g9o4m3lz11os7jy9uz ~]# /usr/lib64/libreoffice/program/soffice.bin soffice --accept="socket,host=127.0.0.1,port=8100;urp;" &
[1] 28949

```

## 4. 安装unoconv
```
[root@izwz9g9o4m3lz11os7jy9uz ~]# yum install unoconv
```

## 即可正常转换
```
[root@izwz9g9o4m3lz11os7jy9uz ~]# unoconv -f pdf xx.docx
Segmentation fault
[root@izwz9g9o4m3lz11os7jy9uz ~]# ls
xx.docx  xx.pdf

```

# 字体乱码问题
把C:\WINDOWS\Fonts下的所有字体文件加压到win.zip文件中

然后上传到服务器

```
unzip win.zip
mv win /usr/share/fonts
```
```
cd /usr/share/fonts/win
//加载字体  
mkfontscale  
mkfontdir  
fc-cache –fv 
```

重启生效
```
reboot
```