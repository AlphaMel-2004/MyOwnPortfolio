<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class ChatbotController extends Controller
{
    private $systemPrompt;
    private $apiKey;
    private $apiUrl;

    public function __construct()
    {
        $this->systemPrompt = $this->getSystemPrompt();
        $this->apiKey = config('services.gemini.key');
        $this->apiUrl = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=' . $this->apiKey;
    }

    public function chat(Request $request)
    {
        try {
            // Validate request
            $request->validate([
                'message' => 'required|string|max:1000',
            ]);

            $userMessage = trim($request->input('message'));
            
            // Check for empty or very short messages
            if (strlen($userMessage) < 2) {
                return response()->json([
                    'reply' => 'Please provide a more detailed message so I can help you better.',
                    'error' => 'message_too_short'
                ], 400);
            }

            // Rate limiting check
            $userIp = $request->ip();
            $rateLimitKey = 'chatbot_rate_limit_' . $userIp;
            $rateLimitCount = Cache::get($rateLimitKey, 0);
            
            if ($rateLimitCount >= 10) { // Max 10 requests per hour per IP
                return response()->json([
                    'reply' => 'You\'ve reached the rate limit. Please try again in an hour.',
                    'error' => 'rate_limit_exceeded'
                ], 429);
            }

            // Check cache for similar requests
            $cacheKey = 'chatbot_' . md5(strtolower($userMessage));
            $cachedResponse = Cache::get($cacheKey);
            if ($cachedResponse) {
                return response()->json(['reply' => $cachedResponse]);
            }

            // Increment rate limit
            Cache::put($rateLimitKey, $rateLimitCount + 1, 3600);

            $response = $this->callGeminiAPI($userMessage);

            if ($response['success']) {
                // Cache successful responses for 1 hour
                Cache::put($cacheKey, $response['reply'], 3600);
                
                // Log successful interaction
                Log::info('Chatbot interaction', [
                    'user_ip' => $userIp,
                    'message_length' => strlen($userMessage),
                    'response_length' => strlen($response['reply'])
                ]);
                
                return response()->json(['reply' => $response['reply']]);
            } else {
                return response()->json(['reply' => $response['reply']], 500);
            }

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'reply' => 'Please provide a valid message.',
                'error' => 'validation_error',
                'details' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Chatbot error', [
                'message' => $e->getMessage(),
                'user_message' => $request->input('message'),
                'user_ip' => $request->ip(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'reply' => 'I apologize, but I encountered an error. Please try again in a moment.',
                'error' => 'internal_error'
            ], 500);
        }
    }

    private function callGeminiAPI($userMessage)
    {
        $fullPrompt = $this->systemPrompt . "\n\nUser: " . $userMessage . "\nAI:";

        $data = [
            'contents' => [
                [
                    'parts' => [
                        ['text' => $fullPrompt]
                    ]
                ]
            ],
            'generationConfig' => [
                'temperature' => 0.7,
                'topK' => 40,
                'topP' => 0.95,
                'maxOutputTokens' => 1024,
            ]
        ];

        try {
            $response = Http::timeout(15)
                ->withHeaders(['Content-Type' => 'application/json'])
                ->post($this->apiUrl, $data);

            if ($response->successful()) {
                $responseData = $response->json();
                
                if (isset($responseData['candidates'][0]['content']['parts'][0]['text'])) {
                    $aiText = $responseData['candidates'][0]['content']['parts'][0]['text'];
                    // Clean up the response
                    $aiText = preg_replace('/^.*?AI:/s', '', $aiText);
                    $aiText = trim($aiText);
                    
                    return [
                        'success' => true,
                        'reply' => $aiText ?: 'I apologize, but I couldn\'t generate a proper response. Please try rephrasing your question.'
                    ];
                } else {
                    Log::warning('Gemini API returned unexpected response structure', ['response' => $responseData]);
                    return [
                        'success' => false,
                        'reply' => 'I apologize, but I received an unexpected response format. Please try again.'
                    ];
                }
            } else {
                Log::error('Gemini API error', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);
                
                return [
                    'success' => false,
                    'reply' => 'I apologize, but the AI service is currently unavailable. Please try again later.'
                ];
            }
        } catch (\Exception $e) {
            Log::error('Gemini API call failed', [
                'error' => $e->getMessage(),
                'user_message' => $userMessage
            ]);
            
            return [
                'success' => false,
                'reply' => 'I apologize, but I\'m having trouble connecting to the AI service. Please try again in a moment.'
            ];
        }
    }

    private function getSystemPrompt()
    {
        return "You are an expert AI assistant for Rumel Eumague Jr.'s portfolio website. You are knowledgeable about web development, UI/UX design, and the technologies used in this portfolio.

Key Information:
- Portfolio owner: Rumel Eumague Jr.
- Profession: UI/UX Designer & Full-Stack Developer
- Location: Davao City, Philippines
- Technologies: Laravel, PHP, JavaScript, React, Vue.js, MySQL, Figma, Adobe XD
- Skills: Web Development, Mobile Development, UI/UX Design

Your role:
- Answer questions about Rumel's skills, projects, and experience
- Provide information about web development and design topics
- Help users understand the portfolio features and technologies
- Be friendly, professional, and helpful
- Keep responses concise but informative
- Use simple language and avoid technical jargon unless specifically asked

Guidelines:
- Always refer to Rumel by his full name when mentioning him
- Focus on the actual content and features of this portfolio
- Don't invent information that isn't on the website
- Be encouraging and supportive of users' questions
- If asked about code or technical details, provide helpful explanations
- Use dashes (-) for lists, not asterisks
- Keep responses under 200 words unless more detail is specifically requested

Remember: You're here to help visitors understand Rumel's work and expertise in web development and design.";
    }
} 