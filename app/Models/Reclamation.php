<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reclamation extends Model
{
    protected $table = 'reclamations';

    protected $fillable = [
        'bulletin_id',
        'eleve_id',
        'matiere_id',
        'type_evaluation',
        'periode_id',
        'annee_academique_id',
        'type',
        'note_id',
        'professeur_id',
        'description',
        'statut',
        'reponse_admin',
    ];

    public function bulletin()
    {
        return $this->belongsTo(Bulletin::class);
    }

    public function eleve()
    {
        return $this->belongsTo(Eleve::class);
    }

    public function matiere()
    {
        return $this->belongsTo(Matiere::class);
    }

    public function periode()
    {
        return $this->belongsTo(PeriodeAcademique::class, 'periode_id');
    }

    public function anneeAcademique()
    {
        return $this->belongsTo(AnneeAcademique::class, 'annee_academique_id');
    }

    public function expediteur()
    {
        return $this->belongsTo(User::class, 'expediteur_id');
    }

    public function note()
    {
        return $this->belongsTo(Note::class);
    }

    public function professeur()
    {
        return $this->belongsTo(Professeur::class, 'professeur_id');
    }
}
