<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class Financialyear extends Model
{
    use HasFactory;

    protected $table = 'financialyear';
    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'financialyear_id';
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
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
        'financialyear_name',
        'financialyear_start_date',
        'financialyear_end_date',
        'company_id',
        'uid',
    ];
    /**
     * IsAlreadyFinancialyearSaved a new user.
     *
     * @param  $FinancialyearObject
     */
    public static function IsAlreadyFinancialyearSaved($FinancialyearObject)
    {
        $Financialyear = Financialyear::where(array('financialyear_name' => $FinancialyearObject['financialyear_name']))->where('financialyear_id', '<>', $FinancialyearObject['financialyear_id'])->get();
        if (count($Financialyear) > 0)
            return CommonFunctions::getReturnResponse(true, 'Financial Year is already saved', $Financialyear);
        else return CommonFunctions::getReturnResponse(false, 'Financial Year is not already saved', null);
    }

    /**
     * FinancialyearSave a new user.
     *
     * @param  $FinancialyearObject
     */
    public static function FinancialyearSave($FinancialyearObject)
    {
        $FinancialyearObject['company_id'] = Session::get('company_id');
        $FinancialyearObject['uid'] = Session::get('uid');

        $FinancialyearObject['financialyear_start_date'] = _getIsAlreadyMysqlDate($FinancialyearObject['financialyear_start_date']);
        $FinancialyearObject['financialyear_end_date'] = _getIsAlreadyMysqlDate($FinancialyearObject['financialyear_end_date']);
        // get data for validate if save then do update record
        $Financialyear = Financialyear::where(array('financialyear_name' => $FinancialyearObject['financialyear_name']))->where('financialyear_id', '<>', '')->get();
        if (count($Financialyear) > 0) {
            DB::table('financialyear')->where('financialyear_id', $Financialyear[0]['financialyear_id'])->update($FinancialyearObject);
            return CommonFunctions::getReturnResponse(true, 'Financial Year Updated Successfuly', $Financialyear);
        } else {
            DB::table('financialyear')->insertGetId($FinancialyearObject);
            return CommonFunctions::getReturnResponse(true, 'Financial Year Saved Successfuly', $Financialyear);
        }
    }
    /**
     * _getVoucher a new user.
     *
     * @param  $vrnoa
     */
    public static function _getVoucher(int $vrnoa)
    {
        $Financialyear = Financialyear::find($vrnoa);
        if (count((array)($Financialyear)) > 0)
            return CommonFunctions::getReturnResponse(true, 'Financial Year Data', $Financialyear);
        else return CommonFunctions::getReturnResponse(false, 'No Data Found', null);
    }
}
