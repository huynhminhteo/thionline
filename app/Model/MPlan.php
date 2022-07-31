<?php

/**
 * Created by Reliese Model.
 */

namespace App\Model;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use LiamWiltshire\LaravelJitLoader\Concerns\AutoloadsRelationships;

/**
 * Class MPlan
 * 
 * @property int $id
 * @property string $insert_user
 * @property Carbon $insert_at
 * @property string $update_user
 * @property Carbon $update_at
 * @property string $name
 * @property float $amount
 * @property int $max_team
 * @property int $max_staff
 * @property int $max_patient
 * @property int $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|TContract[] $tContracts
 *
 * @package App\Model
 */
class MPlan extends Model
{
	use AutoloadsRelationships;
	protected $table = 'm_plan';
	protected $dateFormat = 'Y-m-d H:i:s.v';
	public static $snakeAttributes = false;

	protected $casts = [
		'amount' => 'float',
		'max_team' => 'int',
		'max_staff' => 'int',
		'max_patient' => 'int',
		'status' => 'int'
	];

	protected $dates = [
		'insert_at',
		'update_at'
	];

	protected $fillable = [
		'insert_user',
		'insert_at',
		'update_user',
		'update_at',
		'name',
		'amount',
		'max_team',
		'max_staff',
		'max_patient',
		'status'
	];

	public function tContracts()
	{
		return $this->hasMany(TContract::class, 'plan_id');
	}
}
