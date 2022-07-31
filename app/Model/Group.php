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
 * Class Group
 * 
 * @property int $id
 * @property int $test_id
 * @property string $name
 * @property int $stt
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 *
 * @package App\Model
 */
class Group extends Model
{
	use SoftDeletes;
	use AutoloadsRelationships;
	protected $table = 'group';
	protected $dateFormat = 'Y-m-d H:i:s.v';
	public static $snakeAttributes = false;

	protected $casts = [
		'test_id' => 'int',
		'stt' => 'int'
	];

	protected $hidden = [
		'deleted_at'
	];

	protected $fillable = [
		'test_id',
		'name',
		'stt'
	];
}
