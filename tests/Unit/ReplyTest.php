<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ReplyTest extends TestCase {
    use DatabaseMigrations;
    private $reply;
    public function setUp() {
        parent::setUp();
        $this->reply = factory('App\Reply')->create();
    }

    public function test_reply_has_an_owner() {
        $this->assertInstanceOf('App\User', $this->reply->owner);
   }
}
