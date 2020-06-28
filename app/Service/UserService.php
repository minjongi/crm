<?php


namespace App\Service;


use App\Repositories\UserRepository;

class UserService
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getUser($userId)
    {
        return $this->userRepository->getUser($userId);
    }

    public function create($attributes)
    {
        return $this->userRepository->create($attributes);
    }
}
