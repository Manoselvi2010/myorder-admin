@extends('layouts.header')
@section('title', 'Admin Wallet')
@section('content') 
<section class="content">
    <header class="content__title">
        <h1>Admin Wallet</h1>
    </header>
    <div class="row quick-stats listview2">
        <div class="col-sm-6 col-md-6">
            <div class="quick-stats__item">
                <div class="quick-stats__info col-md-8">
                    <h2 class="h2">Btc</h2>
                    <div class="walletinfo">
                        <h4 class="h4">{{ $address['BTC']}}</h4> 
                        <h4 class="h4">Balance :{{ number_format($balance['BTC'],8,'.','') }}</h4> 
                        <h4 class="h4">Total Trade Fee : {{ number_format(adminCommissionIncome('BTC'),8,'.','') }}</h4> 
                        <h4 class="h4">Total Withdraw Fee : {{ number_format(adminWithdrawIncome('BTC'),8,'.','') }}</h4>
                    </div>
                </div>
                <div class="col-md-4 text-right">
                    <h1><i><img src="{{ url('images/BTC.png') }}" class="btcicon" /></i></h1>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-6">
            <div class="quick-stats__item">
                <div class="quick-stats__info col-md-8">
                    <h2 class="h2">Eth</h2>
                    <div class="walletinfo">
                        <h4 class="h4">{{ $address['ETH']}}</h4> 
                        <h4 class="h4">Balance : {{ number_format($balance['ETH'],8) }}</h4> 
                        <h4 class="h4">Total Trade Fee : {{ number_format(adminCommissionIncome('ETH'),8,'.','') }}</h4> 
                        <h4 class="h4">Total Withdraw Fee : {{ number_format(adminWithdrawIncome('ETH'),8,'.','') }}</h4>
                    </div>
                </div>
                <div class="col-md-4 text-right">
                    <h1><i><img src="{{ url('images/ETH.png') }}" class="btcicon" /></i></h1>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-6">
            <div class="quick-stats__item">
                <div class="quick-stats__info col-md-8">
                    <h2 class="h2">LTC</h2>
                    <div class="walletinfo">
                        <h4 class="h4">{{ $address['LTC']}}</h4> 
                        <h4 class="h4">Balance : {{ number_format($balance['LTC'],8) }}</h4> 
                        <h4 class="h4">Total Trade Fee : {{ number_format(adminCommissionIncome('LTC'),8,'.','') }}</h4> 
                        <h4 class="h4">Total Withdraw Fee : {{ number_format(adminWithdrawIncome('LTC'),8,'.','') }}</h4>
                    </div>
                </div>
                <div class="col-md-4 text-right">
                    <h1><i><img src="{{ url('images/LTC.png') }}" class="btcicon" /></i></h1>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-6">
            <div class="quick-stats__item">
                <div class="quick-stats__info col-md-8">
                    <h2 class="h2">XRP</h2>
                    <div class="walletinfo">
                        <h4 class="h4">{{ $address['XRP']}}</h4> 
                        <h4 class="h4">Balance : {{ number_format($balance['XRP'],8) }}</h4> 
                        <h4 class="h4">Total Trade Fee : {{ number_format(adminCommissionIncome('XRP'),8,'.','') }}</h4> 
                        <h4 class="h4">Total Withdraw Fee : {{ number_format(adminWithdrawIncome('XRP'),8,'.','') }}</h4>
                    </div>
                </div>
                <div class="col-md-4 text-right">
                    <h1><i><img src="{{ url('images/XRP.png') }}" class="btcicon" /></i></h1>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-6">
            <div class="quick-stats__item">
                <div class="quick-stats__info col-md-8">
                    <h2 class="h2">USDT</h2>
                    <div class="walletinfo">
                        <h4 class="h4">{{ $address['USDT']}}</h4> 
                        <h4 class="h4">Balance : {{ number_format($balance['USDT'],8) }}</h4> 
                        <h4 class="h4">Total Trade Fee : {{ number_format(adminCommissionIncome('USDT'),8,'.','') }}</h4> 
                        <h4 class="h4">Total Withdraw Fee : {{ number_format(adminWithdrawIncome('USDT'),8,'.','') }}</h4>
                    </div>
                </div>
                <div class="col-md-4 text-right">
                    <h1><i><img src="{{ url('images/USDT.png') }}" class="btcicon" /></i></h1>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection