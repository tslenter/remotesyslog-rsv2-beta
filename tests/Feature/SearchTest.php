<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;
use App\Search;

class SearchTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /**
     * @test This tests whether a guest can see the create search view.
     * @returns void
     */
    public function a_guest_cannot_view_create_searches()
    {
        $response = $this->get('/searches/create');

        $response->assertStatus(302);
        $response->assertRedirect('login');
    }

    /**
     * @test This tests whether a authenticated user can see the create search view.
     * @returns void
     */
    public function a_authenticated_user_can_view_create_searches()
    {
        $user = factory('App\User')->create();

        $this->actingAs($user);

        $response = $this->get('/searches/create');

        $response->assertStatus(200);

    }

    /**
     * @test This tests whether a search can be saved via the search form
     * @returns void
     */
    public function a_search_can_be_saved()
    {
        $user = factory('App\User')->create();

        $search = factory('App\Search')->make();

        $this->actingAs($user);

        $response = $this->json('POST', '/searches', [
            'searchtext' => $search->searchtext,
            'startdatetime' => $search->startdatetime,
            'enddatetime' => $search->enddatetime
        ]);

        $response->assertRedirect();

        $this->assertEquals(1, Search::all()->count());
    }

    /**
     * @test This tests whether a search can be shown and has results.
     * @returns void
     */
    public function a_search_and_results_are_displayed()
    {
        $user = factory('App\User')->create();

        $search = factory('App\Search')->create();

        $this->actingAs($user);

        $response = $this->get('/searches/' . $search->id);

        $response->assertOk();

        $response->assertSee($search->id);
        $response->assertSee($search->startdatetime);
        $response->assertSee($search->enddatetime);
    }

}
