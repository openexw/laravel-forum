<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ThreadsTest extends TestCase {
    use DatabaseMigrations;

    private $thread;
    public function setUp() {
        parent::setUp();
        $this->thread = factory('App\Thread')->create();
    }

    public function test_user_can_view_all_threads() {
//        $thread = factory('App\Thread')->create();

        // test all threads
        $this->get('/threads')
                    -> assertSee($this->thread->title);
    }

    /**
     * // test all threads
     */
    public function test_user_can_read_a_single_thread() {
//        $thread = factory('App\Thread')->create();
        $this->get('/threads/'.$this->thread->id)
                    ->assertSee($this->thread->title);
    }

    public function test_user_can_read_replies_that_are_associated_with_a_thread() {
        // 存在 Thread 那么就有 Reply
        $reply = factory('App\Reply')
            -> create(['thread_id'=>$this->thread->id]);

        // 能看到 Thread 也能看到 Reply
        $this->get('/threads/'.$this->thread->id)
            -> assertSee($reply->body);

    }

    /**
     * @test 一个授权用户可以创建一个 主题
     */
    public function test_authenticated_user_can_create_new_forum_threads() {
        $this->actingAs(factory('App\User')->create()); // 已登录用户

        $thread = factory('App\Thread')->make();
        $this->post('/threads', $thread->toArray());

        $this->get($thread->path())
             -> assertSee($thread->title)
             -> assertSee($thread->body);
    }

    /**
     * 未登录用户不能添加 thread
     */
    public function test_guests_may_not_create_threads() {
        $this->expectException('Illuminate\Auth\AuthenticationException'); // 在此处抛出异常即代表测试通过
        $thread = factory('App\Thread')->make();
        $this->post('/threads',$thread->toArray());
    }

    /**
     * @test  测试游客不能看到创建 thread 的页面
     */
   /* public function test_guests_may_not_see_the_create_thread_page() {
        $this -> withExceptionHandling();

        $this -> get('/threads/create')
            -> assertRedirect('/login');

        $this -> post('/threads')
              -> assertRedirect('/login');
    }*/
}
