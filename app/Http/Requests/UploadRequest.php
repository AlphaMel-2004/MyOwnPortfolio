<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Adjust if you want to restrict who can upload
    }

    public function rules()
    {
        return [
            'profile_picture' => 'nullable|image|mimes:jpeg,png|max:2048',
            'certificates.*' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:4096',
        ];
    }

    public function messages()
    {
        return [
            'profile_picture.image' => 'The profile picture must be an image.',
            'profile_picture.mimes' => 'The profile picture must be a JPEG or PNG file.',
            'profile_picture.max' => 'The profile picture may not be greater than 2MB.',
            'certificates.*.file' => 'Each certificate must be a file.',
            'certificates.*.mimes' => 'Certificates must be JPEG, PNG, JPG, or PDF files.',
            'certificates.*.max' => 'Each certificate may not be greater than 4MB.',
        ];
    }
} 