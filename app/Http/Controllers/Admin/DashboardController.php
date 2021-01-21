<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Session;
use App\Models\User;
use App\Models\Security;
use App\Models\Admin;
use App\Traits\Dashboard;
use App\Models\Adminwallet;
use App\Models\Commission;
use App\Models\Tickets;
use App\Models\Kyc;
use DB;

class DashboardController extends Controller
{
    use Dashboard;

	public function __construct()
    {
        $this->middleware('admin');
    }
    public function index()
    {
    	$dashboard = User::dashboard();
        $siteUserBalance = $this->siteUserBalance();
        $income = $this->income();
        $commissions = Commission::leftJoin('adminwallet', function($join) {
                                        $join->on('commissions.source', '=', 'adminwallet.currency');
                                       })
                                       ->select('commissions.*')
                                       ->addSelect('adminwallet.commission as trade_commission')
                                       ->addSelect('adminwallet.withdraw as withdraw_commission')
                                       ->addSelect('adminwallet.currency')
                                       ->orderBy('commissions.id','ASC')
                                       ->get();
        $user_countries = User::select('country_code', DB::raw('count(*) as count'))
                                ->groupBy('country_code')
                                ->get();   
        $tickets = Tickets::orderBy('id','desc')->take(5)->get();                                    
        $kyc_details = Kyc::where('status','0')->orderBy('id','desc')->take(5)->get();
        $user_wallets = Commission::select(DB::raw("SUM(user_wallets.balance + 
                                        user_wallets.escrow_balance) as total_balance"))
                                    ->leftjoin("user_wallets","user_wallets.currency","=","commissions.source")
                                    ->addSelect('commissions.source')
                                    ->groupBy("commissions.source")
                                    ->orderBy('commissions.id','ASC')
                                    ->get();
    	return view('dashboard')->with('details',$dashboard)
                                ->with('siteUserBalance',$siteUserBalance)
                                ->with('income',$income)                                
                                ->with('commissions',$commissions)
                                ->with('user_countries',$user_countries)
                                ->with('tickets',$tickets)
                                ->with('kyc_details',$kyc_details)
                                ->with('user_wallets',$user_wallets);
    }    
}