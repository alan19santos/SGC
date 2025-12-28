<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
class BankAccount extends Model  implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'bank_account';
    protected $fillable = ['branch_number','branch_digit_number','banck_name','banck_accont_code','banck_account_digit','banck_account_number','type_account_id','pix','people_id'];

    public function people() {
        return $this->belongsTo(Peoples::class, 'people_id' , 'id');
    }
    public function typeAccount() {
        return $this->belongsTo(TypeAccount::class, 'type_account_id' , 'id');
    }
}
