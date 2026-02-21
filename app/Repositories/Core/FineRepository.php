<?php

namespace App\Repositories\Core;
use App\Models\FinancialTransactions;
use App\Models\FinancialCategory;
use App\Enums\FinancyStatusEnums;
use App\Enums\FinancyTypeEnums;
use App\Models\Fines;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use App\Models\FinancialStatus;

class FineRepository extends BaseRepository
{

    private $model;
    /**
     * Summary of __construct
     * @param FinancialTransactions $financialTransactions
     * @param Fines $model
     */
    public function __construct(private FinancialTransactions $financialTransactions, Fines $model)
    {
        parent::__construct($model);
        $this->model = $model;
        $this->financialTransactions = $financialTransactions;
    }

    /**
     * Summary of paginate
     * @param int $id
     * @return LengthAwarePaginator
     */
    public function paginate(int $id): LengthAwarePaginator
    {
        return $this->model->where('condominium_id', $id)->paginate(10);
    }

   /**
    * Summary of getAll
    * @return Collection
    */
   public function getAll(): Collection
   {
       return $this->loadRelationships($this->model, ['condominium','resident','occurrence','financialStatus'])->get();
   }

    /**
     * Summary of findById
     * @param int $id
     * @return object
     */
    public function findById(int $id): object
    {
         return $this->loadRelationships($this->model, ['condominium','resident','occurrence','financialStatus'])->where('id', $id)->first();
    }


    /**
     * Summary of loadRelationships
     * @param mixed $query
     * @param array $relationships
     * @return mixed
     */
    public function loadRelationships($query, $relationships = [])
    {
       return $query->with($relationships);
    }

    public function financyStatus(string $slug): FinancialStatus
    {
        return FinancialStatus::where('slug','=', $slug)->first();
    }

     /**
      * Summary of storeFine
      * @param array $data
      * @return Fines
      */
     public function storeFine(array $data): Fines
     {
         $fine = $this->model->create($data);
         $this->financialTransactions->create([
             'condominium_id' => $data['condominium_id'],
             'resident_id' => $data['resident_id'],
             'fine_id' => $fine->id,
             'amount' => $data['amount'],
             'type' => $data['type'] ?? FinancyTypeEnums::MULTA_APLICADA,
             'status' => $this->financyStatus(FinancyStatusEnums::PENDENTE)->id,
         ]);
         return $fine;
     }

     /**
      * Summary of delete
      * @param object $model
      * @return bool|null
      */


    public function delete(object $model)
    {
        $transaction = $this->financialTransactions->where('fine_id', $model->id)->first();
        if ($transaction) {
            $transaction->delete();
        }
        return $model->delete();
    }

}
