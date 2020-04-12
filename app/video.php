<?php

namespace App;
use App\Curso;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class video extends Model
{
	use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'url',
        'curso_id'
    ];
    public function curso(){ 

        return $this->belongsTo(Curso::class);
      
    }
}
