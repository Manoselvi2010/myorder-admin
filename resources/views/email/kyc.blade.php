@include('email.header')
	<tr><td align='left'>&nbsp;</td><td style='text-align:center;font-size:20px;color:#515151;font-weight:600;'>Welcome to {{ env('APP_NAME') }}</td><td align='left'>&nbsp;</td></tr>
	<tr><td colspan='3' align='center' height='1' style='padding:0px;'></td></tr>
	<tr><td align='left' style='padding-top:0px;'>&nbsp;</td><td style='text-align:left;font-size:15px;color:#000;padding-top:0px;'>Dear {{ $details['user'] }},</td><td align='left' style='padding-top:0px;'>&nbsp;</td></tr>
	<tr><td colspan='3' align='center' height='1' style='padding:0px;'></td></tr>
	@if($details['status'] == '1')
		<tr><td align='left' style='padding-top:0px;'>&nbsp;</td><td style='text-align:left;font-size:15px;color:#000;padding-top:0px;'>Your KYC Registration process completed successfully. Please Login and continue to trade</td><td align='left' style='padding-top:0px;'>&nbsp;</td></tr>
	@else
		<tr><td align='left' style='padding-top:0px;'>&nbsp;</td><td style='text-align:left;font-size:15px;color:#000;padding-top:0px;'>Your Account has removed by admin </td><td align='left' style='padding-top:0px;'>&nbsp;</td></tr>
	@endif
	<tr><td colspan='3' align='center' height='30' style='padding:0px;'></td></tr> 

@include('email.footer')