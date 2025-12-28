<?php


namespace App\Repositories\Core;
use App\Models\Company;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;


class CompanyRepository extends BaseRepository {

    /**
     * Summary of __construct
     * @param Company $company
     */
    public function __construct(private Company $company) {
        parent::__construct($company);
    }

    /**
     * Summary of getAll
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAll(): Collection
    {
        return $this->loadRelationships( $this->company, ['typeService'])->get();
    }

    /**
     * Summary of findWhere
     * @param string $column
     * @param string $value
     * @return Collection
     */
    public function findWhere(string $column, string $value): Collection {
        return parent::findWhere($column, $value);
    }

    /**
     * Summary of paginate
     * @param int $totalPage
     * @return LengthAwarePaginator
     */
    public function paginate(int $totalPage = 10): LengthAwarePaginator {
        // return parent::paginate($totalPage);
        return $this->loadRelationships($this->company, ['typeService'])->paginate($totalPage);
    }

    /**
     * Summary of loadRelationships
     * @param mixed $query
     * @param mixed $relationships
     */
    private function loadRelationships($query, $relationships = [])
    {
        return $query->with(
            $relationships
        );
    }



}
