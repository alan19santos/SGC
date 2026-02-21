<?php

namespace App\Services;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Repositories\Core\NotificationsRepository;

class NotificationService {

    private $repository;

    public function __construct(NotificationsRepository $repository) {
        $this->repository = $repository;
    }

    public function getAll() {
        return $this->repository->getAll();
    }

    /**
     * Summary of paginate
     * @param int $perPage
     * @param int $page
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function paginate($perPage = 15, $page = 1) {
        $allNotifications = $this->repository->getAll();
        $total = $allNotifications->count();
        $notifications = $allNotifications->forPage($page, $perPage)->values();

        return new LengthAwarePaginator($notifications, $total, $perPage, $page);
    }
    public function findById($id) {
        return $this->repository->findById($id);
    }

    public function store(array $data): void {
        $this->repository->store($data);
    }

    public function getByUserId(int $userId)
    {
        return $this->repository->getByUserId($userId);
    }

    public function markAsRead(int $id, int $userId)
    {
        return $this->repository->markAsRead($id, $userId);
    }
}
