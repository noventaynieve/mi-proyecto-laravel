<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'role', 'activo'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    public const ROLE_ADMIN = 'admin';

    public const ROLE_SUPER_ADMIN = 'super_admin';

    public const ROLE_EDITOR = 'editor';

    public const ROLE_EDITOR_GENERAL = 'editor_general';

    public const ROLE_TRANSPARENCIA = 'transparencia';

    public const ROLE_ADMIN_DIF = 'admin_dif';

    public const ROLE_CATASTRO = 'catastro';

    public const ROLE_CITIZEN = 'citizen';

    /**
     * @var list<string>
     */
    public const PANEL_ROLES = [
        self::ROLE_SUPER_ADMIN,
        self::ROLE_ADMIN,
        self::ROLE_EDITOR_GENERAL,
        self::ROLE_EDITOR,
        self::ROLE_TRANSPARENCIA,
        self::ROLE_ADMIN_DIF,
        self::ROLE_CATASTRO,
    ];

    /**
     * @var array<string, string>
     */
    public const ROLE_LABELS = [
        self::ROLE_ADMIN => 'Administrador global',
        self::ROLE_SUPER_ADMIN => 'Administrador global',
        self::ROLE_EDITOR => 'Editor general',
        self::ROLE_EDITOR_GENERAL => 'Editor general',
        self::ROLE_TRANSPARENCIA => 'Transparencia',
        self::ROLE_ADMIN_DIF => 'Administrador DIF',
        self::ROLE_CATASTRO => 'Catastro',
        self::ROLE_CITIZEN => 'Ciudadano',
    ];

    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'activo' => 'boolean',
        ];
    }

    /**
     * @return HasMany<Noticia, $this>
     */
    public function noticias(): HasMany
    {
        return $this->hasMany(Noticia::class);
    }

    public function isAdmin(): bool
    {
        return $this->normalizeRole($this->role) === self::normalizeRole(self::ROLE_ADMIN);
    }

    public function canAccessAdmin(): bool
    {
        return $this->activo && in_array($this->normalizeRole($this->role), self::PANEL_ROLES, true);
    }

    public function hasRole(string ...$roles): bool
    {
        $normalizedCurrentRole = $this->normalizeRole($this->role);

        return $this->isAdmin()
            || in_array($normalizedCurrentRole, array_map(fn (string $role): string => $this->normalizeRole($role), $roles), true);
    }

    public function roleLabel(): string
    {
        return self::ROLE_LABELS[$this->normalizeRole($this->role)] ?? 'Sin acceso al panel';
    }

    protected static function normalizeRole(?string $role): string
    {
        return match ($role) {
            self::ROLE_ADMIN => self::ROLE_SUPER_ADMIN,
            self::ROLE_EDITOR => self::ROLE_EDITOR_GENERAL,
            self::ROLE_CITIZEN => 'user',
            default => $role ?? 'user',
        };
    }
}
