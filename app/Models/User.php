<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'nom',
        'prenom',
        'telephone',
        'photo',
        'email',
        'date_de_naissance',
        'password',
        'is_active',
        'is_admin',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'date_de_naissance' => 'date',
        'is_active' => 'boolean',
        'is_admin' => 'boolean',
    ];

    /**
     * Relation avec Administrateur
     */
    public function administrateur()
    {
        return $this->hasOne(Administrateur::class);
    }

    /**
     * Relation avec Eleve
     */
    public function eleve()
    {
        return $this->hasOne(Eleve::class);
    }

    /**
     * Relation avec Professeur
     */
    public function professeur()
    {
        return $this->hasOne(Professeur::class);
    }

    public function affectations()
    {
        return $this->hasMany(Affectation::class, 'professeur_id');
    }

    /**
     * Vérifie si l'utilisateur est admin
     */
    public function isAdmin()
    {
        return $this->administrateur !== null;
    }

    /**
     * Vérifie si le compte est actif
     */
    public function isActive()
    {
        return $this->is_active;
    }

    /**
     * Retourne nom et prenom
     */
    public function getFullName()
    {
        return trim($this->prenom.' '.$this->nom);
    }
}
