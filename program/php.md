## 面向对象
  - interface | implement
  - abstract class | extends
  - class | private/protected/public | final
  - trait | use
  - php中的的面向对象
    - interface和abstract class的区别
    - trait的作用与用法、场景

## 设计模式
  - IOC
  - MVC  
    优点:低耦合性|高重用性和可实用性|较低的生命周期成本|快速部署|可维护性|有利于软件工程化管理
  - 代理模式
    为其他对象提供一种代理以控制对这个对象(元素)的访问(php的__set、__get方法)


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
