<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\UserStoreRequest;
use App\Http\Resources\UserCollection;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $offset = $request->has('offset') ? $request->query('offset') : 0;
        $limit = $request->has('limit') ? $request->query('limit') : 10;

        $list = User::query();
        if ($request->has('q'))
            $list->where('name', 'like', '%' . $request->query('q') . '%');

        if ($request->has('sortBy'))
            $list->orderBy($request->query('sortBy'), $request->query('sort', 'DESC'));

        $data = $list->offset($offset)->limit($limit)->get();

        $data->each->setAppends(['full_name']);


        return response($data, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserStoreRequest $request)
    {

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        return response([
           'data' => $user,
            'message' => 'User Created.'
        ], 201);
    }

    /**
     * @param User $user
     * @return User
     */
    public function show(User $user)
    {
        return $user;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        return response([
            'data' => $user,
            'message' => 'User Updated'
        ], 201);
    }

    /**
     * @param User $user
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(User $user)
    {
        $user->delete();

        return response([
            'message' => 'User Deleted.'
        ], 200);
    }

    public function custom1()
    {
//        $user2 = User::find(2);
//        return new UserResource($user2);

        $users = User::all();
//        return UserResource::collection($users);

        return new UserCollection($users);



    }
}
