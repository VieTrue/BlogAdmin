<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Config
 *
 * @property int $id
 * @property string $title
 * @property string $name
 * @property string|null $value
 * @property string $group
 * @property string $type
 * @property int $state
 * @property string|null $default
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Config newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Config newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Config query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Config whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Config whereDefault($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Config whereGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Config whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Config whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Config whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Config whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Config whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Config whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Config whereValue($value)
 * @mixin \Eloquent
 */
class Config extends Model
{
    use HasDateTimeFormatter;
    protected $table = 'config';
    
}
