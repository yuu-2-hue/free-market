<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class LoginControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate:fresh');
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }

    /** @test */
    public function ログイン画面のURLにアクセスしてログイン画面が表示される()
    {
        $response = $this->get(route('login'));
        $response->assertViewIs('auth.login');
    }

    /** @test */
    public function 登録しておいたemailアドレスとパスワードでログインできる()
    {
        $user = User::factory()->create([
            'email' => 'pass@example.com',
            'password'  => bcrypt('loginPass')
        ]);
        // ログイン処理
        $response = $this->post(route('login'), [
            'email'    => 'pass@example.com',
            'password'  => 'loginPass'
        ]);
        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    public function ログインに成功した後は商品一覧画面が表示される()
    {
        $user = User::factory()->create([
            'email' => 'pass@example.com',
            'password'  => bcrypt('loginPass')
        ]);
        // ログイン処理
        $response = $this->post(route('login'), [
            'email'    => 'pass@example.com',
            'password'  => 'loginPass'
        ]);
        $response->assertRedirect(route('index'));
    }

    /** @test */
    public function 登録したのと違うメールアドレスでログインしようとしてもログインできない()
    {
        $user = User::factory()->create([
            'email' => 'pass@example.com',
            'password'  => bcrypt('loginPass')
        ]);
        // ログイン処理
        $response = $this->post(route('login'), [
            'email'    => 'pass@exae.com',
            'password'  => 'loginPass'
        ]);
        $this->assertGuest();
    }

    /** @test */
    public function 登録したのと違うパスワードでログインしようとしてもログインできない()
    {
        $user = User::factory()->create([
            'email' => 'pass@example.com',
            'password'  => bcrypt('loginpass')
        ]);
        // ログイン処理
        $response = $this->post(route('login'), [
            'email'    => 'pass@example.com',
            'password'  => 'liginpass'
        ]);
        $this->assertGuest();
    }

    /** @test */
    public function 異なるアドレスでログインしようとするとエラーメッセージが表示される()
    {
        $user = User::factory()->create([
            'email' => 'pass@example.com',
            'password'  => bcrypt('loginPass')
        ]);
        $response = $this->post(route('login'), [
            'email'    => 'pass@exae.com',
            'password'  => 'loginPass'
        ]);
        $errorMessage = 'メールアドレスまたはパスワードが間違っています';
        $this->get(route('login'))->assertSee($errorMessage);
    }

    /** @test */
    public function 異なるパスワードでログインしようとするとエラーメッセージが表示される()
    {
        $user = User::factory()->create([
            'email' => 'pass@example.com',
            'password'  => bcrypt('loginpass')
        ]);
        $response = $this->post(route('login'), [
            'email'    => 'pass@example.com',
            'password'  => 'lss'
        ]);
        $errorMessage = 'メールアドレスまたはパスワードが間違っています';
        $this->get(route('login'))->assertSee($errorMessage);
    }

    /** @test */
    public function ログアウトすると認証状態が解除される()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        // ログアウトリクエスト
        $response = $this->post(route('logout'));
        // ユーザーが認証されていない
        $this->assertGuest();
    }

    /** @test */
    public function ログアウト後はログイン画面に遷移する()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        // ログアウトリクエスト
        $response = $this->post(route('logout'));
        $response->assertRedirect(route('login'));
    }
}
