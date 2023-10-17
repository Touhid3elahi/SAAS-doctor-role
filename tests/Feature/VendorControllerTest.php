<?php
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Vendor;

class VendorControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testIndex()
    {
        // Create some mock vendor data (adjust as needed)
        Vendor::create(['name' => 'Vendor 1']);
        Vendor::create(['name' => 'Vendor 2']);

        $response = $this->get('/vendors');

        $response->assertStatus(200);
    }

    public function testStore()
    {
        $data = ['name' => 'New Vendor'];

        $response = $this->post('/vendors', $data);

        $response->assertStatus(201);
    }

    public function testUpdate()
    {
        // Create a mock vendor record
        $vendor = Vendor::create(['name' => 'Original Name']);

        $data = ['name' => 'Updated Vendor Name'];

        $response = $this->put("/vendors/{$vendor->id}", $data);

        $response->assertStatus(200);
    }

    public function testDestroy()
    {
        // Create a mock vendor record
        $vendor = Vendor::create(['name' => 'Vendor to Delete']);

        $response = $this->delete("/vendors/{$vendor->id}");

        $response->assertStatus(204);
    }
}
