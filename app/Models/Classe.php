<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classe extends Model
{
    use HasFactory;

    protected $fillable = ['nom', 'code'];

    /**
     * Relation avec les matières , les matieres lie a la classe
     */
    public function matieres()
    {
        return $this->belongsToMany(
            Matiere::class,
            'classe_matiere_professeur',
            'classe_id',
            'matiere_id'
        )
        ->withPivot('professeur_id', 'coefficient')
        ->withTimestamps()
        ->distinct();
    }
    public function eleves()
{
    return $this->hasMany(Eleve::class);
}
public function anneeAcademique()
    {
        return $this->belongsTo(AnneeAcademique::class, 'annee_academique_id');
    }

}
