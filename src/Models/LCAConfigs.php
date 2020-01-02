<?php

namespace Vignesh\Laraadmin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Exception;
use Log;
use DB;
use Vignesh\Laraadmin\Helpers\LCAHelper;

class LCAConfigs extends Model
{
	protected $table = 'lca_configs';

	protected $fillable = [
		"key", "value"
	];

	protected $hidden = [

	];

	// LCAConfigs::getByKey('sitename');
	public static function getByKey($key) {
		$row = LCAConfigs::where('key',$key)->first();
		if(isset($row->value)) {
			return $row->value;
		} else {
			return false;
		}
	}

	// LCAConfigs::getAll();
	public static function getAll() {
		$configs = array();
		$configs_db = LCAConfigs::all();
		foreach ($configs_db as $row) {
			$configs[$row->key] = $row->value;
		}
		return (object) $configs;
	}
}
