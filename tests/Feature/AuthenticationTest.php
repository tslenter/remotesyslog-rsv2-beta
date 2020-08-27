<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Tests whether or not a guest can view a login form.
     * @test
     * @return void
     */
    public function a_guest_can_view_a_login_form()
    {
        $response = $this->get('/login');

        $response->assertSuccessful();
        $response->assertViewIs('auth.login');
    }

    /**
     * Tests whether an authenticated user can view the login form.
     * @test
     * @return void
     */
    public function a_authenticated_user_cannot_view_a_login_form()
    {
        $user = factory('App\User')->create();

        $response = $this->actingAs($user)->get('/login');

        $response->assertRedirect('/home');
    }

    /**
     * Tests whether a authenticated user can view a login form.
     * @test
     * @return void
     */
    public function a_guest_can_login_with_correct_credentials()
    {
        $user = factory('App\User')->create([
            'password' => bcrypt($password = 'password')
        ]);

        $response = $this->post('/login', [
            'username' => $user->username,
            'password' => $password
        ]);

        $response->assertRedirect();
        $this->assertAuthenticatedAs($user);
    }

    /**
     * Tests whether a guest can login with an incorrect password.
     * @test
     * @return void
     */
    public function a_guest_cannot_login_with_incorrect_password()
    {
        $user = factory('App\User')->create([
            'password' => bcrypt($password = 'password')
        ]);

        $response = $this->post('/login', [
            'username' => $user->username,
            'password' => 'notthepassword'
        ]);

        $response->assertSessionHasErrors('username');
        $this->assertTrue(session()->hasOldInput('username'));

        $this->assertGuest();
    }

    /**
     * Tests whether a cookie is generated when the user clicks on 'Remember me'.
     * @test
     * @return void
     */
     public function when_a_user_selects_rememberme_a_cookie_should_be_generated()
     {

         $user = factory('App\User')->create([
             'password' => bcrypt($password = 'password'),
             ]);

         $response = $this->post('/login', [
             'username' => $user->username,
             'password' => $password,
             'remember' => 'on',
             ]);

         $response->assertRedirect('/home');

         $response->assertCookie(Auth::guard()->getRecallerName(), vsprintf('%s|%s|%s', [
                 $user->id,
                 $user->getRememberToken(),
                 $user->password,
         ]));

         $this->assertAuthenticatedAs($user);
     }

    /**
     * Tests whether a authenticated user can see the menubar content.
     * @test
     * @return void
     */
     public function a_authenticated_user_sees_the_menu_bar_content()
     {
         $user = factory('App\User')->create();

         $this->actingAs($user);

         $response = $this->get('/home');

         $response->assertSee('Searches');
         $response->assertSee('Settings');
         $response->assertSee('Logout');
     }

     /**
     * Tests whether a guest cannot login with an incorrect username
     * @test
      * @returns void
     */
     public function a_guest_cannot_login_with_an_incorrect_username()
     {
         $user = factory('App\User')->create([
             'username' => 'username',
             'password' => 'password'
         ]);

         $response = $this->post('/login', [
             'username' => 'nottheusername',
             'password' => 'password'
         ]);

         $response->assertSessionHasErrors('username');
         $this->assertTrue(session()->hasOldInput('username'));

         $this->assertGuest();
     }

     /**
      * This tests that the registration link is not working.
      * @test
      * @returns void
      */
     public function a_registration_form_is_not_accessible()
     {
         $response = $this->get('/register');

         $response->assertStatus(404);
     }
}

