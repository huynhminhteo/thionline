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
 * Class Question
 * 
 * @property int $id
 * @property int $group_id
 * @property int $stt
 * @property string|null $title
 * @property string $content
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 *
 * @package App\Model
 */
class Question extends Model
{
	use SoftDeletes;
	use AutoloadsRelationships;
	protected $table = 'question';
	protected $dateFormat = 'Y-m-d H:i:s.v';
	public static $snakeAttributes = false;

	protected $casts = [
		'group_id' => 'int',
		'stt' => 'int'
	];

	protected $hidden = [
		'deleted_at'
	];

	protected $fillable = [
		'group_id',
		'stt',
		'title',
		'content'
	];
}
