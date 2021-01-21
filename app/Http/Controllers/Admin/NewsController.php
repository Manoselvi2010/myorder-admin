<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\FaqRequest;
use App\Models\News;

class NewsController extends Controller
{
    public function index()
    { 
        $news = News::on('mysql2')->paginate(15);
        return view('settings.news.index')->with('news',$news);
    }
    public function add()
    {
        return view('settings.news.add');
    }
    public function store(FaqRequest $request)
    { 
        $news = News::savenews($request);
        return redirect()->route('news.index')->with('success','Added Successfully');
    }
    public function edit($id)
    {
        $news = News::edit($id);
        return view('settings.news.edit')->with('news',$news);
    }
    public function update(Request $request)
    { 
        $news = News::newsUpdate($request); 
        return redirect()->route('news.index')->with('success',$news);
    }
    public function destroy($id)
    {
        $news = News::on('mysql2')->where('id',$id)->delete();
        return redirect()->route('news.index')->with('success','Deleted Successfully');
    }
}
