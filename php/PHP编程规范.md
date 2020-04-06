# PHP程序编码规范

> 2019年10月17



## 命名规范

1. 命名前首先要知道它是什么。通过名字的提供的线索，就能明白代表的意思。
2. 常量必须只由大写字母和下划线(_)组成。如：const APP_VERSION = '1.0';
3. 变量命名使用由小写字母和下划线(_)组成。
4. 类方法命名使用驼峰规则camelCase()，命名应该清楚的说明它们是做什么的，如用动名词结构，CheckForErrors()比ErrorCheck()更合适。
5. 类的命名用Pascal命名规则，每个单词的首字母都大写ClassName()
6. 接口名字在类的原则上加前缀I，例如：IComponent。
8. 所有的属性(property)和方法(method) 必须有可见性声明；
9. 抽象(abstract)和终结(final)声明必须在可见性声明之前；而静态(static)声明必须在可见性声明之后。

```php
// Example:
abstract class ClassName
{
	protected static $foo;

	abstract protected function zim();

	final public static function bar()
	{
        // 方法主体部分
    }
}
```

10. 一条语句不可声明多个属性(property)。
11. PHP常量true, false和null 必须使用小写字母。
12. 目录和文件命名尽量只使用英文字母，目录不允许包含“.”，两者都不能包含空格和中文字符。一些重要的并且用户能直接访问到的后台管理目录不能直接使用像admin，tool之类的常用单词来命名。

## 文件

1. 所有源文件采用UTF-8编码格式保存，并且去掉BOM信息头。
2. PHP代码尽量只使用长标签(<?php ?>),不使用其他标签。
3. 所有的PHP源文件必须使用Unix LF(换行)作为行结束符。
4. 纯PHP代码源文件的关闭标签?> 必须省略。

代码行：
1. 一行代码长度建议在80字符以内，不要太长。如果太长，可以拆分成子行。
2. 一行代码不要多于一个语句。
3. 非空行最后不要有空格。
4. 类的扩展(extend)和实现(implement)关键词必须和类名(class name)在同一行。
```php
// Example:
class Foo extends Bar implements FooInterface
{

}
```

## 空行使用

1. 空行可以用来增强可读性和区分相关代码块。
2. 在命名空间(namespace)的声明下面必须有一行空行，在导入(use)的声明下面必须有一行空行。
```php
// Example:
namespace Vendor/Package;

use ClassA;
use ClassB;

//…其他php代码
```
3.	所有PHP源文件尽量以一个空行结束。

## 空格使用

1. 使用4个空格或者制表符（宽度为4个空格）来进行缩进。
2. 字符串与变量连接使用“.”号时，必须在“.”前后加空格。
```php
// Example:
$var_name = 'str_' . $var;
```
3. 方法(method)的参数在参数列表中，逗号之前不可有空格，而逗号之后则必须要有一个空格。方法(method)中有默认值的参数必须放在参数列表的最后面。
```php
// Example:
public function foo($arg1, &$arg2, $arg3 = [])
{

}
```
4. 调用一个方法或函数时，在方法名或者函数名和左括号之间不可有空格，左括号之后不可有空格，右括号之前也不可有空格。参数列表中，逗号之前不可有空格，逗号之后则必须有一个空格。
```php
// Example:
bar();
$foo->bar($arg1);
Foo::bar($arg2, $arg3);
```
5. 控制结构的关键词之后必须有一个空格。控制结构的左括号之后不可有空格。控制结构的右括号之前不可有空格。控制结构的右括号和左花括号之间必须有一个空格。控制结构的代码主体必须进行一次缩进。
- a) if条件控制结构：
```php
Example：
if ($expr1) {
    // if body
} elseif ($expr2) {
    // elseif body
} else {
    // else body;
}
```
- b) switch条件控制结构：case语句必须要缩进一级，而break关键字（或其他中止关键字）必须和case结构的代码主体在同一个缩进层级。如果一个有主体代码的case结构故意的继续向下执行则必须要有一个类似于// no break的注释。
```php
switch ($expr)
{
    case 0:
        echo 'First case, with a break';
        break;
    case 1:
        echo 'Second case, which falls through';
        // no break
    case 2:
    case 3:
    case 4:
        echo 'Third case, return instead of break';
        return;
    default:
        echo 'Default case';
        break;
}
```
- c) while循环控制结构
```php
while ($expr) {
    // structure body
}

do {
    // structure body;
} while ($expr);
```
- d) for循环控制结构
```php
for ($i = 0; $i < 10; $i++) {
    // for body
}
```
- e) foreach循环控制结构
```php
foreach ($iterable as $key => $value) {
    // foreach body
}
```
- f) try catch异常处理控制结构
```php
try {
    // try body
} catch (FirstExceptionType $e) {
    // catch body
} catch (OtherExceptionType $e) {
    // catch body
}
```

## 花括号使用
1. 类(class)、方法(method)、函数、控制结构的左花括号都不另起一行，右花括号则必须放到主体下面另起一行。
2. 使用"号自动转义变量时尽量在变量前后加“{}”。
```php
// Example：
$var_name ="file_{$var}";
```

## 其他
1. 新的程序/项目的服务器配置中，php.ini关闭error_reporting, register_globals, magic_gpc, session.auto_start，需要查看错误信息的在程序中设置，但正式上线的项目要保证及时关闭；
3. 尽量使用公共的类库（团队在开发过程中需要用到一些特定类，需要先确定框架是否已经收录了该类，如果已经有了，必须使用框架收录的类，如果没有则考虑是否将此类加入框架类库，框架类库将统一进行更新版本）；
4. 每个类库/程序文件都要按统一的格式写上说明和注释；PHP版本需要>=7.0
- a) 文档注释
```php
/**
 * 图片处理类(简述)
 *
 * 可实现剪裁、缩放、水印等功能
 * 支持旋转，加文字等功能
 * (详细的功能描述，不够换行继续)
 *
 * @copyright Copyright (c) 2005 - 2009 TM WebSoft Inc. (http://www.demo.cn)
 * @author xxx
 * @package Core
 * @version $Id: image.php,v 1.0 2009.03.13 09:30:48 JJC Exp $
 */
```
- b) 方法或函数注释
```php
/**
 * 取出指定名称的设置值
 *
 * example:
 * <code>
 * setAppInf(‘page_title’, ‘标题’);
 * .....
 * $siteTitle = getAppInf('siteTitle');
 * </code>
 *
 * @param string $option
 * @param mixed $default
 *
 * @return mixed
 */
function getAppInf($option, $default = null)
{
  …
}
```

5. 单数据库多个项目的数据库表命名规范，项目所有对应的数据表需要加统一的前缀
6. 数据库名、数据表名、字段名全部用小写，多个单词间用下划线_连接；查询语句SQL中，关键字一律用大写字母，字段名用定界符包含起来(如：\`字段名\`)。
7. 保证安全可靠，必要的过滤和防护要做到位，如：SQL注入、XSS攻击、CC攻击等，密码等敏感数据不能明文放在Cookie中，特别是输入参数处理，生成的JS（供其它站点调用）过滤等 。
