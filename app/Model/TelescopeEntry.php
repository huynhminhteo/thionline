<?php

/**
 * Created by Reliese Model.
 */

namespace App\Model;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use LiamWiltshire\LaravelJitLoader\Concerns\AutoloadsRelationships;

/**
 * Class TelescopeEntry
 * 
 * @property int $sequence
 * @property string $uuid
 * @property string $batch_id
 * @property string|null $family_hash
 * @property bool $should_display_on_index
 * @property string $type
 * @property string $content
 * @property Carbon|null $created_at
 * 
 * @property TelescopeEntriesTag $telescopeEntriesTag
 *
 * @package App\Model
 */
class TelescopeEntry extends Model
{
	use AutoloadsRelationships;
	protected $table = 'telescope_entries';
	protected $primaryKey = 'sequence';
	public $timestamps = false;
	protected $dateFormat = 'Y-m-d H:i:s.v';
	public static $snakeAttributes = false;

	protected $casts = [
		'should_display_on_index' => 'bool'
	];

	protected $fillable = [
		'uuid',
		'batch_id',
		'family_hash',
		'should_display_on_index',
		'type',
		'content'
	];

	public function telescopeEntriesTag()
	{
		return $this->hasOne(TelescopeEntriesTag::class, 'entry_uuid', 'uuid');
	}
}
