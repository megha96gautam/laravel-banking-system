<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;

class ExchangeRateService {
    private $apiUrl = "https://api.exchangeratesapi.io/latest";
    private $apiKey = "68ecfc082e7be5824dcf5aae336d09bd"; // Replace with your API key

    public function getRate($from, $to) {
        $response = Http::get($this->apiUrl, [
            'access_key' => $this->apiKey,
            'base' => strtoupper($from),
            'symbols' => strtoupper($to),
        ]);

        if ($response->successful()) {
            $rates = $response->json()['rates'];
            $rate = $rates[strtoupper($to)] ?? null;
            return $rate ? $rate * 1.01 : null; // Apply 0.01 spread
        }

        return null;
    }
}
