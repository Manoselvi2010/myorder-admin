<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use App\Models\UserBtcTransaction;
use App\Models\UserEthTransaction;
use App\Models\UserJadaxTransaction;
use App\Models\CurrencyWithdraw;
use App\Models\AdminBtcTransaction;
use App\Models\AdminEthTransaction;
use App\Models\AdminJadaxTransaction;

class WithdrawController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }
    
    public function withdrawHistory()
    {
    	$pairs = Commission::index();
        return view('usertransaction.withdraw')->with('pair',$pairs);
    }

    public function withdrawHistorySearch($id)
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
            $history = UserBtcTransaction::withdraw_history($request);
        }elseif($request->pair == 'ETH')
        {
            $history = UserEthTransaction::withdraw_history($request);
        } else{
            $history = UserJadaxTransaction::withdraw_history($request);
        }
            
        return view('usertransaction.ajax_withdraw_history')->with('history', $history)->with('pair', $request->pair)->render();
    }

    public function updateBtcWithdraw(Request $request)
    {
        $withdraw = UserBtcTransaction::withdrawUpdate($request);

        return back()->with('status',$withdraw);

    }

    public function ethWithdrawList()
    {
    	$ethWithdraw = UserEthTransaction::histroy();
        
        return view('userwithdraw.eth_withdraw', ['currency' => 'ETH', 'transaction' => $ethWithdraw]);
    }

    public function ethWithdrawEdit($id)
    {
         $withdraw = UserEthTransaction::withdrawEdit($id);
        
        return view('userwithdraw.ethwithdraw_edit',[
            'withdraw' => $withdraw
        ]);
    }

    public function updateEthWithdraw(Request $request)
    {
        $withdraw = UserEthTransaction::withdrawUpdate($request);

        return back()->with('status',$withdraw);

    }

    public function jadaxWithdrawList()
    {
        $jadaxWithdraw = UserJadaxTransaction::withdraw();
        
        return view('userwithdraw.jadax_withdraw', ['currency' => 'JADAX', 'transaction' => $jadaxWithdraw]);
    }

    public function jadaxWithdrawEdit($id)
    {
         $withdraw = UserJadaxTransaction::withdrawEdit($id);
        
        return view('userwithdraw.jadaxwithdraw_edit',[
            'withdraw' => $withdraw
        ]);
    }

    public function updateJadaxWithdraw(Request $request)
    {
        $withdraw = UserJadaxTransaction::withdrawUpdate($request);

        return back()->with('status',$withdraw);

    }

    public function usdWithdrawList()
    {
    	$crypto_trasnaction = CurrencyWithdraw::histroy('USD');
        
        return view('userwithdraw.usd_withdraw', ['currency' => 'USD', 'transaction' => $crypto_trasnaction]); 
    } 


    public function withdrawEdit($id)
    {
        $crypto_trasnaction = CurrencyWithdraw::edit(Crypt::decrypt($id));
        
        return view('userwithdraw.withdraw_edit', ['withdraw' => $crypto_trasnaction]); 
    }

    public function withdrawUpdate(Request $request)
    {

        $crypto_trasnaction = CurrencyWithdraw::withdrawUpdate($request);

        return back()->with('status','Withdraw Updated Successfully');
    }



    public function adminBtcWithdraw()
    {
        $history = AdminBtcTransaction::withdraw();
        $coin = 'BTC';
        return view('history.withdraw_history')->with(['history'=> $history,'coin'=>$coin]);
    }

    public function adminEthWithdraw()
    {
        $history = AdminEthTransaction::withdraw();
        $coin = 'ETH';
        return view('history.withdraw_history')->with(['history'=> $history,'coin'=>$coin]);
    }

      public function adminLtcWithdraw()
    {
        $history = AdminBtcTransaction::withdraw();
        $coin = 'LTC';
        return view('history.withdraw_history')->with(['history'=> $history,'coin'=>$coin]);
    }

      public function adminXrpWithdraw()
    {
        $history = AdminBtcTransaction::withdraw();
        $coin = 'XRP';
        return view('history.withdraw_history')->with(['history'=> $history,'coin'=>$coin]);
    }

      public function adminLinearWithdraw()
    {
        $history = AdminBtcTransaction::withdraw();
        $coin = 'LINEAR';
        return view('history.withdraw_history')->with(['history'=> $history,'coin'=>$coin]);
    }

    public function adminUsdWithdraw()
    {
        $history = AdminBtcTransaction::withdraw();
        $coin = 'USD';
        return view('history.withdraw_history')->with(['history'=> $history,'coin'=>$coin]);
    }


    public function adminJadaxWithdraw()
    {
        $history = AdminJadaxTransaction::withdraw();
        $coin = 'JADAX';
        return view('history.withdraw_history')->with(['history'=> $history,'coin'=>$coin]);
    }
}
