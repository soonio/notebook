## easyWeChat的微信回调通知失败

### 概述

项目使用easyWeChat和easyswoole开发
该项目的http请求通过nginx转发给easyswoole处理，这个过程easyWeChat无法通过组件Symfony\Component\HttpFoundation\ParameterBag获取微信通知请求的xml内容

easyWeChat获取xml的方法
> vendor/overtrue/wechat/src/Payment/Notify/Handler.php
```php
    /**
     * Return the notify message from request.
     *
     * @return array
     *
     * @throws \EasyWeChat\Kernel\Exceptions\Exception
     */
    public function getMessage(): array
    {
        if (!empty($this->message)) {
            return $this->message;
        }

        try {
            $message = XML::parse(strval($this->app['request']->getContent()));
        } catch (\Throwable $e) {
            throw new Exception('Invalid request XML: '.$e->getMessage(), 400);
        }

        if (!is_array($message) || empty($message)) {
            throw new Exception('Invalid request XML.', 400);
        }

        if ($this->check) {
            $this->validate($message);
        }

        return $this->message = $message;
    }
```
$this->app['request']为Symfony\Component\HttpFoundation\ParameterBag的实例

### 解决思路
替换掉$this->app['request']的实例

### 实际解决代码

```php
/**
 * Class Cheat
 * @package App\ClassLib
 */
class Cheat
{
    public $content = '';

    public function getContent()
    {
        return $this->content;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }
}
```

> App\HttpControler\DemoController.php
```php
/**
 * easyWeChat 请求处理无法获取请求信息，采用中间操作代替对应的对象
 * @param \EasySwoole\Core\Http\Request $request
 * @return Cheat
 */
protect function easyWeChatRequestReplacer($request)
{
    $file_in = $request->getBody();
    $sxe = simplexml_load_string($file_in, 'SimpleXMLElement', LIBXML_NOCDATA);
    $requestCheat = new Cheat();
    $requestCheat->setContent($sxe->asXML());
    return $requestCheat;
}

// 处理微信的退款通知
public function notify()
{
    $app = Factory::payment(array_merge(WeChatPay::BaseConfig(), WeChatPay::CertConfig()));
    $app->request = $this->easyWeChatRequestReplacer($this->request());
    $response = $app->handleRefundedNotify(function ($message, $reqInfo, $fail) {
        var_dump($message);
        return true;
    });
    return $this->returnXml($response->getContent());
}
protected function returnXml(string $string)
{
    if (!$this->response()->isEndResponse()) {
        $this->response()->write($string);
        $this->response()->withHeader('Content-type','text/xml;charset=utf-8');
        $this->response()->withStatus(Status::CODE_OK);
        return true;
    }else{
        trigger_error("response has end");
        return false;
    }
}
```