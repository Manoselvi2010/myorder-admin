<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use App\Models\User;
use App\Models\UserProfile;
use App\Models\UserWallet;
use App\Models\UserActivity;
use App\Models\Commission;
use App\Models\Tradepair;
use App\Models\Tickets;
use App\Traits\AddressCreation;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserStatusMail; 
use Illuminate\Notifications\Notifiable;
use App;
use Auth;
use DB;

class UserController extends Controller
{
    use AddressCreation;
	public function __construct()
    {
        $this->middleware('admin');
    }    
    public function index()
    {
    	$details = User::index(); 
    	return view('user.details.index')->with('details',$details);
    }
    public function edit(Request $request)
    {
    	$user_id = Crypt::decrypt($request->id); 
        $wallet = User::userWalletDetails($user_id);
        $coin_list = Commission::on('mysql2')->get();
        $pair_lists = Tradepair::on('mysql2')->get();
        if($wallet == 0){
            $userAddressCreation = $this->userAddressCreation($user_id);
            if($userAddressCreation == 1)
            {                 
                return redirect('admin/users_edit/'.$request->id);
            }
        }
    	if($user_id)
    	{
            $user = User::find($user_id);   
            $tickets = Tickets::where('user_id',$user_id)->get();   
    		return view('user.details.edit', [
                                                'userdetails'   => $user,
                                                'wallet'        => $wallet,
                                                'coins'         => $coin_list,
                                                'uid'           => $user_id,
                                                'pair_lists'    => $pair_lists,
                                                'tickets'       => $tickets
                                            ]);
    	}
    }
    public function update(Request $request)
    {
    	$user = User::userUpdate($request);        
        if($user)
        {
            \Session::flash('updated_status', 'Profile Details Updated Successfully.');
        }
        else
        {
            \Session::flash('updated_status', 'Profile Details Updated Failed.');
        }        
    	return redirect()->back();
    }
    public function userSearchList(Request $request)
    {  
        $userSearchList = User::searchList($request);
        return view('user.users')->with('details',$userSearchList);
    }
    public function userStatus(Request $request)
    {
        if($request->status == 1){
            $message = 'Admin Activate your account.';
        }elseif($request->status == 2){
            $message = 'Admin Deactivate your account.';
        }
        $userSearchList = User::userStatusChange($request);
        $details = array(
                            'message'=>$message,  
                            'user' => user($request->user)->fname 
                        );
        Mail::to(user($request->user)->email)->send(new UserStatusMail($details));
        return response()->json(['message' => 'Update Successfully']);
    } 
    public function deactiveUser()
    {
        $details=User::list_deactive_user();
        return view('user.users')->with('details',$details);        
    }
    public function todayUser()
    {
        $details=User::list_today_user();
        return view('user.users')->with('details',$details);        
    }
    public function kyc_RequestUser()
    {
        $details=User::kyc_request_user();
        return view('user.users')->with('details',$details);        
    }
    public function updateWallet(Request $request)
    {
        $details = UserWallet::walletUpdate($request);
        return redirect()->back()->with('updated_status', 'Balance updated Successfully.');
    }
    public function buyTradeHistorySearch(Request $request)
    { 
        $uid = $request->uid; 
        if($request->pair == 'all'){
            $buytrades = DB::connection('mysql2')->table('buytrades')
                                ->join('tradepairs', 'buytrades.pair', '=', 'tradepairs.id')
                                ->select('buytrades.*', 'tradepairs.coinone','tradepairs.cointwo')
                                ->where([['buytrades.uid', '=', $uid]])
                                ->orderBy('buytrades.created_at', 'desc')
                                ->get();
        }else{
            $buytrades = DB::connection('mysql2')->table('buytrades')
                            ->join('tradepairs', 'buytrades.pair', '=', 'tradepairs.id')
                            ->select('buytrades.*', 'tradepairs.coinone','tradepairs.cointwo')
                            ->where([['buytrades.uid', '=', $uid]])
                            ->where([['buytrades.pair', '=', $request->pair]])
                            ->orderBy('buytrades.created_at', 'desc')
                            ->get();
        }
        return view('user.tradehistory.ajaxtradehistroy-buy')->with('buytrades', $buytrades)->render();
    }
    public function sellTradeHistorySearch(Request $request)
    { 
        $uid = $request->uid;
        if($request->pair == 'all'){
            $selltrades = DB::connection('mysql2')->table('selltrades')
                                ->join('tradepairs', 'selltrades.pair', '=', 'tradepairs.id')
                                ->select('selltrades.*', 'tradepairs.coinone','tradepairs.cointwo')
                                ->where([['selltrades.uid', '=', $uid]])
                                ->orderBy('selltrades.created_at', 'desc')
                                ->get();
        }else{
           $selltrades = DB::connection('mysql2')->table('selltrades')
                            ->join('tradepairs', 'selltrades.pair', '=', 'tradepairs.id')
                            ->select('selltrades.*', 'tradepairs.coinone','tradepairs.cointwo')
                            ->where([['selltrades.uid', '=', $uid]])
                            ->where([['selltrades.pair', '=', $request->pair]])
                            ->orderBy('selltrades.created_at', 'desc')
                            ->get();
        }
        return view('user.tradehistory.ajaxtradehistroy-sell')->with('selltrades', $selltrades)->render();
    }
    public function userActivity()
    {
        $data = UserActivity::paginate(30);
        return view('user.usersactivity')->with('details',$data);
    }    
}