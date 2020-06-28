<?php


namespace App\Repositories;

use App\Models\Board;

class BoardRepository
{
    /**
     * @var Board
     */
    private $board;

    public function __construct(Board $board)
    {
        $this->board = $board;
    }

    public function create($attributes)
    {
        return $this->board->create($attributes);
    }

    public function all()
    {
        return $this->board->all();
    }

    public function find($id)
    {
        return $this->board->find($id);
    }

    public function update($id, $attributes)
    {
        return $this->board->find($id)->update($attributes);
    }

    public function delete($id)
    {
        return $this->board->find($id)->delete();
    }

    public function firstOrCreate($attributes)
    {
        return $this->board->firstOrCreate($attributes);
    }

    public function updateOrCreate($searchAttributes, $setAttributes)
    {
        return $this->board->updateOrCreate($searchAttributes, $setAttributes);
    }

    public function paginate($perPage, $condition, $orderBy = [])
    {
        $query = $this->board->where([]);
        $query = $this->setWhere($query, $condition);

        if (!empty($orderBy) && !empty($orderBy['column']) && !empty($orderBy['sort'])) {
            $query->orderBy($orderBy['column'], $orderBy['sort']);
        }

        if (empty($orderBy) || $orderBy['column'] != 'id') {
            $query->orderBy('id', 'desc');
        }

        return $query->paginate($perPage);
    }

    private function setWhere($query, $condition)
    {
        if (!empty($condition['searchField']) && !empty($condition['searchWord'])) {
            $query->where($condition['searchField'], 'like', '%' . $condition['searchWord'] . '%');
        }

        return $query;
    }
}
