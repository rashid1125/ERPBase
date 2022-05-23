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
        if (count($RolegroupData)){
            $dataHTML = OptionComponents::_getMakeOptionHTMLRoleGroup($RolegroupData);
            return CommonFunctions::getReturnResponse(true,'loaded Rolegroup...!!!',$dataHTML);
        }else {
            return CommonFunctions::getReturnResponse(false, 'no data found...!!!', null);
        }
    }
    public function _getMakeOptionHTMLRoleGroup($data, $HTMLOption = "")
    {
        $HTMLOption .= '<option value="" selected="" disabled="">Choose Rolegroup</option>';
        foreach ($data as $key => $value) {
            $HTMLOption .= '<option value="'.$value->rgid.'">'.$value->name.'</option>';
        }
        return $HTMLOption;
    }
    public static function _getCompanyOption($active, $etype, $company_id)
    {
        $CompanyData = Companies::all();
        if (count($CompanyData)){
            $dataHTML = OptionComponents::_getMakeOptionHTMLCompany($CompanyData);
            return CommonFunctions::getReturnResponse(true,'loaded Company...!!!',$dataHTML);
        }else {
            return CommonFunctions::getReturnResponse(false, 'no data found...!!!', null);
        }
    }
    public function _getMakeOptionHTMLCompany($data, $HTMLOption = "")
    {
        $HTMLOption .= '<option value="" selected="" disabled="">Choose Company</option>';
        foreach ($data as $key => $value) {
            $HTMLOption .= '<option value="'.$value->company_id.'">'.$value->company_name.'</option>';
        }
        return $HTMLOption;
    }
}
