<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * This test tests whether a user can be saved to the database.
     * @test
     * @returns void
     */
    public function a_user_can_be_created()
    {
        $user = factory(User::class)->create();

        $this->assertDatabaseHas('users', [
            'email' => $user->email,
            'username' => $user->username
        ]);
    }

    /**
     * Checks whether a user can have multiple searches.
     * @test
     * @returns void
     */
    public function a_user_can_have_multiple_searches()
    {
        $user = factory('App\User')->create();

        $search1 = factory('App\Search')->create([
            'user_id' => $user
        ]);

        $search2 = factory('App\Search')->create([
            'user_id' => $user
        ]);

        $this->assertEquals(2, $user->searches->count());
    }
}
