<?php

namespace App\Service;

use App\Repositories\BoardRepository;

class BoardBatchService
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
     * 배치 테스트
     *
     */
    public function proc()
    {
        return 'result';
    }
}
