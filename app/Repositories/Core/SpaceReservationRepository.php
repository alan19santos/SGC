<?php
namespace App\Repositories\Core;
use Illuminate\Support\Facades\Log;
use App\Exceptions\CredentialsException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use App\Repositories\Core\BaseRepository;
use App\Models\TypeReserved;
use App\Models\SpaceReservation;


class SpaceReservationRepository extends BaseRepository {

    public function __construct(private SpaceReservation $entity) {
        parent::__construct($entity);
    }
    function getEntity(){}
    /**
     * Summary of paginate
     * @param int $perPage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginate(int $perPage = 10): LengthAwarePaginator {
        return $this->loadRelationships( $this->entity, ['type','user'])->paginate($perPage);
    }

    /**
     * Summary of getAll
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAll(): Collection  {

        return $this->loadRelationships( $this->entity, ['type','user'] )->get();
    }

    /**
     * Summary of findById
     * @param int $id
     * @return object
     */
    public function findById(int $id): object {
        return $this->loadRelationships( $this->entity, ['type','user'] )->where('user_id', $id)->get();
    }

    /**
     * Summary of store
     * @param array $data
     * @throws \Exception
     * @return void
     */
    public function store(array $data): void {
        try {
            DB::beginTransaction();
            $this->entity->create($data);
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollBack();
            throw new \Exception($ex->getMessage());
        }
    }

    /**
     * Summary of TypeReserved
     * @return Collection|TypeReserved[]
     */
    public function TypeReserved() {
        return TypeReserved::get();
    }

    private function loadRelationships($query, $relationships = [])
    {
        return $query->with(
            $relationships
        );
    }



    /**
     * Summary of applyFilter
     * @param array $items
     */
    public function applyFilter(array $items)
    {
        $relationship = $this->loadRelationships($this->entity, ['type','user']);

        foreach ($items as $key => $value) {
            if ($value) {
                if (in_array($key, ['date_reserved','time','type_reserved_id'])) {
                    if ($key == 'date_reserved') {
                        $relationship->where("space_reservation.date_reserved", "=", $value);
                    }
                    if ($key == 'time') {
                        $relationship->where("space_reservation.time","=", $value);
                    }
                    if ($key == 'type_reserved_id') {
                        $relationship->where("space_reservation.type_reserved_id","=", $value);
                    }

                }
            }
        }
        $totalPage = 10;
        return $relationship->paginate($totalPage);
    }

    /**
     * Summary of isValidade
     * @param object $object
     * @param array $value
     * @throws \Exception
     * @return void
     */
    public function isValidade(object $object, array $value): void {

        try {
            DB::beginTransaction();
            $object->update($value);
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollBack();
            throw new \Exception($ex->getMessage());
        }
    }




}
