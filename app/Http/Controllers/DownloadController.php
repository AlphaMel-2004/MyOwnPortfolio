<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class DownloadController extends Controller
{
    private $allowedFiles = [
        'resume' => 'resume.pdf',
        'cv' => 'cv.pdf'
    ];

    private $fileDescriptions = [
        'resume' => 'Resume',
        'cv' => 'CV'
    ];

    /**
     * Download resume file
     */
    public function downloadResume(Request $request)
    {
        return $this->downloadFile('resume', $request);
    }

    /**
     * Download CV file
     */
    public function downloadCV(Request $request)
    {
        return $this->downloadFile('cv', $request);
    }

    /**
     * Generic file download method with security and logging
     */
    private function downloadFile(string $fileType, Request $request)
    {
        try {
            // Validate file type
            if (!array_key_exists($fileType, $this->allowedFiles)) {
                Log::warning('Invalid file download attempt', [
                    'file_type' => $fileType,
                    'user_ip' => $request->ip(),
                    'user_agent' => $request->userAgent()
                ]);
                
                return $this->errorResponse('Invalid file type requested.');
            }

            $fileName = $this->allowedFiles[$fileType];
            $filePath = storage_path("app/public/uploads/{$fileName}");

            // Check if file exists
            if (!file_exists($filePath)) {
                Log::error('File not found for download', [
                    'file_type' => $fileType,
                    'file_path' => $filePath,
                    'user_ip' => $request->ip()
                ]);
                
                return $this->errorResponse("{$this->fileDescriptions[$fileType]} file not found.");
            }

            // Get file info
            $fileSize = filesize($filePath);
            $fileMimeType = mime_content_type($filePath);

            // Validate file type (security check)
            if ($fileMimeType !== 'application/pdf') {
                Log::error('Invalid file type detected', [
                    'file_type' => $fileType,
                    'mime_type' => $fileMimeType,
                    'user_ip' => $request->ip()
                ]);
                
                return $this->errorResponse('Invalid file format.');
            }

            // Log successful download
            Log::info('File download successful', [
                'file_type' => $fileType,
                'file_name' => $fileName,
                'file_size' => $fileSize,
                'user_ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'referer' => $request->header('referer')
            ]);

            // Set appropriate headers for download
            $headers = [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => "attachment; filename=\"{$fileName}\"",
                'Content-Length' => $fileSize,
                'Cache-Control' => 'no-cache, must-revalidate',
                'Pragma' => 'no-cache',
                'Expires' => '0'
            ];

            // Return file download response
            return response()->download($filePath, $fileName, $headers);

        } catch (\Exception $e) {
            Log::error('File download error', [
                'file_type' => $fileType,
                'error' => $e->getMessage(),
                'user_ip' => $request->ip(),
                'trace' => $e->getTraceAsString()
            ]);

            return $this->errorResponse('An error occurred while downloading the file.');
        }
    }

    /**
     * Get file information (for admin purposes)
     */
    public function getFileInfo(Request $request)
    {
        try {
            $fileInfo = [];
            
            foreach ($this->allowedFiles as $type => $fileName) {
                $filePath = storage_path("app/public/uploads/{$fileName}");
                
                if (file_exists($filePath)) {
                    $fileInfo[$type] = [
                        'exists' => true,
                        'size' => $this->formatFileSize(filesize($filePath)),
                        'last_modified' => date('Y-m-d H:i:s', filemtime($filePath)),
                        'mime_type' => mime_content_type($filePath)
                    ];
                } else {
                    $fileInfo[$type] = [
                        'exists' => false,
                        'error' => 'File not found'
                    ];
                }
            }

            return response()->json($fileInfo);

        } catch (\Exception $e) {
            Log::error('File info retrieval error', [
                'error' => $e->getMessage(),
                'user_ip' => $request->ip()
            ]);

            return response()->json(['error' => 'Failed to retrieve file information'], 500);
        }
    }

    /**
     * Format file size in human readable format
     */
    private function formatFileSize(int $bytes): string
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, 2) . ' ' . $units[$i];
    }

    /**
     * Return error response with appropriate status code
     */
    private function errorResponse(string $message, int $statusCode = 404)
    {
        if (request()->expectsJson()) {
            return response()->json([
                'error' => $message,
                'status' => 'error'
            ], $statusCode);
        }

        return redirect()->back()->with('error', $message);
    }
} 