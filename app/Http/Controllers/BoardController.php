<?php

namespace App\Http\Controllers;

use App\Http\Resources\ApiResource;
use App\Http\Resources\FailCollection;
use App\Http\Resources\FailException;
use App\Service\BoardService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BoardController extends Controller
{
    /**
     * @var BoardService
     */
    private $boardService;

    public function __construct(BoardService $boardService)
    {
        $this->boardService = $boardService;
    }

    public function index(Request $request)
    {
        $condition = [
            'searchField' => $request->get('search_field', ''),
            'searchWord' => $request->get('search_word', ''),
        ];
        $perPage = $request->get('per_page', 20);
        $orderBy = [
            'column' => $request->get('ob_column', 'id'),
            'sort' => $request->get('sort', 'desc'),
        ];

        try {
            $member = $this->boardService->getList($perPage, $condition, $orderBy);
        } catch (\Exception $e) {
            return new FailException($e);
        }

        return new ApiResource($member);
    }

    public function show(Request $request, $id='')
    {
        $validator = Validator::make(['id' => $id], ['id' => 'required|numeric']);
        if ($validator->fails()) {
            return new FailCollection(collect($validator->errors()->all()));
        }

        try {
            $member = $this->boardService->find($id);
        } catch (\Exception $e) {
            return new FailException($e);
        }

        return new ApiResource($member);
    }

    public function store(Request $request)
    {
        $attributes = $request->post();
        $validationInfo = [
            'title' => 'required',
            'content' => 'required'
        ];
        $validator = Validator::make($attributes['params'], $validationInfo);
        if ($validator->fails()) {
            return new FailCollection(collect($validator->errors()->all()));
        }

        try {
            $board = $this->boardService->insert($attributes['params']);
        } catch (\Exception $e) {
            return new FailException($e);
        }

        return new ApiResource($board);
    }

    public function update(Request $request, $id)
    {
        $attributes = $request->post();
        $attributes['id'] = $id;
        $validationInfo = [
            'id' => 'required|numeric',
            'title' => 'required',
            'content' => 'required'
        ];
        $validator = Validator::make($attributes['params'], $validationInfo);
        if ($validator->fails()) {
            return new FailCollection(collect($validator->errors()->all()));
        }

        try {
            $board = $this->boardService->update($attributes['params']['id'], $attributes['params']);
        } catch (\Exception $e) {
            return new FailException($e);
        }

        return new ApiResource($attributes['params']);
    }

    public function destroy(Request $request, $id)
    {
        $validator = Validator::make(['id' => $id], ['id' => 'required|numeric']);
        if ($validator->fails()) {
            return new FailCollection(collect($validator->errors()->all()));
        }

        try {
            $board = $this->boardService->delete($id);
        } catch (\Exception $e) {
            return new FailException($e);
        }

        return new ApiResource($board);
    }
}
