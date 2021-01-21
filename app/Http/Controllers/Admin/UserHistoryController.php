<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use App\Models\UserBtcTransaction;
use App\Models\UserEthTransaction;

use App\Models\CurrencyDeposit;
use App\Models\AdminBtcDeposit;
use App\Models\AdminEthDeposit;
use App\Models\AdminBtcTransaction;
use App\Models\AdminEthTransaction;


use App\Models\UserBpcTransaction; 

use App\Models\Commission; 
use Carbon\Carbon;

class UserHistoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function userHistory()
    {
        $pairs = Commission::index();
        return view('usertransaction.history')->with('pair',$pairs);
    }

    public function userHistorySearch(Request $request)
    {

    	if($request->fromdate == ''){
            $request->from = '2019-01-01';
        }else{
            $request->from = new Carbon($request->fromdate);
        }

        if($request->todate == ''){
            $request->to = Carbon::now()->addDays(1);
        }else{
            $request->to = new Carbon(date('Y-m-d',strtotime($request->todate . "+1 days")));
        }

        if($request->pair == 'BTC'){
            $history = UserBtcTransaction::history($request);
        }elseif($request->pair == 'ETH')
        {
            $history = UserEthTransaction::history($request);
        }elseif($request->pair == 'BPC')
        {
            $history = UserBpcTransaction::history($request);
        }
        else{
            echo 'invalid coin';
        }
            
        return view('usertransaction.ajax_history')->with('history', $history)->with('pair', $request->pair)->with('type', $request->type)->render();
        

    } 

    public function userHistoryUpdate(Request $request)
    {
        if($request->pair == 'BTC'){
            $history = UserBtcTransaction::withdrawUpdate($request);
        }elseif($request->pair == 'ETH')
        {
            $history = UserEthTransaction::withdrawUpdate($request);
        } elseif($request->pair == 'BPC')
        {
            $history = UserBpcTransaction::withdrawUpdate($request);
        }else{
           echo 'invalid coin';
        }

        return back()->with('success','Updated Successfully');
    }

    public function usdDepositList()
    {
    	$usdDepositList = CurrencyDeposit::depsoitList('USD');
    	
    	return view('userdeposit.usd_deposit')->with(['deposit'=> $usdDepositList]);
    } 

    public function depositEdit($id)
    {
        $depositList = CurrencyDeposit::edit(Crypt::decrypt($id));

        return view('userdeposit.deposit_edit')->with(['deposit'=> $depositList]);
    }

    public function depositUpdate(Request $request)
    {
        $depositUpdate = CurrencyDeposit::statusUpdate($request);

        return back()->with('status','Deposit Updated Successfully');
    }


    public function adminBtcDeposit()
    {
        $history = AdminBtcTransaction::deposit();
        $coin = 'BTC';
        return view('history.deposit_history')->with(['history'=> $history,'coin' => $coin]);
    }

    public function adminEthDeposit()
    {
        $history = AdminEthTransaction::deposit();
        $coin = 'ETH';
        return view('history.deposit_history')->with(['history'=> $history,'coin' => $coin]);
    }

    public function adminJadaxDeposit()
    {
        $history = AdminJadaxTransaction::deposit();
        $coin = 'JADAX';
        return view('history.deposit_history')->with(['history'=> $history,'coin' => $coin]);
    }

      public function depositHistorySearch(Request $request)
    { 

        if($request->fromdate == ''){
            $request->from = '2019-01-01';
        }else{
            $request->from = new Carbon($request->fromdate);
        }

        if($request->todate == ''){
            $request->to = Carbon::now()->addDays(1);
        }else{
            $request->to = new Carbon(date('Y-m-d',strtotime($request->todate . "+1 days")));
        }

        if($request->pair == 'BTC'){
            $history = UserBtcTransaction::deposit_history($request);
        }elseif($request->pair == 'ETH')
        {
            $history = UserEthTransaction::deposit_history($request);

        }elseif($request->pair == 'BPC')
        {
            $history = UserBpcTransaction::deposit_history($request);
         
        }  
         else{
            echo 'invali coin';
        } 

        return view('user.transactions.ajax-history')->with('history', $history)->with('pair', $request->pair)->render();

    }
    
}
