<?php

/**
 * Created by Reliese Model.
 */

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use LiamWiltshire\LaravelJitLoader\Concerns\AutoloadsRelationships;

/**
 * Class TelescopeEntriesTag
 * 
 * @property string $entry_uuid
 * @property string $tag
 * 
 * @property TelescopeEntry $telescopeEntry
 *
 * @package App\Model
 */
class TelescopeEntriesTag extends Model
{
	use AutoloadsRelationships;
	protected $table = 'telescope_entries_tags';
	public $incrementing = false;
	public $timestamps = false;
	protected $dateFormat = 'Y-m-d H:i:s.v';
	public static $snakeAttributes = false;

	protected $fillable = [
		'entry_uuid',
		'tag'
	];

	public function telescopeEntry()
	{
		return $this->belongsTo(TelescopeEntry::class, 'entry_uuid', 'uuid');
	}
}
