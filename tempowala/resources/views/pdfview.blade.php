<!doctype html>
<html>

<head>
	<meta charset="utf-8">
	<title>Tempowala Invoice</title>
	@if(!app('request')->input('download'))
	<style>
		.invoice-box {
		        max-width: 800px;
		        margin: auto;
		        padding: 30px;
		        border: 1px solid #eee;
		        box-shadow: 0 0 10px rgba(0, 0, 0, .15);
		        font-size: 16px;
		        line-height: 24px;
		        font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
		        color: #555;
		    }
		    
		    .invoice-box table {
		        width: 100%;
		        line-height: inherit;
		        text-align: left;
		    }
		    
		    .invoice-box table td, th {
		        padding: 5px;
		        vertical-align: top;
		    }
		    
		    .invoice-box table tr td:nth-child(2) {
		        text-align: right;
		    }
		    
		    .invoice-box table tr.top table td {
		        padding-bottom: 20px;
		    }
		    
		    .invoice-box table tr.top table td.title {
		        font-size: 45px;
		        line-height: 45px;
		        color: #333;
		    }
		    
		    .invoice-box table tr.information table td {
		        padding-bottom: 40px;
		    }
		    
		    .invoice-box table tr.heading td,th {
		        
		        border-bottom: 1px solid #ddd;
		        font-weight: bold;
		    }
		    
		    .invoice-box table tr.heading th {
		        
		        border: 1px solid #ddd;
		        font-weight: bold;
		    }
		    
		    .invoice-box table tr.details td {
		        padding-bottom: 20px;
		    }
		    
		    .invoice-box table tr.item td{
		        border-bottom: 1px solid #eee;
		        width:50%;
		    }
		    
		    .invoice-box table tr.item th{
		        border-bottom: 1px solid #eee;
		        width:50%;
		    }
		    
		    .invoice-box table tr.item.last td {
		        border-bottom: none;
		    }
		    
		    .invoice-box table tr.total td:nth-child(2) {
		        border-top: 2px solid #eee;
		        font-weight: bold;
		    }
		    
		    @media only screen and (max-width: 600px) {
		        .invoice-box table tr.top table td {
		            width: 100%;
		            display: block;
		            text-align: center;
		        }
		        
		        .invoice-box table tr.information table td {
		            width: 100%;
		            display: block;
		            text-align: center;
		        }
		    }
		    
		    /** RTL **/
		    .rtl {
		        direction: rtl;
		        font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
		    }
		    
		    .rtl table {
		        text-align: right;
		    }
		    
		    .rtl table tr td:nth-child(2) {
		        text-align: left;
		    }
		        .invoice{
		            text-align: center;
		        }
	</style>
	@endIf
</head>
<body>
	<div class="invoice-box">
		<h2 class="invoice">Tempowala Invoice </h2>
		
		@if ($bookings)
		<table cellpadding="0" cellspacing="0">
			<tr class="top">
				<td colspan="2">
					<table>
						<tr>
							<td class="title">
								<img src="{{URL::asset('/images/logo.png')}}" style="max-width:120px;max-height:120px" alt="Logo">
							</td>
							    <td>{{ $bookings->username }}
								<br>{{ $bookings->useremail }}
								<br>Invoice #: {{ $bookings->bookingID }}
								<br>Created: {{ $bookings->created_at }}
								</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr class="information">
				<td colspan="2">
					<table>
						<tr>
							<td>Tempowala.com
								<br>sector:64,Noida
								<br>UttarPradesh
								<br>pin:201301.</td>
							    
						</tr>
					</table>
				</td>
			</tr>
			<tr class="item">
				<th>Invoice #:</th>
				<td>{{ $bookings->bookingID }}</td>
			</tr>
			<tr class="item">
				<th>Invoice Date:</th>
				<td>{{ $bookings->created_at }}</td>
			</tr>
			<tr class="item">
				<th>Customer Name: </th>
				<td>{{ $bookings->username }}</td>
			</tr>
			<tr class="item">
				<th>Customer Number: </th>
				<td>{{ $bookings->mobile }}</td>
			</tr>
			<tr class="item">
				<th>Pickup Address:</th>
				<td>{{ $bookings->origin }}</td>
			</tr>
			<tr class="item">
				<th>Drop Address:</th>
				<td>{{ $bookings->destination }}</td>
			</tr>
			
			<tr class="item">
				<th>Price:</th>
				<td>{{ $bookings->price }}</td>
			</tr>
			<tr class="item">
				<th>GST:</th>
				<td>{{ $bookings->gst }}%</td>
			</tr>
			<tr class="item">
				<th>Coupon Code:</th>
				<td>{{ $bookings->coupon_code }}</td>
			</tr>
			<tr class="item">
				<th>Coupon Discount:</th>
				<td>{{ $bookings->coupon_discount }}</td>
			</tr>
			<tr class="item">
				<th>Total Price</th>
				<td>{{ $bookings->price_with_gst }}</td>
			</tr>
			
			
			
		</table>
		@endIf
		<div style="text-align:center;font-size:11px"><i>Note: This is system generated invoice does not required seal and signature.</i></div>
	</div>
</body>
</html