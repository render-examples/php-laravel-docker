<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Notifications\ReclamationNotification;

class Matiere extends Model
{
    use HasFactory;

    protected $fillable = ['nom', 'code'];

    /**
     * Relation
     */
    public function classes()
    {
        return $this->belongsToMany(
            Classe::class,
            'classe_matiere_professeur',
            'matiere_id',
            'classe_id'
        )
            ->distinct()
            ->withPivot('coefficient')
            ->withTimestamps();
    }

    /**
     * Relation vers la table ClasseMatiereProfesseur.
     */
    public function classeMatiereProfesseur()
    {
        return $this->hasMany(ClasseMatiereProfesseur::class);
    }

    //Non doublon de classe
    public function affectations()
    {
        return $this->hasMany(\App\Models\Affectation::class);
    }
    public function professeur()
{
    return $this->belongsTo(User::class, 'professeur_id');
}
public function professeurs()
{
    return $this->belongsToMany(Professeur::class, 'classe_matiere_professeur')
                ->withPivot('classe_id', 'coefficient', 'id');
}


}
