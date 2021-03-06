<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Contracts\Debug\ExceptionHandler;
use App\Exceptions\Handler;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected $oldExceptionHandler;
    public function setUp() {
        parent::setUp();

        $this->disableExceptionHandling();
    }
    /**
     * 用户登录
     * @param null $user
     * @return $this
     */
    protected function signIn ($user = null) {
        $user = $user ?: create('App\User');
        $this->actingAs($user);
        return $this;
    }

    /**
     * 重写 render 方法
     */
    /*protected  function disableExceptionHandling() {
        $this->oldExceptionHandler = $this->app->make(ExceptionHandler::class);
        $this->app->instance(ExceptionHandler::class, new class extends Handler {
            public function __construct(){}
            public function report(\Exception $e){}
            public function render($request,\Exception $e){
                throw $e;
            }
        });
    }*/

    /**
     * 不需要抛出异常时调用
     * @return $this|BaseTestCase
     */
    /*protected function withExceptionHandling() {
        $this->app->instance(ExceptionHandler::class,$this->oldExceptionHandler);

        return $this;
    }*/

    protected function disableExceptionHandling()
    {
        $this->oldExceptionHander = $this->app->make(ExceptionHandler::class);

        $this->app->instance(ExceptionHandler::class,new class extends Handler{
            public function __construct(){}
            public function report(\Exception $e){}
            public function render($request,\Exception $e){
                throw $e;
            }
        });
    }

    protected function withExceptionHandling()
    {
        $this->app->instance(ExceptionHandler::class,$this->oldExceptionHandler);

        return $this;
    }
}
