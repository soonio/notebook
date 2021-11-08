## 面向对象
  - interface | implement
  - abstract class | extends
  - class | private/protected/public | final
  - trait | use
  - php中的的面向对象
    - interface和abstract class的区别
    - trait的作用与用法、场景
  - 封装  
  在我的理解封装有多个层面，如文件、命名空间、类库、方法、属性、可见性等。具体到PHP，如同一个文件中的不同命名空间，同一个命名空间中不同的类，同一个类中不同功能的成员方法、以及不同的可见性修饰符。
  - 继承  
  继承依赖封装，在对一些基础功能、特性进行抽象封装为一个接口或抽象类，便于相关的具体实现类复用或者约束
  - 多态  
  多态字面意思是多种状态。具体到编程语言中，就是同一个接口，不同的实现。具体到PHP，如同一个持久化接口，可以有mysql、mongodb、redis、本地文件系统、远程云存储等实现。具体作用就是屏蔽差异，能够写出通用代码。



## 设计模式

  - Singleton  
    单例只能实例化一次构造方法/静态方法数据库
  - Multiton  
    多例多次实例构造方法/静态方法
  - Proxy  
    代理中间层,省事__call()方法
  - Facade  
    外观隔离应用程序和子系统
    类方法合理委托
  - Decorator  
    装饰者动态添加功能装饰类与被装饰类继承同一个抽象方法,具体装饰类继承装饰类重复装饰问题
  - Factory  
    工厂根据需求实例化对象switch 需求
  - Observer
    观察者观察者和分派对象相互感知
  - Publicher/subscriber
    发布者/订阅者不需要相互感知
  - IOC(DI)  
    从具体的业务功能对象来看，是控制反转。业务功能对象所依赖的对象不是由自己具体创建，而是由一个第三方容器服务对象去管理创建。    
    从第三方容器服务对象来看，是依赖注入。业务功能对象依赖的类库由容器服务器主动注入。

  !> 如业务功能对象依赖抽象的持久化对象，第三方容器服务根据持久化的抽象实例化对象，并注入给业务功能对象

  > 依赖倒置原则  
  > a.高层模块不应该依赖于底层模块，二者都应该依赖于抽象。  
  > b.抽象不应该依赖于细节，细节应该依赖于抽象。

  - MVC  
    优点:低耦合性|高重用性和可实用性|较低的生命周期成本|快速部署|可维护性|有利于软件工程化管理

## 其他
  - 匿名函数
    匿名函数(Anonymous functions)，也叫闭包函数(closures)，允许临时创建一个没有指定名称的函数。最经常用作回调函数(callback)参数的值。当然，也有其它应用的情况
    ```php
    echo preg_replace_callback('~-([a-z])~', function ($match) { return strtoupper($match[1]); }, 'hello-world'); // 输出 helloWorld
    $greet = function(string $name) { return sprintf("Hello %s\r\n", $name); };
    $greet('World');
    $greet('PHP');
    ```
  - 有序数组问题
    ```php
    # json_encode后会丢失索引
    $map = [0 => 'php', 1 => 'go', 2 => 'javascript'];
    echo json_encode($map); // ["php","go","javascript"]
    
    $tmp = new \stdClass();
    foreach ($map as $key => $value) {
    $tmp->{"{$key}"} = $value;
    }
    echo json_encode($tmp); // {"0":"php","1":"go","2":"javascript"}
    ```
