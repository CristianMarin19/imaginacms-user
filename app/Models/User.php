<?php

namespace Modules\Iuser\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Imagina\Icore\Traits\hasEventsWithBindings;
use Imagina\Icore\Traits\HasOptionalTraits;

use Laravel\Passport\HasApiTokens;
use Laravel\Passport\Contracts\OAuthenticatable;

//use App\Notifications\ResetPasswordNotification;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Modules\Iuser\Traits\RolePermissionTrait;

class User extends Authenticatable implements OAuthenticatable
{

    use HasApiTokens, HasFactory, Notifiable, HasOptionalTraits, hasEventsWithBindings, RolePermissionTrait;

    protected $table = 'iuser__users';
    public $transformer = 'Modules\Iuser\Transformers\UserTransformer';
    public $repository = 'Modules\Iuser\Repositories\UserRepository';
    public $requestValidation = [
        'create' => 'Modules\Iuser\Http\Requests\CreateUserRequest',
        'update' => 'Modules\Iuser\Http\Requests\UpdateUserRequest',
        'login' => 'Modules\Iuser\Http\Requests\LoginUserRequest',
        'refreshToken' => 'Modules\Iuser\Http\Requests\RefreshTokenUserRequest',
        'resetPassword' => 'Modules\Iuser\Http\Requests\ResetPasswordUserRequest',
        'resetPasswordComplete' => 'Modules\Iuser\Http\Requests\ResetPasswordCompleteUserRequest',
    ];
    //Instance external/internal events to dispatch with extraData
    public $dispatchesEventsWithBindings = [
        //eg. ['path' => 'path/module/event', 'extraData' => [/*...optional*/]]
        'created' => [
            ['path' => 'Modules\Ifillable\Events\CreateField']
        ],
        'creating' => [],
        'updated' => [
            ['path' => 'Modules\Ifillable\Events\CreateField']
        ],
        'updating' => [],
        'deleting' => [
            ['path' => 'Modules\Ifillable\Events\CreateField']
        ],
        'deleted' => []
    ];
    //public $translatedAttributes = [];
    protected $fillable = [
        'email',
        'password',
        'permissions',
        'first_name',
        'last_name',
        'is_guest'
    ];

    public $modelRelations = [
        'roles' => 'belongsToMany'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

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
            'permissions' => 'json'
        ];
    }

    /**
     * ATTRIBUTES
     */
    protected function email(): Attribute
    {
        return Attribute::make(
            set: fn(string $value) => strtolower($value)
        );
    }

    /**
     * Get Permission from all enable Modules, only true permissions
     */
    public function permissions(): Attribute
    {
        return Attribute::get(function ($value) {

            //TODO - Check this | not necessary for now
            /*  $cacheKey = 'user_permissions_' . $this->id;
            return cache()->remember($cacheKey, 60, function () use ($value) { */

            $permissions = [];
            //Get All Modules
            $allModules = \Module::allEnabled();
            foreach ($allModules as $moduleName => $data) {
                //Get All Permission from Module
                $modulePermissions = config($moduleName . '.permissions');
                foreach ($modulePermissions as $permissionEntity => $permission) {
                    //Information to each permission
                    foreach ($permission as $permissionType => $infoPermission) {
                        //Check if permission is true
                        $resultValidate = $this->validatePermission($infoPermission);
                        if ($resultValidate) {
                            $permissions[$permissionEntity . '.' . $permissionType] = true;
                        }
                    }
                }
            }

            //Merge with individual permissions
            if (is_array($value) && !empty($value)) {
                return array_merge($value, $permissions);
            }

            return $permissions;
        });
    }


    /**
     * RELATIONS
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'iuser__role_user')->withTimestamps();
    }


    /**
     * Send a password reset notification to the user.
     */
    public function sendPasswordResetNotification($token): void
    {

        $url = env('APP_URL') . "/reset-password?token=" . $token;
        \Log::info("Iuser::User||Token: " . $token);

        //$this->notify(new ResetPasswordNotification($url));
    }

    public function fields()
    {
        if (isModuleEnabled('Ifillable')) {
            return app(\Modules\Ifillable\Relations\FillablesRelation::class)->resolve($this);
        }
        return new \Imagina\Icore\Relations\EmptyRelation();
    }
}
