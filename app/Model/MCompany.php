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
 * Class MCompany
 * 
 * @property int $id
 * @property string $insert_user
 * @property Carbon $insert_at
 * @property string $update_user
 * @property Carbon $update_at
 * @property string $name
 * @property string|null $name_kana
 * @property string $office_name
 * @property string|null $office_name_kana
 * @property string|null $post_code
 * @property string|null $address
 * @property string|null $building
 * @property string|null $phone
 * @property string|null $fax
 * @property string $mail
 * @property string $corp_id
 * @property int $status
 * @property Carbon|null $contract_date
 * @property Carbon|null $cancel_contract_date
 * @property string|null $account_manager_name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|TContract[] $tContracts
 *
 * @package App\Model
 */
class MCompany extends Model
{
	use AutoloadsRelationships;
	protected $table = 'm_company';
	protected $dateFormat = 'Y-m-d H:i:s.v';
	public static $snakeAttributes = false;

	protected $casts = [
		'status' => 'int'
	];

	protected $dates = [
		'insert_at',
		'update_at',
		'contract_date',
		'cancel_contract_date'
	];

	protected $fillable = [
		'insert_user',
		'insert_at',
		'update_user',
		'update_at',
		'name',
		'name_kana',
		'office_name',
		'office_name_kana',
		'post_code',
		'address',
		'building',
		'phone',
		'fax',
		'mail',
		'corp_id',
		'status',
		'contract_date',
		'cancel_contract_date',
		'account_manager_name',
	];

	public function tContracts()
	{
		return $this->hasOne(TContract::class, 'company_id')->where([
			'contract_year' => Carbon::now()->format('Y'),
			'contract_month' => Carbon::now()->format('m')
		])
		->orderBy('id','desc');
	}
}
