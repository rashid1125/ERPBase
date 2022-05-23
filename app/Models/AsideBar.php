<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AsideBar extends Model
{
    use HasFactory;
    protected $table = 'mainnav';
    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'mainnav_id';
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;
    /**
     * The storage format of the model's date columns.
     *
     * @var string
     */
    protected $dateFormat = 'U';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'module_id',
        'sub_module_id',
        'vr_title',
        'vr_link',
        'vr_type',
        'is_visible',
        'sort_order',
        'vr_rights',
        'vr_icon',
        'report_id',
        'vr_post_method',
        'report_dynamically_parm',
        'is_tax',
        'company_id',
        'uid'
    ];
    public static function _getMainnavLinks($module_id, $sub_module_id)
    {
        $mainnav = DB::table('mainnav')
            ->where(array('mainnav.module_id' => $module_id, 'mainnav.sub_module_id' => $sub_module_id))
            ->join('mainnavmodule', 'mainnavmodule.module_id', '=', 'mainnav.module_id')
            ->join('submainnavmodule', 'submainnavmodule.sub_module_id', '=', 'mainnav.sub_module_id')
            ->join('route_dynamics', 'route_dynamics.id', '=', 'mainnav.route_dynamic_id')
            ->select('mainnav.*', 'route_dynamics.slug')
            ->get();
        return $mainnav;
    }
}
