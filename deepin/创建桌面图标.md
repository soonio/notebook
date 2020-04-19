## 概述

linux操作系统软件没有可点击的图标是真的麻烦，每次需要使用命令才能打开，so还是创建软件图标方便点吧。本次以安装linux下的无快捷图标软件typora为例，创建桌面图标



> linux的软件图标通常在*/usr/share/applications/*和*/usr/local/share/applications/*中



## 1 下载解压

- 在[Typora官网](https://typora.io/)找到下载页面 
- 在linux中使用wget或浏览器直接下载
- 解压文件
- 复制解压内容到软件目录下即可

> 解压的内容就是软件，无需安装，执行文件夹中的Typora命令即可打开软件,一般可把解压内容放在/opt/package-name目录下即可



```bash
wget https://typora.io/linux/Typora-linux-x64.tar.gz
tar -zxf Typora-linux-x64.tar.gz
```





## 2 安装

```bash
mv Typora-linux-x64 /opt/typora
```



## 3 下载图标

图标可与选取官方网站中typora的图片，也可自己选择一张图,放在软件目录即可，我选择的是typora官网的一张图片

获取方式：

- 打开typora官网

> /opt/typora/ico.png



## 4 创建图标

```bash
sudo vim /usr/share/applications/Typora.desktop
```

输入以下内容

```ini
[Desktop Entry]
Type=Application
Name=Typora
GenericName=Typora
Comment=Typora:a markdown editor
Exec=/opt/typora/Typora
Icon=/opt/typora/ico.png
Terminal=typora
Categories=Typora;Development;Editor
```



## 5 说明

Desktop内容结构意思参考百度百科[Entry Desktop](https://baike.baidu.com/item/Entry%20Desktop/12021407#1)



部分软件通过快捷方式打开可能无法输入中文，如phpstorm

可以在exec的启动命令中增加*env XMODIFIERS="@im=fcitx"* 来解决

```ini
[Desktop Entry]
Version=1.0
Type=Application
Name=PhpStorm
Icon=/opt/pstorm/bin/phpstorm.png
Exec=env XMODIFIERS="@im=fcitx" "/opt/pstorm/bin/phpstorm.sh" %f
Comment=Lightning-smart PHP IDE
Categories=Development;IDE;
Terminal=false
StartupWMClass=jetbrains-phpstorm
```







