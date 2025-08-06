<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Professeur extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function classes(): BelongsToMany
    {
        return $this->belongsToMany(Classe::class, 'classe_matiere_professeur', 'professeur_id', 'classe_id')
            ->withPivot('matiere_id', 'coefficient')
            ->withTimestamps();
    }

    public function matieres(): BelongsToMany
    {
        return $this->belongsToMany(Matiere::class, 'classe_matiere_professeur', 'professeur_id', 'matiere_id')
            ->withPivot('classe_id', 'coefficient')
            ->withTimestamps();
    }

    public function classesMatieres()
    {
        return $this->hasMany(ClasseMatiereProfesseur::class, 'professeur_id');
    }

    public function affectations()
    {
        return $this->hasMany(Affectation::class, 'professeur_id');
    }
}
