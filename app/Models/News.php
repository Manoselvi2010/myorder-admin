<?php
namespace App\Models;


use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\URL;

class News extends Model
{
	  protected $fillable = ['title', 'decription','status'];

	public static function savenews($request)
    {
    	$news = new News();
        $data = $request->all();
    	$news->setConnection('mysql2');
        $fileName = uniqid().'.'.$request->blog_image->extension();  
        $request->blog_image->move(storage_path('app/public/news/'), $fileName);
        $news->title        = $request->title;
        $news->description  = $request->description;
        $news->image        = $fileName;
        $news->status       = $request->status; 
        $news->save(); 
        return true;
    }
    public static function edit($id)
    {
    	$news = News::on('mysql2')->where('id',$id)->first(); 
    	return $news;
    }
    public static function newsUpdate($request)
    {
        $news = News::on('mysql2')->where('id', $request->id)->first();
        if(Input::hasFile('blog_image')){
            $fileName = uniqid().'.'.$request->blog_image->extension();  
            $request->blog_image->move(storage_path('app/public/news/'), $fileName);
        }else{
            $fileName = "";
        }    
        $news->title        = $request->title;
        $news->description  = $request->description;
        $news->image        = $fileName;
        $news->status       = $request->status; 
        $news->save();
        return $news='Updated Successfully';
    }
}
	