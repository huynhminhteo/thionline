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
 * Class Test
 * 
 * @property int $id
 * @property int $core_id
 * @property string $code
 * @property int $stt
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 *
 * @package App\Model
 */
class Test extends Model
{
	use SoftDeletes;
	use AutoloadsRelationships;
	protected $table = 'test';
	protected $dateFormat = 'Y-m-d H:i:s.v';
	public static $snakeAttributes = false;

	protected $casts = [
		'core_id' => 'int',
		'stt' => 'int'
	];

	protected $hidden = [
		'deleted_at'
	];

	protected $fillable = [
		'core_id',
		'code',
		'stt'
	];
}
