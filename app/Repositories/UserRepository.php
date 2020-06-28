<?php


namespace App\Repositories;


use App\User;

class UserRepository
{
    /**
     * @var User
     */
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function create($attributes)
    {
        return $this->user->create($attributes);
    }

    public function all()
    {
        return $this->user->all();
    }

    public function find($id)
    {
        return $this->user->find($id);
    }

    public function update($id, $attributes)
    {
        return $this->user->find($id)->update($attributes);
    }

    public function delete($id)
    {
        return $this->user->find($id)->delete();
    }

    public function firstOrCreate($attributes)
    {
        return $this->user->firstOrCreate($attributes);
    }

    public function updateOrCreate($searchAttributes, $setAttributes)
    {
        return $this->user->updateOrCreate($searchAttributes, $setAttributes);
    }
}
