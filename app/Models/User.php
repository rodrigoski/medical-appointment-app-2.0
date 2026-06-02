<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles; // Importar Spatie
use Illuminate\Database\Eloquent\SoftDeletes; // Importar Soft Deletes

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasRoles; // Añadido para el Módulo de Roles
    use SoftDeletes; // Añadido para el Módulo de Seguridad (ADA 13)

    /**
     * Atributos que son asignables masivamente.
     * He añadido los campos que pide tu interfaz de Healthify.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'id_number', // Nuevo: Identificación para el reporte
        'phone',     // Nuevo: Contacto médico
        'address',   // Nuevo: Ubicación
    ];

    /**
     * Atributos ocultos para la serialización.
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * Atributos que se añaden al formato de array del modelo.
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Casts de atributos.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function patient(){
        return $this ->hasOne(Patient::class);
    }

    public function doctor()
{
    return $this->hasOne(\App\Models\Doctor::class);
}
}
