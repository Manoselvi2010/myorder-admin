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
use App\Traits\AddressCreation;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserStatusMail; 
use Illuminate\Notifications\Notifiable;
use Excel;
use PDF;
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
    	return view('users.index')->with('details',$details);
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
    		return view('users.edit', [
                                            'userdetails' => $user,
                                            'wallet' => $wallet,
                                            'coins' => $coin_list,
                                            'uid' => $user_id,
                                            'pair_lists' => $pair_lists
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

    public function excel_view(Request $request)
    {
        $user_id = Crypt::decrypt($request->id); 
        $user_details = User::getIndividualUser($user_id);

        if($user_id)
        {            
            return view('user.userexcelview')->with('user',$user_details);
        }
    }

     public function exportExcel()
    {         
         /* $items = User::excelExport();
              Excel::create('user', function($excel) use($items) {
                  $excel->sheet('ExportFile', function($sheet) use($items) {
                      $sheet->fromArray($items);
                  });
              })->export('xls');*/


    Excel::create('Jadax_users_details', function ($excel) {
    $excel->sheet('Sheetname', function ($sheet) {
        // first row styling and writing content
        $sheet->mergeCells('A1:K1');
        $sheet->mergeCells('F2:H2');
        $sheet->mergeCells('I2:K2');
        $sheet->mergeCells('L2:N2');

        $sheet->setCellValue('H2','=SUM(F2:G2)');
        $sheet->setCellValue('K2','=SUM(I2:J2)');
        $sheet->setCellValue('N2','=SUM(L2:M2)');

        // $sheet->setMergeColumn(array(
        //     'columns' => array('A','B','C','D'),
        //     'rows' => array(
        //         array(2,3),
        //         array(5,11),
        //         )
        //     ));

        $sheet->cell('F2', function($cell) {
    // manipulate the cell
            $cell->setValue('BTC Wallets');
            $cell->setFontWeight('bold');

        });
        $sheet->cell('I2', function($cell) {
    // manipulate the cell
            $cell->setValue('ETH Wallets');
            $cell->setFontWeight('bold');

        });
        $sheet->cell('L2', function($cell) {
    // manipulate the cell
            $cell->setValue('Jadax Wallets');
            $cell->setFontWeight('bold');

        });

        $sheet->row(1, function ($row) {
            // $row->setFontFamily('Comic Sans MS');
            // $row->setFontSize(30);
        });
        $sheet->row(1, array('Jadax User Details'));
        // second row styling and writing content
        // $sheet->row(2, function ($row) {
        //    // call cell manipulation methods
        //     // $row->setFontFamily('Comic Sans MS');
        //     // $row->setFontSize(15);
        //     // $row->setFontWeight('bold');
        // });
        // $sheet->row(2, array('Something else here'));
        // getting data to display - in my case only one record
        $users = User::excelExport();
        // setting column names for data - you can of course set it manually
        $sheet->appendRow(array_keys($users[0])); // column names
        // getting last row number (the one we already filled and setting it to bold
        $sheet->row($sheet->getHighestRow(), function ($row) {
            $row->setFontWeight('bold');
        });
       // putting users data as next rows
        foreach ($users as $user) {
            
            $sheet->appendRow($user);
        }
    });
        })->export('xls');
        //return Excel::download(new User, 'user'.date('dMY').'.xlsx');
    }


    public function exportIndividualUserXls(Request $request)
    { 
          $user_id = $request->segment(4);   
          $type=$request->segment(5);       
          $users = User::getIndividualUser($user_id); 
          

          if($type== 'pdf'){
                $pdf = PDF::loadView('user.test',array('user'=> $users));
                return $pdf->download('user.pdf');
          }else{
              Excel::create('user', function($excel) use($users) {
                $excel->sheet('sheet1', function($sheet) use($users) {
                    $sheet->loadView('user.convertexcel')->with('user',$users);
                });
            })->download($type);
          }              
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
