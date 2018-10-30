<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ParticipateInForumTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function test_authenticated_user_may_participate_in_forum_threads()
    {

        //
        $this->be($user = factory('App\User')->create());
        $thread = factory('App\Thread')->create();
//        $reply = factory('App\Reply')->create();
        $reply = factory('App\Reply')->make();


        $this->post($thread->path() .'/replies',$reply->toArray()); // 注：此处有修改
        // 回复页面
        $this->get($thread->path())
            ->assertSee($reply->body);
    }

    /**
     * @test 测试用户是否能添加 —— 是否登录
     */
    public function test_unauthenticated_user_may_no_add_replies() {
        $this->expectException('Illuminate\Auth\AuthenticationException');

        /*$thread = factory('App\Thread')->create();
        $reply = factory('App\Reply')->create();
        $this->post($thread->path().'/replies', $reply->toArray());*/
        $this->post('threads/1/replies', []);
    }
}
