<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ChatbotController extends Controller
{
    private $geminiApiKey;
    private $baseKnowledge;

    public function __construct()
    {
        $this->geminiApiKey = env('GEMINI_API_KEY', 'AIzaSyAdwGziJeue6mn-g64G-P9xNKuGCZoYjbM');
        $this->baseKnowledge = "You are a helpful assistant for Venujaya Car Rent Service in Sri Lanka. Here is some important information about our services:

To rent a car in Sri Lanka you need to be at least 19 years old with a valid license. Some car categories have a higher minimum rental age, and an underage driver fee may apply.

You will need a full, valid driver's license along with a passport or identity card when picking up your car. More detailed information can be found in our rental information.

To reset your password, go to the login page and click on 'Forgot Password'. Enter your email address and we'll send you a link to reset your password. The link will expire in 24 hours for security reasons.

You can update your billing information by logging into your account and navigating to the 'Billing' section in your profile settings. Here you can add, remove, or update your payment methods and billing address.

Our customer support team is available 24/7. You can reach us by phone at 1-800-RENT-CAR, via email at support@carrental.com, or through the live chat feature on our website and mobile app.

To delete your account, go to your account settings and select 'Delete Account'. Please note that this action is permanent and will erase all your rental history and personal information from our system.

You can cancel your reservation free of charge up to 24 hours before your scheduled pickup time. Cancellations made within 24 hours may incur a fee. Please check your rental agreement for specific details.

Please provide helpful and accurate responses based on this information. If someone asks something outside of car rental services, politely redirect them to car rental related topics.";
    }

    public function chat(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000'
        ]);

        $userMessage = $request->message;
        
        // Combine base knowledge with user message
        $fullPrompt = $this->baseKnowledge . "\n\nUser question: " . $userMessage;

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'X-goog-api-key' => $this->geminiApiKey
            ])->post('https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent', [
                'contents' => [
                    [
                        'parts' => [
                            [
                                'text' => $fullPrompt
                            ]
                        ]
                    ]
                ]
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $aiResponse = $data['candidates'][0]['content']['parts'][0]['text'] ?? 'Sorry, I could not process your request.';
                
                return response()->json([
                    'success' => true,
                    'message' => $aiResponse
                ]);
            } else {
                Log::error('Gemini API Error: ' . $response->body());
                return response()->json([
                    'success' => false,
                    'message' => 'Sorry, I am having trouble connecting to my knowledge base. Please try again later.'
                ], 500);
            }

        } catch (\Exception $e) {
            Log::error('Chatbot Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Sorry, something went wrong. Please try again later.'
            ], 500);
        }
    }

    public function showChatbot()
    {
        return view('chatbot');
    }
}