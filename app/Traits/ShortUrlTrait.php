<?php

namespace App\Traits;

use App\Models\ShortUrl;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

trait ShortUrlTrait
{
    private function processData(FormRequest $request)
    {
        if (auth()->check()) {
            $userId = auth()->user()->id;
        } else {
            $userId = null;
        }
        $data['long_url'] = $request->long_url;
        $data['short_url'] = $this->shortUrlGenerate();
        $data['count'] = 0;
        $data['user_id'] = auth()->check() ? auth()->user()->id : null;

        return $data;

    }

    private function shortUrlGenerate()
    {
        do {
            $short_url = Str::random(6);
        } while (ShortUrl::where('short_url', $short_url)->exists());

        return $short_url;

    }
}
