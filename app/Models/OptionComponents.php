<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class OptionComponents extends Model
{
    use HasFactory;
    public static function _getroleGroupOption($active, $etype, $company_id)
    {
        $RolegroupData = Rolegroups::all();
        if (count($RolegroupData)) {
            $dataHTML = OptionComponents::_getMakeOptionHTMLRoleGroup($RolegroupData);
            return CommonFunctions::_getReturnResponse(true, 'Loading Rolegroup...!!!', $dataHTML);
        } else {
            return CommonFunctions::_getReturnResponse(false, 'no data found...!!!', null);
        }
    }
    public function _getMakeOptionHTMLRoleGroup($data, $HTMLOption = "")
    {
        $HTMLOption .= '<option value="" selected="" disabled="">Choose Rolegroup</option>';
        foreach ($data as $key => $value) {
            $HTMLOption .= '<option value="' . $value->rgid . '">' . $value->name . '</option>';
        }
        return $HTMLOption;
    }
    public static function _getCompanyOption($active, $etype, $company_id)
    {
        $CompanyData = Companies::all();
        if (count($CompanyData)) {
            $dataHTML = OptionComponents::_getMakeOptionHTMLCompany($CompanyData);
            return CommonFunctions::_getReturnResponse(true, 'Loading Company...!!!', $dataHTML);
        } else {
            return CommonFunctions::_getReturnResponse(false, 'no data found...!!!', null);
        }
    }
    public function _getMakeOptionHTMLCompany($data, $HTMLOption = "")
    {
        foreach ($data as $key => $value) {
            $HTMLOption .= '<option select="" value="' . $value->company_id . '">' . $value->company_name . '</option>';
        }
        return $HTMLOption;
    }

    public static function _getFinancialYearOption($multiple, $active, $etype, $company_id)
    {
        $FinancialyearData = Financialyear::all();
        if (count($FinancialyearData)) {
            $dataHTML = OptionComponents::_getMakeOptionHTMLFinancialyear($FinancialyearData, $multiple);
            return CommonFunctions::_getReturnResponse(true, 'Loading Financialyear...!!!', $dataHTML);
        } else {
            return CommonFunctions::_getReturnResponse(false, 'no data found...!!!', null);
        }
    }
    public function _getMakeOptionHTMLFinancialyear($data, $multiple, $HTMLOption = "")
    {
        if (!((bool)$multiple))
            $HTMLOption .= '<option value="" selected="" disabled="">Choose Financialyear</option>';
        foreach ($data as $key => $value) {
            $HTMLOption .= '<option value="' . $value->financialyear_id . '">' . $value->financialyear_name . '</option>';
        }
        return $HTMLOption;
    }

    public static function _getUserOption($multiple, $active, $etype, $company_id)
    {
        $userData = Users::all();
        if (count($userData)) {
            $dataHTML = OptionComponents::_getMakeOptionHTMLUser($userData, $multiple);
            return CommonFunctions::_getReturnResponse(true, 'Loading Report To User...!!!', $dataHTML);
        } else {
            return CommonFunctions::_getReturnResponse(false, 'no data found...!!!', null);
        }
    }
    public function _getMakeOptionHTMLUser($data, $multiple, $HTMLOption = "")
    {
        if (!((bool)$multiple))
            $HTMLOption .= '<option value="" selected="" disabled="">Choose Financialyear</option>';
        foreach ($data as $key => $value) {
            $HTMLOption .= '<option value="' . $value->uid . '">' . $value->uname . '</option>';
        }
        return $HTMLOption;
    }

    public static function _getLevel3Option($multiple, $active, $etype, $company_id)
    {
        $sql = "SELECT level3.*,level3.l3 as level3_id,level3.name as 'level3_name' FROM 
        level3
        INNER JOIN level2 AS level2 ON level2.l2=level3.l2
        INNER JOIN level1 AS level1 ON level1.l1=level2.l1
        WHERE level3.name <> ''
        ORDER BY level1.name,level2.name,level3.name";
        $result = DB::select($sql);
        if (count($result)) {
            $Level3Data = CommonFunctions::result_array($result);
            $dataHTML = OptionComponents::_getMakeOptionHTMLLevel3($Level3Data, $multiple);
            return CommonFunctions::_getReturnResponse(true, 'Loading Level3...!!!', $dataHTML);
        } else {
            return CommonFunctions::_getReturnResponse(false, 'no data found...!!!', null);
        }
    }
    public function _getMakeOptionHTMLLevel3($data, $multiple, $HTMLOption = "")
    {
        if (!((bool)$multiple))
            $HTMLOption .= '<option value="" selected="" disabled="">Choose Level3</option>';
        foreach ($data as $key => $value) {
            $HTMLOption .= '<option value="' . $value['level3_id'] . '">' . $value['level3_name'] . '</option>';
        }
        return $HTMLOption;
    }
}
