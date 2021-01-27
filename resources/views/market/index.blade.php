@extends('layouts.header')
@section('title', 'Users List - Admin')
@section('content')
<style type="text/css">
  .nav-link {
    display: block;
    padding: 1rem 16rem;
  }
</style>
<section class="content">
  <header class="content__title">
    <h1>View User Details</h1>
  </header>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <div class="tab-container">
            <ul class="nav nav-tabs" role="tablist">
              @foreach($market_lists as $market_list)
                <li class="nav-item">
                  <a class="nav-link @if($first_maket_name == $market_list->cointwo) active @else @endif" data-toggle="tab" href="#{{$market_list->cointwo}}" role="tab">{{$market_list->cointwo}}</a>
                </li>
              @endforeach
            </ul>
            <div class="tab-content">
              @forelse($market_lists as $market_list)
                <div class="tab-pane @if($first_maket_name == $market_list->cointwo) active @else @endif fade show" id="{{$market_list->cointwo}}" role="tabpanel">
                  <div class="table-responsive search_result">
                    <table class="table" style="background-color: #1a417d;">
                      <thead>
                        <tr>
                          <th>Pairs</th>
                          <th>Last price</th>
                          <th>Change</th>
                        </tr>
                      </thead>
                      <tbody class="site-table">
                        @forelse($trades as $key => $trade)
                          @if($trade->cointwo == $market_list->cointwo)
                            <tr>
                              <td>{{$trade->coinone}} / {{$trade->cointwo}}</td>
                              <td>{{number_format($price[$key],4)}}</td>
                              <td>{{$trade->coinone}} / {{$trade->cointwo}}</td>
                            </tr>
                          @endif
                        @empty
                          No Records Found 
                        @endforelse
                      </tbody>
                    </table>
                  </div>
                </div>
              @empty
                No Records Found 
              @endforelse
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection