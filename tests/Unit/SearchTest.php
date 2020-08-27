<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Search;
use App\User;

class SearchTest extends TestCase
{
    use RefreshDatabase;

    /**
     * This test tests whether a search can be saved to the database.
     * @test
     * @returns void
     */
    public function a_search_can_be_created()
    {
        $search = factory('App\Search')->create();

        $this->assertDatabaseHas('searches', [
            'user_id' => $search->user->id,
            'searchtext' => $search->searchtext,
            'startdatetime' => $search->startdatetime,
            'enddatetime' => $search->enddatetime
        ]);
    }

    /**
     * This test checks whether a search has a user.
     * @test
     * @returns void
     */
    public function a_search_has_a_user()
    {
        $user = factory(User::class)->create();

        $search = factory(Search::class)->create([
            'user_id' => $user
        ]);

        $this->assertInstanceOf(User::class, $search->user);
    }
}
