<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    protected $fillable = [
        'bulletin_id',
        'eleve_id',
        'matiere_id',
        'type_evaluation',
        'nom_evaluation',
        'periode_id',
        'valeur',
        'is_locked',
    ];

    public function bulletin()
    {
        return $this->belongsTo(Bulletin::class);
    }

    public function matiere()
    {
        return $this->belongsTo(Matiere::class);
    }

    public function eleve()
    {
        return $this->belongsTo(Eleve::class);
    }

    public function periode()
    {
        return $this->belongsTo(PeriodeAcademique::class);
    }

    public function reclamations()
{
    return $this->hasMany(Reclamation::class);
}
}
