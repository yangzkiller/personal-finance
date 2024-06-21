<?php

namespace App\Models\Auth;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use App\Permissions\ActionPermissions;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    const PROFILE_EXTENSIONS_ALLOWED = ['.png', '.jpg', '.jpeg', '.svg'];

   
    protected $fillable = [
        'name',
        'email',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    public function avatar()
    {
        $hash = hash('sha256', str_pad($this->id, 30, '0', STR_PAD_LEFT));
        foreach (self::PROFILE_EXTENSIONS_ALLOWED as $extension)
        {
            $public_path = '/assets/img/avatar/'.$hash.$extension;
            if (Storage::exists(public_path($public_path))) return $public_path;
        }
        return '/assets/img/avatar.png';
    }

    // Check if this user has permission to perform a specific action
    public function permitted(string $action)
    {
        return in_array($this->role, ActionPermissions::all()[$action]);
    }

    // Check if this user has at least one permission to perform a specific action
    public function hasOnePermission(array $actions)
    {
        foreach ($actions as $action)
        {
            if (in_array($this->role, ActionPermissions::all()[$action])) return true;
        }
        return false;
    }
}
