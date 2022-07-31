<?php

/**
 * Created by Reliese Model.
 */

namespace App\Model;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use LiamWiltshire\LaravelJitLoader\Concerns\AutoloadsRelationships;

/**
 * Class TContract
 * 
 * @property int $id
 * @property string $insert_user
 * @property Carbon $insert_at
 * @property string $update_user
 * @property Carbon $update_at
 * @property int $company_id
 * @property int $contract_year
 * @property int $contract_month
 * @property int $plan_id
 * @property float $amount
 * @property int $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property MCompany $mCompany
 * @property MPlan $mPlan
 *
 * @package App\Model
 */
class TContract extends Model
{
	use AutoloadsRelationships;
	protected $table = 't_contract';
	protected $dateFormat = 'Y-m-d H:i:s.v';
	public static $snakeAttributes = false;

	protected $casts = [
		'company_id' => 'int',
		'contract_year' => 'int',
		'contract_month' => 'int',
		'plan_id' => 'int',
		'amount' => 'float',
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
		'contract_year',
		'contract_month',
		'plan_id',
		'amount',
		'status',
		'charge_client_id',
		'regular_charge_id',
		'is_trial'
	];

	public function mCompany()
	{
		return $this->belongsTo(MCompany::class, 'company_id');
	}

	public function mPlan()
	{
		return $this->belongsTo(MPlan::class, 'plan_id');
	}
}
