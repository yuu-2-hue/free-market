<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

use App\Models\User;
use App\Models\Product;
use App\Models\Comment;
use App\Models\Condition;
use App\Models\Favorite;

class ListControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate:fresh');
        $this->seed();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    /** @test */
    public function すべての商品が表示される()
    {
        $products = Product::All();
        $tab = 'list';
        $this->assertEquals($tab, 'list');

        $response = $this->get(route('index'));
        $response->assertStatus(200);
        $response->assertViewIs('index');
        foreach($products as $product)
        {
            $response->assertSee($product->name);
        }
    }

    /** @test */
    public function いいねした商品だけが表示される()
    {
        $products = Product::All();
        $favorites = Favorite::All();
        $user = User::Find(1);
        $this->actingAs($user);
        $tab = 'mylist';
        $this->assertEquals($tab, 'mylist');

        $response = $this->get(route('index'));
        $this->assertTrue(Auth::check());
        $response->assertStatus(200);
        $response->assertViewIs('index');
        if(Auth::check())
        {
            foreach($products as $product)
            {
                foreach($favorites as $favorite)
                {
                    if($user->id == $favorite->user_id && $product->id == $favorite->product_id)
                    {
                        $response->assertSee($product->name);
                    }
                }
            }
        }
    }

    /** @test */
    public function 未認証の場合は何も表示されない()
    {
        $products = Product::All();
        $favorites = Favorite::All();
        $user = User::Find(1);
        $tab = 'mylist';
        $this->assertEquals($tab, 'mylist');

        $response = $this->get(route('index'));
        $this->assertFalse(Auth::check());
        $response->assertStatus(200);
        $response->assertViewIs('index');
        if(Auth::check())
        {
            foreach($products as $product)
            {
                foreach($favorites as $favorite)
                {
                    if($user->id == $favorite->user_id && $product->id == $favorite->product_id)
                    {
                        $response->assertSee($product->name);
                    }
                }
            }
        }
    }

    /** @test */
    public function Soldラベルが表示される()
    {
        $products = Product::All();
        $user = User::Find(1);

        $response = $this->get(route('index'));
        $response->assertStatus(200);
        $response->assertViewIs('index');
        foreach($products as $product)
        {
            if($product->buy == $user->id) $response->assertSee('Sold');
        }
    }

    /** @test */
    public function 出品した商品は表示されない()
    {
        $products = Product::All();
        $user = User::Find(1);

        $response = $this->get(route('index'));
        $response->assertStatus(200);
        $response->assertViewIs('index');
        foreach($products as $product)
        {
            if($user->id == $product->sell)
            {
                $response->assertSee($product->name);
            }
        }
    }

}
