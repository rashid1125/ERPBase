<?php

use Illuminate\Support\Facades\Session;

use App\Models\SettingConfigurations;
use App\Models\CommonFunctions;
use App\Models\Rolegroups;

/**
 * Tests if a string is a valid mysql date.
 *
 * @param string date to check
 * @return boolean
 */
if (!function_exists('_getIsAlreadyMysqlDate')) {
    function _getIsAlreadyMysqlDate($date)
    {
        $d = preg_match('#^(?P<year>\d{2}|\d{4})([- /.])(?P<month>\d{1,2})\2(?P<day>\d{1,2})$#', $date, $matches)
            && checkdate($matches['month'], $matches['day'], $matches['year']);
        if ($d)
            return $date;
        else return _getDateinSqlFormat($date);
    }
}
/**
 * _getDateinSqlFormat
 *
 * @param  mixed $date
 * @return string
 */
if (!function_exists('_getDateinSqlFormat')) {
    function _getDateinSqlFormat($date)
    {
        $format = _getSettingDateFormat();
        // HOWEVER WE CAN INJECT THE FORMATTING WHEN WE DECODE THE DATE
        $dateobj = DateTime::createFromFormat($format, $date);
        return $dateobj->format('Y-m-d');
    }
}

/**
 * _getSettingDateFormat
 *
 * @return string
 */
if (!function_exists('_getSettingDateFormat')) {
    function _getSettingDateFormat()
    {
        $SettingConfigurations =  SettingConfigurations::all();
        return $SettingConfigurations[0]['date_format_php'];
    }
}

/**
 * _getInsertedUpdatedDeletedRights
 *
 * @param  mixed $voucherTypeHiddenKey
 * @return string
 */
if (!function_exists('_getInsertedUpdatedDeletedRights')) {
    function _getInsertedUpdatedDeletedRights($voucherTypeHiddenKey)
    {
        $response = array();

        $voucherRightsEtype = _getEtypeNarration();
        if (!((bool)($voucherRightsEtype) == false)) {
            if (array_key_exists($voucherTypeHiddenKey, $_POST) && ($_POST[$voucherTypeHiddenKey]) === 'edit') {
                $response = _getVerifyInsertedUpdatedDeletedRights($voucherRightsEtype[0]->voucherrights, 'update');
            } else if (array_key_exists($voucherTypeHiddenKey, $_POST) && ($_POST[$voucherTypeHiddenKey]) === 'deleteVoucher') {
                $response = _getVerifyInsertedUpdatedDeletedRights($voucherRightsEtype[0]->voucherrights, 'delete');
            } else if (array_key_exists($voucherTypeHiddenKey, $_POST) && ($_POST[$voucherTypeHiddenKey]) === 'printVoucher') {
                $response = _getVerifyInsertedUpdatedDeletedRights($voucherRightsEtype[0]->voucherrights, 'print');
            } else {
                $response = _getVerifyInsertedUpdatedDeletedRights($voucherRightsEtype[0]->voucherrights, 'insert');
            }
        } else $response = CommonFunctions::getReturnResponse(false, 'No rights to this voucher...!!!', null);
        return $response;
    }
}
/**
 * _getEtypeNarration
 *
 * @return array
 */
if (!function_exists('_getEtypeNarration')) {
    function _getEtypeNarration()
    {
        $data = CommonFunctions::_getEtypeNarration();
        return $data;
    }
}

/**
 * _getVerifyInsertedUpdatedDeletedRights function
 *
 * @param string $voucherRights
 * @param string $givenRights
 * @param string $message
 * @param boolean $flag
 * @return array
 */
if (!function_exists('_getVerifyInsertedUpdatedDeletedRights')) {
    function _getVerifyInsertedUpdatedDeletedRights($voucherRights, $givenRights, $message = "", $flag = false)
    {
        $RoleGroupByUserId = Rolegroups::find(Session::get('rgid')); // get data from rolegroup with user id
        $desc = $RoleGroupByUserId['desc'];

        // parse json into array
        $desc = json_decode($desc); // data convert into be array
        $desc = CommonFunctions::_getObjectToArray($desc); // data convert into json to array object

        $vouchers = $desc['vouchers'];

        if (array_key_exists($voucherRights, $vouchers)) { // validate if key avaliable in given array then next
            if (((int)($vouchers[$voucherRights][$givenRights]) == 0)) { // validate if rights have
                $flag = true;
            }
        }

        // Typing check rights message
        if ($givenRights === "insert") {
            $message = 'Sorry! you have no insert rights...!!!';
        } else if ($givenRights === "update") {
            $message = 'Sorry! you have no update rights...!!!';
        } else if ($givenRights === "delete") {
            $message = 'Sorry! you have no delete rights...!!!';
        } else if ($givenRights === "print") {
            $message = 'Sorry! you have no print rights...!!!';
        }

        if (((bool)($flag))) {
            return CommonFunctions::getReturnResponse(false, $message, null);
        } else return CommonFunctions::getReturnResponse(true, 'User has rights for work activities...!!!', null);
    }
}
