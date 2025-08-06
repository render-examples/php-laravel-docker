<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnneeAcademique extends Model
{
    protected $table = 'annee_academique';

    protected $fillable = ['libelle'];

    public function periode()
    {
        return $this->hasMany(PeriodeAcademique::class);
    }

    public function reclamations()
    {
        return $this->hasMany(Reclamation::class, 'annee_academique_id');
    }
}
