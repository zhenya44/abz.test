<?php

namespace App\Http\Controllers;

use App\Position;
use App\Http\Resources\PositionResource;
use Symfony\Component\HttpFoundation\Response;

class PositionController extends Controller
{
    public function index()
    {
        $positions = Position::all();

        if(!$positions->count()){
            abort(Response::HTTP_UNPROCESSABLE_ENTITY, "Positions not found");
        }

        return \response()->success(
            ["positions" => PositionResource::collection(Position::all())]
        );
    }
}
