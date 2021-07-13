## 目的

为了形成规范化，统一化的编码方式及风格，高效的传递及理解信息。

## 命名

1. 见名知意。需要知道要命名的东西是什么，再选择[通俗易懂](https://baike.baidu.com/item/%E9%80%9A%E4%BF%97%E6%98%93%E6%87%82/1515018)的名字，这样使协作者可以通过名字就能明白其代表的意思。如果缩写或者简写的，尽可能加上有效准确的注释增加理解。
2. 变量名，全部以小驼峰法为命名为标准，如 $fooNameLength。
3. 常量名，全部以大写字母与下划线(_)的组合命名，如 TYTPE_CANCEL。
4. 方法名，全部以小驼峰法为命名为标准，如getFooNameLength()。
5. (抽象)类、接口、trait、接口名全部以大驼峰法命名，如 StudentExtInfo。
6. 目录名、文件名只能用使用英文字母,不能有空格，且目录名不能包含点(.)

## 文件

1. 所有php源文件采用UTF-8编码格式保存，并且去掉BOM信息头。
2. PHP代码只使用标准的长标签(<?php ?>)，不使用其他标签。
3. 所有的PHP源文件必须使用Unix LF(换行)作为行结束符。
4. 纯PHP代码源文件的关闭标签?> 必须省略。
5. 遵循psr-4的规则，文件夹的命名要和命名空间契合，如文件夹Foo/Bar, 命名空间为namespace Foo/Bar。

## 代码行

1. 一行代码长度建议在80字符以内，不要太长。如果太长，可以拆分成子行(可以依托phpstorm默认的代码长度警戒线作为参考)。
2. 一行代码不要多于一个语句。
3. 非空行最后不要有空格。
4. 类的扩展(extend)和实现(implement)关键词必须和类名(class name)在同一行。
5. 使用空行可以用来增强可读性和区分相关代码块。
6. 在命名空间(namespace)的声明下面必须有一行空行，在导入(use)的声明下面必须有一行空行。
7. 所有PHP源文件尽量以一个空行结束。

## 语法格式

1. 使用4个空格或者制表符（宽度为4个空格）来进行缩进。
2. 字符串与变量连接使用“.”号时，必须在“.”前后加空格。
3. 方法的参数在参数列表中，逗号之前不可有空格，而逗号之后则必须要有一个空格。参数与默认值之间的=前后无空格
4. 调用一个方法或函数时，在方法名或者函数名和左括号之间不可有空格，左括号之后不可有空格，右括号之前也不可有空格。参数列表中，逗号之前不可有空格，逗号之后则必须有一个空格。
5. 控制结构的关键词之后必须有一个空格。控制结构的左括号之后不可有空格。控制结构的右括号之前不可有空格。控制结构的右括号和左花括号之间必须有一个空格。控制结构的代码主体必须进行一次缩进。
6. {}结构在类和类方法中，左括号在( { )另起一行，在其他表达式，左括号( { )一般都在同一行

## 文档注释

1. 表意清晰的变量，常量等，可以不用注释，其他情况需要注明变量的数据类型及用途
2. 类、方法等需要有对应的注释，说明其作用，功能等
3. 一般数组中包含对象的，需要注释情况包含的对象情况

## 编程方法

1. 添加新功能前，尽可能熟悉原有代码，优先使用原有的功能，在原有功能的基础上进行开发。
2. 创建新功能的，同时要考虑是否可以进行抽象概括，分层设计，提高复用性。
3. 多学习项目所依托的框架基础知识，组件，底层原理，充分发挥已有功能能力，减少新代码的编写。
4. 形成自我正向反馈的能力，学以致用，用以总结，进而用总结的方法思路指导自己的工作方式，不断提升自我能力。

## 其他

- 未详细描述到的请参考样例代码

- <u>本文规范非要求绝对遵循，但需要绝大部分情况都依据文档的要求进行书写。</u>
- 规范未要求的部分，可参考样例带代码自行决定编写方式。
- 规范可由大家提出统一意见后进行修改及增删。

## 样例代码

```php
<?php
declare(strict_types=1);    // php7以上的文件都要严格类型
// 空一行

namespace exts; // 命名空间1， 一般在src/exts目录中

use Exception;

/**
 * Trait Info
 * 扩展信息
 * @package standard
 */
trait Info
{
    /**
     * 输出信息
     * @return string
     */
    public static function info(): string
    {
        return 'trait info';
    }
}

class DemoException extends Exception
{

}

/**
 * Class Student
 * @property-read  int id 需要在此注明id可读
 * @package exts
 */
class Student
{
    protected int $id = 0;

    public function __construct()
    {
        $this->id = rand(1, 1000000);
    }

    public function __get($name)
    {
        return $this->$name;
    }
}

namespace standard;  // 命名空间2， 一般在src/standard目录中
// 空一行

use Exception;
use exts\DemoException;
use exts\Info;
use exts\Student; // 多个use不需要空行
// 空一行

/**
 * Interface Version
 * 版本接口
 * @package standard
 */
interface Version
{
    public function version(): string ;
}

/**
 * Class Standard
 * 标准规范
 * @package standard
 */
abstract class Standard
{
    abstract public function items(): array ;
}

/**
 * Class CodingStandard
 * 编码规范
 * 继承了标准规范，实现了版本信息
 * @package standard
 */
class CodingStandard extends Standard implements Version // 继承及实现需要在同一行
{
    /**
     * 代码规范的版本
     */
    const VERSION = '1.0'; // 一行只实现一个语句

    /**
     * @var bool 一个用于控制结构的flag
     */
    public bool $flag = true; // php7.4 推荐加上类型约束

    /**
     * @var int 一个用于类型判断的数字
     */
    public int $num = 2;

    use Info;

    /**
     * 获取版本信息
     * @return string
     */
    public function version(): string
    {
        return static::VERSION;
    }

    /**
     * @return array
     */
    public function items(): array
    {
        return [
            1 => '命名规范',
            2 => '文件规范',
            3 => '代码行规范',
            4 => '语法格式规范',
        ];
    }

    /**
     * 方法规范fs(function standard),
     * 尽可能的约束传入参数类型，以及约束响应结果的类型
     * @param int $num 变量说明
     * @param string $name
     * @param bool $ok
     * @param array $items
     * @param callable|null $func
     * @return array 响应类型进行为单一类型，如仅数组，字符串等..
     */
    public function fs(int $num, string $name, bool $ok, array $items, callable $func=null): array // 明确函数返回类型的,可以增加类型约束
    {
        return [
            // 建议key-value对齐
            'num'   => $num,
            'name'  => $name,
            'ok'    => $ok,
            'items' => $items,
            'rest'  => is_callable($func) ? $func() : null, // 数组中的最后一个逗号不限定，自由选择是否保留
        ];
    }

    /**
     * 通过备注说明，相应的数组是student对象组成的
     * @return Student[] array
     */
    public function getStudents()
    {
        return [
            new Student(),
            new Student(),
        ];
    }

    /**
     * 调用函数
     */
    public function callFunction()
    {
        echo 'The coding standard version is ' . $this->version(); // 点(.)前后各有一个空格，version和"()"之间无空格

        /** @var Student[] $students */ // 该注释仅当getStudents未指明响应的数组中的对象类型时，可以通过在此处进行注释说明

        $students = $this->getStudents();

        foreach ($students as $student) {
            echo $student->id; // id需要student类中注明是可读的
        }
    }

    /**
     * 控制语句的格式
     */
    public function control()
    {
        if ($this->flag) { // ->和flag之间不能有空格
            echo "The flag is true.";
        } else {
            echo "The flag is false.";
        }

        if ($this->flag) print_r($this->flag); // 仅只有单分支且分支结构简单的时候，才能在一行中写完if和分支结构，其他情况不推荐

        if ($this->flag) echo "1"; else echo "0"; // 禁用此写法

        if ($this->num == 1) { // 分支结构的大括号与if在同一行，且其前面有一个空格
            echo "num is 1";
        } elseif ($this->num == 2) { // elseif 前后都需要又一个空格
            echo "num is 2";
        } else { // else 前后都需要又一个空格
            echo "num is unknown";
        }

        switch ($this->num) { // 分支结构的大括号与switch在同一行，且其前面有一个空格
            case 1:
                echo "num is 1";
                break;
            case 2:
                echo "num is 2";
                break;
            case 3 or 4:
                echo "num is 3 or 4 or ...";
                break;
            default:
                echo "num is unknown";
        }
    }

    /**
     * 循环控制
     */
    public function loop()
    {
        while ($this->num-- >= 0) {  // (expr) 包裹条件表达式括号前后都有一个空格，且大括号做标签与while在同一行
            echo $this->num;
        }

        do { // do和{在同一行，且中间用空格隔开
            echo $this->num;
        } while ($this->num++ < 20); // while前后都有空格，且与}、条件表达式在同一行


        foreach ($this->items() as $index => $title) { // foreach与()间隔一个空格
            echo "{$index}: $title \n"; // 变量在双引号中，必须使用{}框起来
        }

        // Notice:一般不在循环中count，以下仅为演示
        for ($i = 1; $i < count($this->items()); $i++) { // for与()间隔一个空格； 运算符前后需要各有一个空格
            echo "{$i}: {$this->items()[$i]} \n";
        }
    }

    /**
     * 抛出一个demo异常
     * @throws DemoException
     */
    public function throwException()
    {
        throw new DemoException('示例异常');
    }

    /**
     * 异常的结构
     */
    public function exception()
    {
        try { // try和{中间有一个空格隔开
            $this->throwException();
        } catch (DemoException $demoException) { // catch 前后各有一个空格，()与{在同一行，且中间又一个空格隔开
            echo $demoException->getMessage();
        } catch (Exception $exception) {
            echo $exception->getMessage();
        }
    }
}
```