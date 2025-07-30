<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image as ImageFacade;
use App\Models\Image;
use App\Http\Requests\UploadRequest;

class UploadController extends Controller
{
    public function create()
    {
        $profileImage = Image::where('type', 'profile')->latest()->first();
        $certificates = Image::where('type', 'certificate')->latest()->get();
        return view('upload', compact('profileImage', 'certificates'));
    }

    public function store(UploadRequest $request)
    {
        // Validation is now handled by UploadRequest

        if ($request->hasFile('profile_picture')) {
            $profileFile = $request->file('profile_picture');
            $profileImage = ImageFacade::make($profileFile)->resize(300, 300);
            $profilePath = 'uploads/profile.jpg';
            Storage::disk('public')->put($profilePath, $profileImage->encode());

            // Save to database
            Image::create([
                'filename' => 'profile.jpg',
                'path' => $profilePath,
                'type' => 'profile',
            ]);
        }

        if ($request->hasFile('certificates')) {
            foreach ($request->file('certificates') as $certificate) {
                $certificatePath = $certificate->store('uploads/certificates', 'public');
                // Save to database
                Image::create([
                    'filename' => $certificate->getClientOriginalName(),
                    'path' => $certificatePath,
                    'type' => 'certificate',
                ]);
            }
        }

        return redirect()->back()->with('success', 'Files uploaded successfully!');
    }
}