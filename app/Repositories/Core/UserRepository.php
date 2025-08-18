<?php

namespace App\Repositories\Core;
use Illuminate\Support\Facades\Log;
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
    public function __construct(private User $user) {
        parent::__construct($user);
    }

    function getEntity() {}

    /**
     * Summary of getAll
     * @return Collection<int, TModel>|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Support\Collection<int, \stdClass>
     */
    public function getAll(): Collection
    {
        return $this->user->withTrashed()->get();
    }

    /**
     * Summary of store
     * @param array $data
     * @throws \App\Exceptions\UserException
     * @return void
     */
    public function store(array $data): void
    {
        try {
            DB::beginTransaction();
            $data['password'] = Hash::make($data['password']);
            $this->user->create($data);
            DB::commit();
            // return $this->user;
        } catch (\Exception $th) {
            DB::rollback();
            Log::error($th->getMessage());
            throw new UserException($th->getMessage());
        }
    }

    /**
     * Summary of findById
     * @param int $id
     * @return object
     */
    public function findById(int $id): object
    {
        return $this->relationship($this->user)
            ->withTrashed()
            ->findOrFail($id);
    }

    /**
     * Summary of findByEmail
     * @param string $email
     */
    public function findByEmail(string $email)
    {
        return $this->relationship($this->user)
            ->withTrashed()
            ->where('email', $email)
            ->first();
    }

    /**
     * Summary of findWhereFirst
     * @param string $column
     * @param string $value
     * @return object|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|\Illuminate\Database\Query\Builder|null
     */
    public function findWhereFirst(string $column, string $value)
    {
        return $this->user
            ->withTrashed()
            ->where($column, $value)
            ->first();
    }

    /**
     * Summary of updatePassword
     * @param string $email
     * @param string $password
     * @return void
     */
    public function updatePassword(string $email, string $password): void
    {
        $this->user::where('email', $email)
            ->update(['password' => Hash::make($password)]);
    }

    /**
     * Summary of paginate
     * @param int $totalPage
     * @return LengthAwarePaginator|\Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginate(int $totalPage): LengthAwarePaginator
    {
        return  $this->user->withTrashed()
            ->orderBy('users.name')
            ->paginate($totalPage);
    }

    /**
     * Summary of getProfileUser
     * @param mixed $profileId
     * @return object|Profile|\Illuminate\Database\Eloquent\Model|null
     */
    public function getProfileUser($userId) {

        // $user = $this->user->where('id', $userId)->first();
        $user = UserProfile::where('user_id','=', $userId)->first();
        if ($user) {
            return Profile::where('id', '=',$user->profile_id)->first();
        }

    }

    /**
     * Summary of applyFilter
     * @param array $items
     */
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


    /**
     * Summary of relationship
     * @param mixed $entity
     */
    private function relationship($entity) {

        return $entity;
    }

}
