<?php

namespace Tests\Feature;

use App\Traits\CreateUsersTrait;

use Illuminate\Support\Facades\DB;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class UsersTest extends TestCase {

    use CreateUsersTrait;
    protected $token;
    public function setUp(): void{
        parent::setUp();
        DB::beginTransaction();
        $this->token = $this->createFactoryAndGetToken();

    }


    public function test_user_get_endpoint_an_authenticated_user() {

        $this->getJson('/api/user', [])->assertUnauthorized();
    }


    public function test_should_user_get_endpoint_return_a_single_user(): void {
        $user = $this->createUser();

        $response = $this->actingAs($user)->getJson("/api/user/{$user->id}", [
            'Authorization' => "Bearer {$this->token}",
        ]);

        $response->assertOk()
            ->assertJson(fn(AssertableJson $json) => $json->whereAll(['id' => $user->id])->etc());

    }

    public function test_should_user_get_endpoint_return_a_list_of_users(): void
    {
        $this->getJson('/api/user', ['Authorization' => 'Bearer ' . $this->token])->assertOk();
    }


    public function test_should_users_post_endpoint_create_a_new_user(): void
    {
        $user = $this->userData();
        $response = $this->postJson('/api/user', $user, ['Authorization' => 'Bearer ' . $this->token]);
        $response->assertCreated()
            ->assertJson(fn(AssertableJson $json) => $json->whereAll(['message' => 'Registro criado com sucesso']));

    }
    public function tearDown(): void
    {
        DB::rollBack();
        parent::tearDown();
    }




}
