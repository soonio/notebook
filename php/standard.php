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