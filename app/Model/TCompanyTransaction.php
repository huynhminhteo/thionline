<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use LiamWiltshire\LaravelJitLoader\Concerns\AutoloadsRelationships;


class TCompanyTransaction extends Model
{
    use AutoloadsRelationships;
	protected $table = 't_company_transaction';
	protected $dateFormat = 'Y-m-d H:i:s.v';
	public static $snakeAttributes = false;

	protected $casts = [
		'company_id' => 'int',
		'plan_id' => 'int',
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
		'plan_id',
		'status',
		'action_status',
		'regular_charge_id',
		'charge_client_id'
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
