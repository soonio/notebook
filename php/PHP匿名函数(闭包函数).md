
# 匿名函数
匿名函数（Anonymous functions），也叫闭包函数（closures），允许 临时创建一个没有指定名称的函数。最经常用作回调函数（callback）参数的值。当然，也有其它应用的情况

#### 示例1

```
<?php
    echo preg_replace_callback(
        '~-([a-z])~',
        function ($match) {
            return strtoupper($match[1]);
        },
        'hello-world'
    );
    // 输出 helloWorld
?>
```
闭包函数也可以作为变量的值来使用。PHP 会自动把此种表达式转换成内置类 Closure 的对象实例。把一个 closure 对象赋值给一个变量的方式与普通变量赋值的语法是一样的，最后也要加上分号：

#### 示例2  

```
<?php
    $greet = function($name)
    {
        printf("Hello %s\r\n", $name);
    };

    $greet('World');
    $greet('PHP');
?>
```

未完待续...