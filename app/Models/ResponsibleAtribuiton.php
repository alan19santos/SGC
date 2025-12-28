<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use \Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class ResponsibleAtribuiton extends Model
{
    use HasFactory;

    protected $table = 'responsible_atribuition';

    protected $fillable = ['responsible_id', 'occurrence_id','status_occurrence_id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class,'responsible_id', 'id');
    }


    public function occurrence(): BelongsTo {
        return $this->belongsTo(Occurrence::class, 'occurrence_id', 'id');
    }


    public function status(): BelongsTo {
        return $this->belongsTo(StatusOccurrence::class, 'status_occurrence_id', 'id');
    }


}
