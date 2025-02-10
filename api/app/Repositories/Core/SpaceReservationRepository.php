<?php
namespace App\Repositories\Core;
use App\Exceptions\CredentialsException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use App\Repositories\Core\BaseRepository;   
use App\models\TypeReserved;
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
        return $this->relationship( $this->entity)->paginate($perPage);
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

    public function TypeReserved() {
        return TypeReserved::get();
    }

    private function relationship($entity) {

        return $entity->with('tipe.description'
                            ,'user.name'
                            , 'condominium.name');
    }

    

    
}
