<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShortUrlRequest;
use App\Models\ShortUrl;
use App\Traits\ShortUrlTrait;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ShortUrlController extends Controller
{
    use ShortUrlTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return redirect('/');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ShortUrlRequest $request)
    {
        $data = $this->processData($request);
        $insert_data = ShortUrl::create($data);
        return response()->json([
            'code'      => Response::HTTP_CREATED,
            'success'   => true,
            'message'   => 'Short URL generated successfully!',
            'data'      => $insert_data,
        ],Response::HTTP_CREATED);
    }

    /**
     * Redirect short url to Long url
     */
    public function redirectShortUrl($url)
    {
        $short_url = ShortUrl::where('short_url', $url)->first();
        if ($short_url) {
            $short_url->count = $short_url->count + 1;
            $short_url->update();
            return redirect()->to($short_url->long_url);
        } else {
            abort(Response::HTTP_NOT_FOUND);
        }
    }
}
