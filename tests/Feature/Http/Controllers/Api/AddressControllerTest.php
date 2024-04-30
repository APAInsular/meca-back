<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Models\Address;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\Api\AddressController
 */
final class AddressControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_responds_with(): void
    {
        $addresses = Address::factory()->count(3)->create();

        $response = $this->get(route('addresses.index'));

        $response->assertOk();
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\Api\AddressController::class,
            'store',
            \App\Http\Requests\Api\AddressControllerStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_responds_with(): void
    {
        $address = $this->faker->word();
        $city = $this->faker->city();
        $zip_code = $this->faker->word();
        $province = $this->faker->word();
        $country = $this->faker->country();
        $street = $this->faker->streetName();
        $floor_block_building = $this->faker->word();

        $response = $this->post(route('addresses.store'), [
            'address' => $address,
            'city' => $city,
            'zip_code' => $zip_code,
            'province' => $province,
            'country' => $country,
            'street' => $street,
            'floor_block_building' => $floor_block_building,
        ]);

        $addresses = Address::query()
            ->where('address', $address)
            ->where('city', $city)
            ->where('zip_code', $zip_code)
            ->where('province', $province)
            ->where('country', $country)
            ->where('street', $street)
            ->where('floor_block_building', $floor_block_building)
            ->get();
        $this->assertCount(1, $addresses);
        $address = $addresses->first();

        $response->assertNoContent(201);
    }


    #[Test]
    public function show_responds_with(): void
    {
        $address = Address::factory()->create();

        $response = $this->get(route('addresses.show', $address));

        $response->assertOk();
    }


    #[Test]
    public function update_responds_with(): void
    {
        $address = Address::factory()->create();

        $response = $this->put(route('addresses.update', $address));

        $address->refresh();

        $response->assertOk();
    }


    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $address = Address::factory()->create();

        $response = $this->delete(route('addresses.destroy', $address));

        $response->assertNoContent();

        $this->assertModelMissing($address);
    }


    #[Test]
    public function error_responds_with(): void
    {
        $response = $this->get(route('addresses.error'));

        $response->assertNoContent(400);
    }
}
