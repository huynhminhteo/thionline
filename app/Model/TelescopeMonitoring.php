<?php

/**
 * Created by Reliese Model.
 */

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use LiamWiltshire\LaravelJitLoader\Concerns\AutoloadsRelationships;

/**
 * Class TelescopeMonitoring
 * 
 * @property string $tag
 *
 * @package App\Model
 */
class TelescopeMonitoring extends Model
{
	use AutoloadsRelationships;
	protected $table = 'telescope_monitoring';
	public $incrementing = false;
	public $timestamps = false;
	protected $dateFormat = 'Y-m-d H:i:s.v';
	public static $snakeAttributes = false;

	protected $fillable = [
		'tag'
	];
}
