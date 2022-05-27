<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class rolegroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('rolegroups')->insert(array(
            'name' => 'SUPER ADMIN',
            'desc' => '{
	"vouchers": {
		"level": {
			"level": 1,
			"insert": 1,
			"update": 1,
			"delete": 1,
			"print": 1
		},
		"account": {
			"account": 1,
			"insert": 1,
			"update": 1,
			"delete": 1,
			"print": 1
		},
		"vehicleregister": {
			"vehicleregister": 1,
			"insert": 1,
			"update": 1,
			"delete": 1,
			"print": 1
		},
		"salesman": {
			"salesman": 1,
			"insert": 1,
			"update": 1,
			"delete": 1,
			"print": 1
		},
		"guarantor": {
			"guarantor": 1,
			"insert": 1,
			"update": 1,
			"delete": 1,
			"print": 1
		},
		"transporter": {
			"transporter": 1,
			"insert": 1,
			"update": 1,
			"delete": 1,
			"print": 1
		},
		"catagory": {
			"catagory": 1,
			"insert": 1,
			"update": 1,
			"delete": 1,
			"print": 1
		},
		"subcatagory": {
			"subcatagory": 1,
			"insert": 1,
			"update": 1,
			"delete": 1,
			"print": 1
		},
		"brand": {
			"brand": 1,
			"insert": 1,
			"update": 1,
			"delete": 1,
			"print": 1
		},
		"made": {
			"made": 1,
			"insert": 1,
			"update": 1,
			"delete": 1,
			"print": 1
		},
		"item": {
			"item": 1,
			"insert": 1,
			"update": 1,
			"delete": 1,
			"print": 1
		},
		"dipchart": {
			"dipchart": 1,
			"insert": 1,
			"update": 1,
			"delete": 1,
			"print": 1
		},
		"stocklocation": {
			"stocklocation": 1,
			"insert": 1,
			"update": 1,
			"delete": 1,
			"print": 1
		},
		"station": {
			"station": 1,
			"insert": 1,
			"update": 1,
			"delete": 1,
			"print": 1
		},
		"nozzle": {
			"nozzle": 1,
			"insert": 1,
			"update": 1,
			"delete": 1,
			"print": 1
		},
		"setting": {
			"setting": 1,
			"insert": 1,
			"update": 1,
			"delete": 1,
			"print": 1
		},
		"ratechange": {
			"ratechange": 1,
			"insert": 1,
			"update": 1,
			"delete": 1,
			"print": 1
		},
		"fuelpurchasevoucher": {
			"fuelpurchasevoucher": 1,
			"insert": 1,
			"update": 1,
			"delete": 1,
			"print": 1
		},
		"purchaseorder": {
			"purchaseorder": 1,
			"insert": 1,
			"update": 1,
			"delete": 1,
			"print": 1
		},
		"purchasevoucher": {
			"purchasevoucher": 1,
			"insert": 1,
			"update": 1,
			"delete": 1,
			"print": 1
		},
		"purchasereturnvoucher": {
			"purchasereturnvoucher": 1,
			"insert": 1,
			"update": 1,
			"delete": 1,
			"print": 1
		},
		"nozzelsalevoucher": {
			"nozzelsalevoucher": 1,
			"insert": 1,
			"update": 1,
			"delete": 1,
			"print": 1
		},
		"lubesale": {
			"lubesale": 1,
			"insert": 1,
			"update": 1,
			"delete": 1,
			"print": 1
		},
		"creditsale": {
			"creditsale": 1,
			"insert": 1,
			"update": 1,
			"delete": 1,
			"print": 1
		},
		"bulksalevoucher": {
			"bulksalevoucher": 1,
			"insert": 1,
			"update": 1,
			"delete": 1,
			"print": 1
		},
		"saleordervoucher": {
			"saleordervoucher": 1,
			"insert": 1,
			"update": 1,
			"delete": 1,
			"print": 1
		},
		"salevoucher": {
			"salevoucher": 1,
			"insert": 1,
			"update": 1,
			"delete": 1,
			"print": 1
		},
		"salereturnvoucher": {
			"salereturnvoucher": 1,
			"insert": 1,
			"update": 1,
			"delete": 1,
			"print": 1
		},
		"gainloss": {
			"gainloss": 1,
			"insert": 1,
			"update": 1,
			"delete": 1,
			"print": 1
		},
		"navigationvoucher": {
			"navigationvoucher": 1,
			"insert": 1,
			"update": 1,
			"delete": 1,
			"print": 1
		},
		"openingbalance": {
			"openingbalance": 1,
			"insert": 1,
			"update": 1,
			"delete": 1,
			"print": 1
		},
		"cash_payment": {
			"cash_payment": 1,
			"insert": 1,
			"update": 1,
			"delete": 1,
			"print": 1
		},
		"cash_receipt": {
			"cash_receipt": 1,
			"insert": 1,
			"update": 1,
			"delete": 1,
			"print": 1
		},
		"chequepaidvoucher": {
			"chequepaidvoucher": 1,
			"insert": 1,
			"update": 1,
			"delete": 1,
			"print": 1
		},
		"chequereceiptvoucher": {
			"chequereceiptvoucher": 1,
			"insert": 1,
			"update": 1,
			"delete": 1,
			"print": 1
		},
		"jvvoucher": {
			"jvvoucher": 1,
			"insert": 1,
			"update": 1,
			"delete": 1,
			"print": 1
		},
		"staff": {
			"staff": 1,
			"insert": 1,
			"update": 1,
			"delete": 1,
			"print": 1
		},
		"updateshift": {
			"updateshift": 1,
			"insert": 1,
			"update": 1,
			"delete": 1,
			"print": 1
		},
		"shift": {
			"shift": 1,
			"insert": 1,
			"update": 1,
			"delete": 1,
			"print": 1
		},
		"warehouse": {
			"warehouse": 1,
			"insert": 1,
			"update": 1,
			"delete": 1,
			"print": 1
		},
		"othersetting": {
			"othersetting": 1,
			"insert": 1,
			"update": 1,
			"delete": 1,
			"print": 1
		},
		"staff_attendance": {
			"staff_attendance": 1,
			"insert": 1,
			"update": 1,
			"delete": 1,
			"print": 1
		},
		"update_attendance_status": {
			"update_attendance_status": 1,
			"insert": 1,
			"update": 1,
			"delete": 1,
			"print": 1
		},
		"multipleovertime": {
			"multipleovertime": 1,
			"insert": 1,
			"update": 1,
			"delete": 1,
			"print": 1
		},
		"penalty": {
			"penalty": 1,
			"insert": 1,
			"update": 1,
			"delete": 1,
			"print": 1
		},
		"loan": {
			"loan": 1,
			"insert": 1,
			"update": 1,
			"delete": 1,
			"print": 1
		},
		"advance": {
			"advance": 1,
			"insert": 1,
			"update": 1,
			"delete": 1,
			"print": 1
		},
		"incentive": {
			"incentive": 1,
			"insert": 1,
			"update": 1,
			"delete": 1,
			"print": 1
		},
		"salary_sheet": {
			"salary_sheet": 1,
			"insert": 1,
			"update": 1,
			"delete": 1,
			"print": 1
		},
		"uservoucher": {
			"uservoucher": 1,
			"insert": 1,
			"update": 1,
			"delete": 1,
			"print": 1
		},
		"changepassword": {
			"changepassword": 1,
			"insert": 1,
			"update": 1,
			"delete": 1,
			"print": 1
		},
    	        "financialyearvoucher": {
			"financialyearvoucher": 1,
			"insert": 1,
			"update": 1,
			"delete": 1,
			"print": 1
		},
		"previllages": {
			"previllages": 1,
			"insert": 1,
			"update": 1,
			"delete": 1,
			"print": 1
		}
	},
	"reports": {
		"Vehiclelist": 1,
		"coa": 1,
		"coi": 1,
		"purchasediesel": 1,
		"ratechangereport": 1,
		"purchaseorderreport": 1,
		"pendingpo": 1,
		"purchasereport": 1,
		"purchasereportsummary": 1,
		"purchasereturnreport": 1,
		"purchasereturnreportsummary": 1,
		"nozzleReport": 1,
		"LubeSale": 1,
		"crsalereport": 1,
		"BulkSaleReport": 1,
		"salebill": 1,
		"saleorderreport": 1,
		"pendingso": 1,
		"salereport": 1,
		"salereportsummary": 1,
		"salereturnreport": 1,
		"salerreturneportsummary": 1,
		"stocknavigationreport": 1,
		"gainlossreport": 1,
		"itemledger": 1,
		"stockreport": 1,
		"stockreportvalue": 1,
		"Inventorysummary": 1,
		"dailytransactionreport": 1,
		"account_report_daybookreport": 1,
		"account_report_cashpayment": 1,
		"account_report_cashreceipt": 1,
		"account_chequeissue_report": 1,
		"account_chequereceive_report": 1,
		"account_report_jvreport": 1,
		"freezeaccountreport": 1,
		"creditviolation": 1,
		"account_report_expensereport": 1,
		"account_ledger": 1,
		"account_report_receiveablereport": 1,
		"account_report_payablereport": 1,
		"cash_flow_statement": 1,
		"trial_balance_6": 1,
		"plsitem": 1,
		"profitandlossbalancesheet": 1,
		"department_listing": 1,
		"staff_status": 1,
		"staff_attendance_status_wise": 1,
		"staff_monthly_attendance_report": 1,
		"staff_attendance_sheet": 1,
		"penalty_to_staff": 1,
		"overtime_to_staff": 1,
		"loan_to_staff": 1,
		"advance_to_staff": 1,
		"incentive_to_staff": 1,
		"eobi_contribution": 1,
		"social_security_contribution": 1,
		"privillages_assigned_to_user": 1,
		"trial_balance": 1,
		"backupdatabase": 1,
		"dashboard": 1,
		"dashboardnew": 1,
		"dashboard1": 1,
		"SetupManagementModule": 1,
		"PurchaseManagementModule": 1,
		"SaleManagementModule": 1,
		"InventoryManagementModule": 1,
		"AccountManagementModule": 1,
		"PayrollManagementModule": 1,
		"UtilitiesManagementModule": 1
	}
}',
            'isadmin' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ));
    }
}
