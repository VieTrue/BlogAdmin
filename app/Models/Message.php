<?php

namespace App\Models;
use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Message
 *
 * @property int $id
 * @property string $name
 * @property string $tel
 * @property string|null $msg
 * @property string $qd
 * @property string $ip
 * @property string $url
 * @property string|null $city
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message whereMsg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message whereQd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message whereTel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message whereUrl($value)
 * @mixin \Eloquent
 */
class Message extends Model
{
    use HasDateTimeFormatter;
    protected $table = 'message';
}
