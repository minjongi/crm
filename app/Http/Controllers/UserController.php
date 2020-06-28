<?php

namespace App\Http\Controllers;

use App\Exceptions\ApplicationException;
use App\Http\Resources\ApiResource;
use App\Http\Resources\FailCollection;
use App\Http\Resources\FailException;
use App\Service\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * @var UserService
     */
    private $userService;

    /**
     * Create a new controller instance.
     *
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->middleware('auth');
        $this->userService = $userService;
    }

    /**
     * @param Request $request
     * @param $userId
     * @return ApiResource
     * @throws ApplicationException
     */
    public function show(Request $request, $userId)
    {
        $validator = Validator::make(['id'=>$userId], [
            'id' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            throw new ApplicationException(ApplicationException::REQUEST_PARAM, $errors); // 요청 파라메터 에러.
        }
        return new ApiResource($this->userService->getUser($userId));
    }

    public function store(Request $request)
    {
        $attributes = $request->post();
        $validationInfo = [
            'id' => 'required',
            'password' => 'required',
            'name' => 'required',
            'email' => 'required'
        ];
        $validator = Validator::make($attributes, $validationInfo);
        if ($validator->fails()) {
            return new FailCollection(collect($validator->errors()->all()));
        }

        try {
            $attributes['password'] = Hash::make($attributes['password']);
            $user = $this->userService->create($attributes);
        } catch (\Exception $e) {
            return new FailException($e);
        }

        return new ApiResource($user);
    }

    public function getSession()
    {
        return new ApiResource(Auth::user());
    }
}
