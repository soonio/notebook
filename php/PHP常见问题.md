
# 1.MVC模式的认识
mvc既是软件工程中的一种软件架构模式.  
把软件系统分为三个基本部分

    模型(model)|视图(view)|控制器(controller)

mvc的优点
    
    低耦合性|高重用性和可实用性|较低的生命周期成本|快速部署|可维护性|有利于软阿健工程化管理

# 2.比较类问题
## get|post的区别

误区：post比get能够传送更多的信息,http协议没有对post和get的大小做限制,是浏览器或服务器单方面的进行了限制

get请求的数据会附在URL之后,以?分割,把数据放在http协议head中  
post吧提交的数据放置在http包的body中  
post安全性比get高  
get从服务器获取数据,post向服务器提交数据？？？  
post能发送未知的字符

## session|cookie的区别
1.cookie数据保存在客户端,session数据保存在服务器  
2.cookie不是很安全,别人可以分析存放在本地cookie进行cookie欺骗  
3.session会在一定时间内保存在服务器上.当访问增多,会比较占用服务器性能,考虑到减轻服务器性能压力,可使用cookie  
4.单个cookie保存的数据不能超过4K,很多浏览器都限制一个站点最多保存20个cookie.  
5.session保存重要数据,session保存一般数据  
    
##  print echo var_dump区别
1.echo 能够输出一个以上的字符串  
2.print 只能输出一个字符串,并始终返回1  
3.var_dump() 打印变量相关信息  
4.print_r() 打印变量易于理解的信息  
5.printf() 输出格式化字符串  
echo 比print函数运行速度快一点点  
    
## require 和include的区别
用途基本一样
incluce 通常放到流程控制里面，用到的时候加载，加载失败显示警告  
require 通常放到程序的前面，PHP程序执行前，先把文件加载进来，加载失败致命错误
    
# 面向对象
## 接口的定义
使用 interface 关键字 ,接口中所有方法必须定义成public, 且不含有方法体.
```
interface Demo
{
    public function funcOne();
    
    public function funcTwo();
}

```

## 使用 implement 实现多个接口
```
class Child extends Parent implemtns Interface1, Interface2, ...
{
    ......
}
```

接口是为了弥补单继承？

`注:instanceof 是一个运算符,用于验证实例是否是类实例化而来的.`


- 三大特性：封装、继承、多态
- 权限问题：

        protected public private final

final用于类、方法前，final类，不可被继承，final方法，不可被覆盖 

- 魔术方法：
```
__construct()
__destruct()
__call()
__callStatic()
__get()
__set()
__isset()
__unset()
__sleep()       : 序列化之前执行的方法
__wakeup()      ：逆序列化之前执行的方法
__toString()    ：当类被当成字符串echo的时候，调用，该方法必须返回一个字符串。
__invoke()      ：当尝试以调用函数的方式调用一个对象时，该方法会被自动调用。 
__set_state()
__clone()
__debugInfo() 
```

## 接口和抽象类的区别是什么?

- 抽象类  
    一种不能被实例化的类，只能作为其他类的父类来使用。
    抽象类是通过关键字abstract来声明的。 
    抽象类与普通类相似，都包含成员变量和成员方法，
    抽象方法的格式为：abstract function abstractMethod();
- 接口  
    通过interface关键字来声明的，接口中的成员常量和方法都是public的，方法可以不写关键字public，接口中的方法也是没有方法体。
    接口中的方法也天生就是要被子类实现的。
- 区别  
    两者的区别在于，抽象类中至少要包含一个抽象方法，抽象方法没有方法体，该方法天生就是要被子类重写的。
    抽象类和接口实现的功能十分相似，最大的不同是接口能实现多继承。在应用中选择抽象类还是接口要看具体实现。
    子类继承抽象类使用 extends，子类实现接口使用 implements。

常见问题
1. 从URL中获取文件扩展名
```
parse_url($url);//解析url为数组
basename($arr[path]);//获取文件名
explode('.', $filename);//分割文件名和扩展名为数组
```

2. 文件操作
