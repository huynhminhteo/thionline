<?php

/**
 * Created by Reliese Model.
 */

namespace App\Model;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use LiamWiltshire\LaravelJitLoader\Concerns\AutoloadsRelationships;

/**
 * Class MDatabaseCompany
 * 
 * @property int $id
 * @property string $insert_user
 * @property Carbon $insert_at
 * @property string $update_user
 * @property Carbon $update_at
 * @property int $company_id
 * @property string $host
 * @property string $port
 * @property string $database
 * @property string $username
 * @property string $password
 * @property int $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Model
 */
class MDatabaseCompany extends Model
{
	use AutoloadsRelationships;
	protected $table = 'm_database_company';
	protected $dateFormat = 'Y-m-d H:i:s.v';
	public static $snakeAttributes = false;

	protected $casts = [
		'company_id' => 'int',
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
		'company_id',
		'host',
		'port',
		'database',
		'username',
		'password',
		'status'
	];
}
