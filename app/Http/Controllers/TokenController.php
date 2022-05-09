<?php

namespace App\Http\Controllers;

use App\Token;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class TokenController extends Controller
{
    public function index()
    {
        try{
            $created_at = Date::now()->format('Y-m-d H:i:s');

            $token = Token::create([
                'token' => Str::random(275),
                'created_at' => $created_at,
                'expires_at' => Date::create($created_at)->addMinutes(40)->format('Y-m-d H:i:s')
            ]);

            return \response()->success(['token' => $token->token]);

        }catch (\Exception $ex)
        {
            abort(Response::HTTP_BAD_REQUEST);
        }
    }
}
