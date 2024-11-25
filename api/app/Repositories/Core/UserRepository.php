<?php

namespace App\Repositories\Core;

use App\Models\User;
use App\Models\UserProfile;
use App\Models\Profile;
use App\Exceptions\UserException;
use App\Repositories\Core\BaseRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;


class UserRepository extends BaseRepository
{
    public function __construct(private readonly User $user) {
        parent::__construct($user);
    }

    public function getAll(): Collection
    {
        return $this->user->withTrashed()->get();
    }

    public function store(array $data): void
    {
        try {
            DB::beginTransaction();
            $this->user->create($data);

            DB::commit();
        } catch (\Exception $th) {
            DB::rollback();
            throw new UserException($th->getMessage());
        }
    }

    public function findById(int $id): object
    {
        return $this->relationship($this->user)
            ->withTrashed()
            ->findOrFail($id);
    }

    public function findByEmail(string $email)
    {
        return $this->relationship($this->user)
            ->withTrashed()
            ->where('email', $email)
            ->first();
    }

    public function findWhereFirst(string $column, string $value)
    {
        return $this->user
            ->withTrashed()
            ->where($column, $value)
            ->first();
    }

    public function updatePassword(string $email, string $password): void
    {
        $this->user::where('email', $email)
            ->update(['password' => Hash::make($password)]);
    }

    public function paginate(int $totalPage): LengthAwarePaginator
    {
        return  $this->user->withTrashed()
            ->orderBy('users.name')
            ->paginate($totalPage);
    }

    public function getProfileUser($userId) {      
       
        $profile = UserProfile::where('user_id', $userId)->first();
        return Profile::where('id', $profile->id)->first();

    }

    public function applyFilter(array $items)
    {
        $relationship = $this->user;

        foreach ($items as $key => $value) {
            if ($value) {
                if (in_array($key, ['name', 'email'])) {
                    if ($key == 'name') {
                        $relationship->whereRaw("UPPER(users.name) like UPPER('%{$value}%')");
                    }
                    if ($key == 'email') {
                        $relationship->whereRaw("UPPER(users.email) like UPPER('%{$value}%')");
                    }
                }
            }

        }
        $totalPage = 10;
        return $relationship->orderBy('users.name')->paginate($totalPage);
    }


    private function relationship($entity) {

        return $entity->with('profile');
    }

}
