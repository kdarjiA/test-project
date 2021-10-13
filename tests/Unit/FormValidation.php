<?php

namespace Tests\Unit;

use App\Http\Controllers\FileUploadController;
use App\Models\User;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class FormValidation extends TestCase
{
    public function testAllowCancelBooking()
    {
        $user = User::where('email', 'admin@example.com')->first();
        $this->actingAs($user);
        $new_file = new File();
        $new_request = new \Illuminate\Http\Request();
        $new_request->request->set('file', $new_file);
        $response = FileUploadController::get_inst()->post($new_request);
        $this->assertTrue($response);
    }
}
