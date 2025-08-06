<?php

namespace App\Models;

//use Illuminate\Foundation\Auth\User as Authenticatable;
//use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Eleve extends Model
{
    use HasFactory, SoftDeletes;
 
    protected $table = 'eleves'; 
    protected $fillable = [
        'user_id',
        'classe_id',
        'annee_academique_id',

    ];

    protected $hidden = ['password', 'remember_token'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function classe()
    {
        return $this->belongsTo(Classe::class);
    }

    public function anneeAcademique()
    {
        return $this->belongsTo(AnneeAcademique::class, 'annee_academique_id');
    }

    //Relation avec les bulletins
    public function bulletins()
    {
        return $this->hasMany(Bulletin::class);
    }

    public function anneesScolaires()
    {
        return $this->bulletins()
            ->select('annee_academique_id')
            ->distinct()
            ->orderBy('annee_academique_id', 'desc')
            ->pluck('annee_academique_id');
    }
    public function calculerMoyenneAnnuelle()
{
    $bulletins = $this->bulletins()->with('periode', 'matiere')->get();

    $groupes = $bulletins->groupBy('periode_id');
    $totalPeriodes = $groupes->count();
    $sommeMoyennesPeriodes = 0;

    foreach ($groupes as $periodeId => $bulletinsParPeriode) {
        $totalCoefficients = 0;
        $totalMoyennesCoeff = 0;

        foreach ($bulletinsParPeriode as $bulletin) {
            $notes = $bulletin->notes; 
            $coef = $bulletin->coefficient ?? 1;
            $moyenne = $bulletin->moyenne ?? 0;

            $totalCoefficients += $coef;
            $totalMoyennesCoeff += $moyenne * $coef;
        }

        $moyennePeriodique = $totalCoefficients > 0 ? $totalMoyennesCoeff / $totalCoefficients : 0;
        $sommeMoyennesPeriodes += $moyennePeriodique;
    }

    $moyenneAnnuelle = $totalPeriodes > 0 ? $sommeMoyennesPeriodes / $totalPeriodes : null;

    $this->moyenne_annuelle = $moyenneAnnuelle;
    $this->save();
}
Public function moyennes()
    {
        return $this->hasMany(Moyenne ::class) ;
    }

    Public function moyenneAnnuelle($annee)
    {
        return $this->moyennes()->where('annee_academique', $annee)->avg('valeur') ;
    }


}
