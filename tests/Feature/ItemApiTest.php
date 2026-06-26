<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ItemApiTest extends TestCase
{
    use RefreshDatabase;
    
    protected $user;
    protected $admin;
    protected $category;
    
    protected function setUp(): void
    {
        parent::setUp();
        
        $this->category = Category::factory()->create([
            "id" => 1,
            "name" => "Electronics"
        ]);
        
        $this->user = User::factory()->create([
            "role" => "user",
            "email" => "user@example.com"
        ]);
        
        $this->admin = User::factory()->create([
            "role" => "admin",
            "email" => "admin@example.com"
        ]);
    }
    
    public function test_guest_cannot_access_items()
    {
        $this->getJson("/api/v1/items")
            ->assertStatus(401);
    }
    
    public function test_user_can_list_items()
    {
        $token = $this->user->createToken("api-token")->plainTextToken;
        
        $this->withHeader("Authorization", "Bearer $token")
            ->getJson("/api/v1/items")
            ->assertStatus(200)
            ->assertJsonStructure([
                "success",
                "message",
                "data"
            ]);
    }
    
    public function test_user_can_create_item()
    {
        $token = $this->user->createToken("api-token")->plainTextToken;
        
        $response = $this->withHeader("Authorization", "Bearer $token")
            ->postJson("/api/v1/items", [
                'name' => 'Test Item',
                'quantity' => 10,
                'price' => 100000,
                'category_id' => 1
            ]);
        
        $response->assertStatus(201)
            ->assertJsonStructure([
                "success",
                "message",
                "data"
            ]);
    }
    
    public function test_user_cannot_delete_item()
    {
        $token = $this->user->createToken("api-token")->plainTextToken;
        $item = Item::factory()->create([
            "category_id" => 1,
            "name" => "Test Item",
            "quantity" => 10,
            "price" => 100000
        ]);
        
        $this->deleteJson(
            "/api/v1/items/{$item->id}",
            [],
            ["Authorization" => "Bearer $token"]
        )->assertStatus(403);
    }
    
    public function test_admin_can_delete_item()
    {
        $item = Item::factory()->create([
            "category_id" => 1,
            "name" => "Test Item",
            "quantity" => 10,
            "price" => 100000
        ]);
        $token = $this->admin->createToken("api-token")->plainTextToken;
        
        $this->deleteJson(
            "/api/v1/items/{$item->id}",
            [],
            ["Authorization" => "Bearer $token"]
        )->assertStatus(204);
    }
    
    public function test_user_can_update_item()
    {
        $token = $this->user->createToken("api-token")->plainTextToken;
        $item = Item::factory()->create([
            "category_id" => 1,
            "name" => "Old Name",
            "quantity" => 5,
            "price" => 50000
        ]);
        
        $response = $this->withHeader("Authorization", "Bearer $token")
            ->putJson("/api/v1/items/{$item->id}", [
                'name' => 'Updated Name',
                'quantity' => 20,
                'price' => 200000,
                'category_id' => 1
            ]);
        
        $response->assertStatus(200)
            ->assertJsonStructure([
                "success",
                "message",
                "data"
            ]);
    }
}