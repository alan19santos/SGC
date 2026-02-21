<?php

namespace App\Repositories\Core;
use App\Models\Occurrence;
use App\Models\StatusOccurrence;
use App\Models\Notifications;
use App\Exceptions\CredentialsException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class NotificationsRepository extends BaseRepository {

    /**
     * Summary of __construct
     * @param \App\Models\Notifications $notifications
     */
    public function __construct(private Notifications $notifications){
            parent::__construct($notifications);
    }

    function getEntity()  {

    }

    /**
     * Summary of getAll
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAll(): Collection
    {
        return $this->notifications->get();
    }

    /**
     * Summary of findById
     * @param mixed $id
     * @return object
     */
    public function findById($id): object {

        return $this->notifications->where('id', $id)->first();
    }

    public function store(array $data): void {
        DB::beginTransaction();
        try {
            $this->notifications->create($data);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \DomainException("Failed to create notification: " . $e->getMessage());
        }

    }

    public function getByUserId(int $userId): Collection
    {
        return $this->notifications
            ->where('user_id', $userId)
            ->orderByDesc('created_at')
            ->get();
    }

    public function markAsRead(int $id, int $userId)
    {
        $notification = $this->notifications
            ->where('id', $id)
            ->where('user_id', $userId)
            ->first();

        if (!$notification) {
            return null;
        }

        $notification->read = true;
        $notification->save();

        return $notification;
    }

}
