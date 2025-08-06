<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClasseMatiereProfesseur extends Model
{
    protected $table = 'classe_matiere_professeur';

    protected $fillable = [
        'classe_id',
        'matiere_id',
        'professeur_id',
        'coefficient',
    ];

    public function classe()
    {
        return $this->belongsTo(Classe::class);
    }

    public function matiere()
    {
        return $this->belongsTo(Matiere::class);
    }

    public function professeur()
    {
        return $this->belongsTo(Professeur::class);
    }
}
