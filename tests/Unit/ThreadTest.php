<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ThreadTest extends TestCase {
    use DatabaseMigrations;
    private $thread;
    public function setUp() {
        parent::setUp();
//        $this->thread = factory('App\Thread')->create();
        $this->thread = factory('App\Thread')->create();
    }

    /**
     * @test 该主题下是否有回复，在 show.blade.php 中使用了 $thread->replies
     */
    public function test_thread_has_replies() {
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $this->thread->replies);
    }

    /**
     * @test creator() 在 App\Thread.php 关联
     */
    public function test_thread_has_a_creator () {
        $this->assertInstanceOf('App\User', $this->thread->creator);
    }

    /**
     * @test 给 thread 添加一条 reply
     */
    public function test_thread_can_add_a_reply() {
        $this->thread->addReply([
            'body' => 'Jack',
            'user_id' => 1
        ]);

        $this->assertCount(1, $this->thread->replies);
    }

    /**
     * 测试一个 thread 属于一个 channel
     */
    public function test_thread_belongs_to_a_channel() {
        $thread = create('App\Thread');
        $this->assertInstanceOf('App\Channel',$thread->channel);
    }
}
