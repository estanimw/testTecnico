<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    protected $fillable = [
        'curso', 'cupo', 'docente', 'inscriptos'
    ];

	public function getInscriptosAttribute($value) {
		return json_decode($value);
	}
}
