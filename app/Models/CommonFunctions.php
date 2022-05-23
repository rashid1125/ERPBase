<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Request;

class CommonFunctions extends Model
{
    public static function convertObjectToArray($object)
    {
        $array = array();
        foreach ($object as $obj) {
            $array[] =  (array) $obj;
        }
        return $array;
    }

    /**
     * _getObjectToArray function
     *
     * @param object $object
     * @return array
     */
    public static function _getObjectToArray($object)
    {
        return @json_decode(json_encode($object), true);
    }
    /**
     * _getValidRoleGroupUserPermissions function
     *
     * @param string $RightsType
     * @param string $RightsName
     * @param boolean $ReturnFlag
     * @return boolean
     */
    public static function _getValidRoleGroupUserPermissions(string $RightsType, string $RightsName, bool $ReturnFlag = false)
    {
        // fetch role group from database by user session id
        $RoleGroupByUserId = Rolegroups::find(Session::get('rgid'));
        $desc = $RoleGroupByUserId['desc'];

        // parse json into array
        $desc = json_decode($desc);
        $desc = CommonFunctions::_getObjectToArray($desc);
        // 
        $vouchers = $desc['vouchers'];
        $reports = $desc['reports'];

        // check if array key exists in vouchers
        if (array_key_exists($RightsName, $vouchers)) {
            if ($RightsType === "vouchers") {
                if (($vouchers[$RightsName][$RightsName]) == 1) {
                    $ReturnFlag = true;
                }
            }
        }

        // check if array key exists in reports
        if (array_key_exists($RightsName, $reports)) {
            if ($RightsType === "reports") {
                if ($reports[$RightsName] == 1) {
                    $ReturnFlag = true;
                }
            }
        }
        return $ReturnFlag;
    }


    public static function _getEtypeNarration()
    {
        $etype = isset($_POST['etype'])  ? $_POST['etype'] : $_GET['etype'];
        $result = DB::table('etypenarrations')->where('etype', $etype)->get();
        if (count($result) > 0) {
            return $result;
        } else {
            return false;
        }
    }

    public static function checkValueIsNullOffObject($object)
    {
        $array = [];
        foreach ($object  as $key => $value) {
            $array[$key] =  (!$value || $value == 'null') ? null : $value;
        }
        return $array;
    }
    public static function row_array($object)
    {
        $object = CommonFunctions::convertObjectToArray($object);
        return $object[0];
    }
    public static function result_array($object)
    {
        $object = CommonFunctions::convertObjectToArray($object);
        return $object;
    }

    public static function returnResponse($status, $message, $data = null, $error = "")
    {
        $response = array();
        $response['status'] = $status;
        $response['message'] = $message;
        $response['data'] = $data;
        $response['error'] = $error;
        return $response;
    }

    public static function getReturnResponse($status, $message, $data = null, $error = "", $locationReload = null)
    {
        $response = array();
        $response['status'] = $status;
        $response['message'] = $message;
        $response['data'] = $data;
        $response['error'] = $error;
        $response['location'] = $locationReload;
        return $response;
    }

    public static function array_column(array $input, $columnKey, $indexKey = null)
    {
        $array = array();
        foreach ($input as $value) {
            if (!array_key_exists($columnKey, $value)) {
                trigger_error("Key \"$columnKey\" does not exist in array");
                return false;
            }
            if (is_null($indexKey)) {
                $array[] = $value[$columnKey];
            } else {
                if (!array_key_exists($indexKey, $value)) {
                    trigger_error("Key \"$indexKey\" does not exist in array");
                    return false;
                }
                if (!is_scalar($value[$indexKey])) {
                    trigger_error("Key \"$indexKey\" does not contain scalar value");
                    return false;
                }
                $array[$value[$indexKey]] = $value[$columnKey];
            }
        }
        return $array;
    }

    public static function checkMsgByEtypeAndVoucherType($etype, $voucher_type_hidden)
    {
        if ($etype == 'pur_order')
            $etype = 'Purchase Order';
        else if ($etype == 'purchase')
            $etype = 'Purchase';
        else if ($etype == 'purchasereturn')
            $etype = 'Purchase Return';
        else if ($etype == 'quotationorder')
            $etype = 'QV';
        else if ($etype == 'outwardvoucher')
            $etype = 'OGP Gate Pass';
        else if ($etype == 'sale')
            $etype = 'Sale Invoice';
        else if ($etype == 'salereturn')
            $etype = 'Sale Return';
        else if ($etype == 'requisition')
            $etype = 'Requisition';
        else if ($etype == 'inwardvoucher')
            $etype = 'IGP (Inward Gate Pass)';
        else if ($etype == 'consumption')
            $etype = 'Issuance / Consumption';
        else if ($etype == 'materialreturn')
            $etype = 'Material Return';
        else if ($etype == 'navigation')
            $etype = 'Stock Transfer';
        else if ($etype == 'coiltransfer')
            $etype = 'Coil Transfer';
        else if ($etype == 'stadjustment')
            $etype = 'Stock Adjustment';
        else if ($etype == 'joborder')
            $etype = 'Job Order';
        else if ($etype == 'stripjoborder')
            $etype = 'Strip Job Order';
        else if ($etype == 'production')
            $etype = 'Srtip Production';
        else if ($etype == 'pipeproduction')
            $etype = 'Pipe Production';
        else if ($etype == 'cpv')
            $etype = 'Cash Payment';
        else if ($etype == 'crv')
            $etype = 'Cash Reciept';
        else if ($etype == 'pd_issue')
            $etype = 'Cheque Issue';
        else if ($etype == 'pd_receive')
            $etype = 'Cheque Receipt';
        else if ($etype == 'jv')
            $etype = 'JV';
        else if ($etype == 'openingbalance')
            $etype = 'Opening Balance';
        else if ($etype == 'openingstock')
            $etype = 'Opening Stock';
        else if ($etype == 'c_pur')
            $etype = 'Coil Purchase Voucher';
        else if ($etype == 'pporder')
            $etype = 'Pipe Purchase Order';
        else if ($etype == 'pinward')
            $etype = 'Pipe Inward GP';
        else if ($etype == 'ppurchase')
            $etype = 'Pipe Purchase';
        else if ($etype == 'quot')
            $etype = 'Quotation';
        else if ($etype == 'saleorder')
            $etype = 'Sale Order';
        else if ($etype == 'coil_sale')
            $etype = 'Coil Sale';
        else if ($etype == 'csale_return')
            $etype = 'Sale Return';
        else if ($etype == 'reparingoutward')
            $etype = 'Repairing Outward';
        else if ($etype == 'reparinginward')
            $etype = 'Repairing Inward';
        else if ($etype == 'c_in')
            $etype = 'Coil Inward (IGP)';
        else if ($etype == 'dr_note')
            $etype = 'Debit Note';
        else if ($etype == 'cr_note')
            $etype = 'Credit Note';
        else if ($etype == 'biltyvr')
            $etype = 'Bilty';
        else if ($etype == 'online_rv')
            $etype = 'Online Receiving Payment';
        else if ($etype == 'lcpv')
            $etype = 'L.C Payment';
        else if ($etype == 'multipd_issue')
            $etype = 'Multi Cheque Payment';
        else if ($etype == 'multipd_receive')
            $etype = 'Multi Cheque Receipt';
        else if ($etype == 'cpo')
            $etype = 'Coil Purchase Order';
        else if ($etype == 'rackmanagement')
            $etype = 'Rack Management';
        else if ($etype == 'packing')
            $etype = 'Packing List';
        else if ($etype == 'cmi')
            $etype = 'Commercial Invoice';
        else if ($etype == 'bl')
            $etype = 'Bill Of Loading';
        else if ($etype == 'vehicleoutward')
            $etype = 'Vehicle Outward';
        return $etype . ' ' . $voucher_type_hidden;
    }

    public static function _getLogActivityDetail($vrnoa, $etype, $result, $voucher_type_hidden = "")
    {
        if (isset($_POST['voucher_type_hidden']))
            $voucher_type_hidden = $_POST['voucher_type_hidden'];
        else if (isset($_POST['vth']))
            $voucher_type_hidden = $_POST['vth'];

        CommonFunctions::_getLogActivityDetailSaved($vrnoa, $voucher_type_hidden, $etype, $result);
    }

    public static function _getLogActivityDetailSaved($vrnoa, $voucher_type_hidden, $etype, $returneddata)
    {

        $action = Route::currentRouteAction();
        $pdata = explode("@", $action);
        $var['sessionid'] = Session::getId();
        $var['userid'] = Session::get('uid');
        $var['vrnoa'] = $vrnoa;
        $var['etype'] = $etype;
        $var['activity_name'] = $pdata[1];
        $var['controller_name'] = $pdata[0];
        if ($voucher_type_hidden == "new" || $voucher_type_hidden == "edit")
            $var['action_name'] = ($voucher_type_hidden == "new") ? "Inserted" : "Updated";
        else
            $var['action_name'] = $voucher_type_hidden;
        $var['activity_msg'] = CommonFunctions::checkMsgByEtypeAndVoucherType($etype, $var['action_name']);
        $var['requestdetail'] = json_encode(($_POST !== []) ? $_POST : Request::segments());
        $var['datareturned'] = json_encode($returneddata);
        $var['company_id'] = (Session::get('company_id')) ? Session::get('company_id') : Request::get('company_id');
        $var['fn_id'] = (Session::get('fn_id')) ? Session::get('fn_id') : Request::get('fn_id');
        $var['uid'] = (Session::get('uid')) ? Session::get('uid') : Request::get('uid');
        DB::table('user_log_activity')->insertGetId($var);
    }
    public static function _getViewAllFromQueryBaseData($etype, $active)
    {
        $data = DB::table('query_dynamics')->where('etype', $etype)->get();
        return  $data;
    }
    public static function _getQueryDynamicsView($query_dynamics_table_name, $query_dynamics_column, $query_dynamics_join, $query_dynamics_where)
    {
        $sql  = "SELECT {$query_dynamics_column} FROM {$query_dynamics_table_name} {$query_dynamics_join} WHERE 1=1 {$query_dynamics_where}";
        $query = DB::select($sql);
        if (count($query) > 0) {
            $result = CommonFunctions::result_array($query);
            return CommonFunctions::getReturnResponse(true, 'Wait data is loading', $result);
        } else {
            return CommonFunctions::getReturnResponse(false, 'No Data Found', null);
        }
    }
}
