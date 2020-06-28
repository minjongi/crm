<?php

namespace App\Service;

use App\Repositories\BoardRepository;

class BoardService
{
    /**
     * @var BoardRepository
     */
    private $boardRepository;

    public function __construct(BoardRepository $boardRepository)
    {
        $this->boardRepository = $boardRepository;
    }

    /**
     * 목록 조회
     *
     * @param $perPage
     * @param $condition
     * @param array $orderBy
     * @return array
     */
    public function getList($perPage, $condition, $orderBy = [])
    {
        $result = $this->boardRepository->paginate($perPage, $condition, $orderBy)->toArray();

        unset($result['first_page_url']);
        unset($result['from']);
        unset($result['last_page_url']);
        unset($result['next_page_url']);
        unset($result['path']);
        unset($result['prev_page_url']);
        unset($result['to']);

        return $result;
    }

    /**
     * 조회
     *
     * @param $id
     * @return boardRepository
     */
    public function find($id)
    {
        return $this->boardRepository->find($id);
    }

    /**
     * 등록
     *
     * @param $attributes
     * @return boardRepository
     */
    public function insert($attributes)
    {
        return $this->boardRepository->create($attributes);
    }

    /**
     * 수정
     *
     * @param $id
     * @param $attributes
     * @return boardRepository
     */
    public function update($id, $attributes)
    {
        return $this->boardRepository->update($id, $attributes);
    }

    /**
     * 삭제
     *
     * @param $id
     * @return boardRepository
     */
    public function delete($id)
    {
        return $this->boardRepository->delete($id);
    }
}
