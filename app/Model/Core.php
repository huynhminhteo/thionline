<?php

/**
 * Created by Reliese Model.
 */

namespace App\Model;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use LiamWiltshire\LaravelJitLoader\Concerns\AutoloadsRelationships;

/**
 * Class Core
 * 
 * @property int $id
 * @property string $name
 * @property Carbon $date
 * @property int $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 *
 * @package App\Model
 */
class Core extends Model
{
	use SoftDeletes;
	use AutoloadsRelationships;
	protected $table = 'core';
	protected $dateFormat = 'Y-m-d H:i:s.v';
	public static $snakeAttributes = false;

	protected $dates = [
		'date'
	];

	protected $hidden = [
		'deleted_at'
	];

	protected $fillable = [
		'name',
		'date',
		'status'
	];

	public function tests()
	{
		return $this->hasMany(Test::class, 'core_id');
	} 
}
