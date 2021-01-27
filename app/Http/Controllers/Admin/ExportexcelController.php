<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use App\Models\User;
use Excel;
use PDF;

class ExportexcelController extends Controller
{
    public function show(Request $request)
    {
        $user_id = Crypt::decrypt($request->id); 
        $user_detail = User::getIndividualUser($user_id);
        if($user_detail)
        {            
            return view('user.excel.show')->with('user_detail',$user_detail);
        }
    }
    public function export_excel()
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
    public function induvidual_export_excel(Request $request)
    { 
    	$data = $request->all();
        $user_id = $request->segment(4);   
        $type=$request->segment(5);       
        $user = User::getIndividualUser($user_id); 
        // printf(json_encode($user));exit;
        if($type== 'pdf')
        {
	        $pdf = PDF::loadView('user.excel.pdf_convert', compact('user'));  
	        return $pdf->download('UserDetails.pdf');        
        }else{
            Excel::create('User Details', function($excel) use($users) {
                $excel->sheet('sheet1', function($sheet) use($users) {
                    $sheet->loadView('user.excel.convert')->with('user',$user);
                });
            })->download($type);
        }              
    }
}
