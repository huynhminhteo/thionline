<?php

/**
 * Created by Reliese Model.
 */

namespace App\Model;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;
use LiamWiltshire\LaravelJitLoader\Concerns\AutoloadsRelationships;

/**
 * Class MUser
 * 
 * @property int $id
 * @property string $mail
 * @property string $password
 * @property string $name
 * @property int $role
 * @property int|null $test_id
 * @property int|null $code
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 *
 * @package App\Model
 */
class MUser extends Authenticatable implements JWTSubject
{
	use SoftDeletes;
	use AutoloadsRelationships;
	protected $table = 'm_users';
	protected $dateFormat = 'Y-m-d H:i:s.v';
	public static $snakeAttributes = false;

	protected $casts = [
		'role' => 'int',
		'test_id' => 'int',
		'code' => 'int'
	];

	protected $hidden = [
		'password',
		'remember_token',
		'deleted_at'
	];

	protected $fillable = [
		'mail',
		'password',
		'name',
		'role',
		'test_id',
		'code',
		'remember_token'
	];

	public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
