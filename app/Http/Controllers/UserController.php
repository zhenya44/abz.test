<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Requests\UserFindRequest;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Http\Requests\UserCreateRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Common\Pagination\PaginationInfoBuilder;
use App\Common\ImageOptimizer\ImageOptimizer;

class UserController extends Controller
{
    public function index(UserRequest $request, PaginationInfoBuilder $paginationInfoBuilder)
    {
        $count = $request->has('count') ? intval($request->input('count')) : 5;
        $page = $request->has('page') ? intval($request->input('page')) : 1;
        $offset = $request->has('offset') ? $request->input('offset') : 0;

        if($offset)
        {
            $usersPaginator = User::paginateWithOffset($offset, $count);
        }else
        {
            $usersPaginator = User::paginate($count, ['*'], 'page', $page);
        }

        $paginationInfoBuilder->setCount($count);
        $paginationInfoBuilder->setOffset($offset);
        $paginationInfo = $paginationInfoBuilder->buildFrom($usersPaginator);

        return \response()->success(
            array_merge(
                $paginationInfo,
                ['users' => UserResource::collection($usersPaginator->items())]
            )
        );
    }

    public function show(UserFindRequest $request, $id)
    {
        $user = User::find($id);
        if(!$user)
        {
            return \response([
                "success" => false,
                "message" => "The user with the requested identifier does not exist",
                "fails" => [
                    "user_id" => [
                        "User not found"
                    ]
                ]
            ], Response::HTTP_NOT_FOUND);
        }

        return \response()->success(["user" => new UserResource($user)]);
    }

    public function store(UserCreateRequest $request, ImageOptimizer $imageOptimizer)
    {
        if(User::where('phone',$request->input('phone'))
            ->orWhere('email',$request->input('email'))
            ->first())
        {
            return \response([
                "success" => false,
                "message" => "User with this phone or email already exist"
            ], Response::HTTP_CONFLICT);
        }

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'position_id' => $request->input('position_id'),
        ]);

        $user->loadImage($request->file('photo'), $imageOptimizer);

        return \response()->success([
            "user_id" => $user->id,
            "message" => "New user successfully registered"
        ]);
    }
}
