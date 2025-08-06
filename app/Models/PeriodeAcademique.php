<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeriodeAcademique extends Model
{
    use HasFactory;

    protected $table = 'periodes_academiques';

    protected $fillable = [
        'nom',
        'date_debut',
        'date_fin',
        'annee_academique_id',
    ];

    public function annee()
    {
        return $this->belongsTo(AnneeAcademique::class, 'annee_academique_id');
    }

    public function bulletins()
    {
        return $this->hasMany(\App\Models\Bulletin::class, 'periode_id', 'id');
    }
}
