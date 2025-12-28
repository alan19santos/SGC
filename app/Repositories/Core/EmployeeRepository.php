<?php


namespace App\Repositories\Core;

use App\Models\Employee;
use App\Repositories\Core\BaseRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class EmployeeRepository extends BaseRepository {


    public function __construct(private Employee $entity) {

        parent::__construct($entity);
    }

    public function getAll(): Collection {

        return $this->relationship($this->entity)->get();
    }

    private function relationship($entity, $relations = []) {
        return $entity->with($relations);
    }

    public function findWhere(string $columnm, string $value): Collection {
        return parent::findWhere($columnm, $value);
    }

    public function paginate(int $totalPage = 10): LengthAwarePaginator
    {
        return parent::paginate($totalPage);
    }


}
