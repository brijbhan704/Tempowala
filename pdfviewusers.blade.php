<style type="text/css">
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
		        .text{
		        	text-align: left !important;
		        }
	</style>
</style>
<div class="invoice-box">
		<h2 class="invoice">ER-PORTAL </h2>

				<table cellpadding="0" cellspacing="0">
						<tr>
						
                                    <th scope="col">{{ __('Sr No') }}</th>
                                    <th scope="col">{{ __('Name') }}</th>
                                     <th scope="col">{{ __('Email') }}</th>
                                     <th scope="col">{{ __('Phone') }}</th>                             
                                   	<th scope="col">{{ __('Roles') }}</th>
                                   	<th scope="col">{{ __('Creation Date') }}</th>                             
                                   
                               
                            </tr>
        
		@foreach ($items as $key => $item)
		<tr>
			<td>{{ ++$key }}</td>
			<td class="text">{{ $item->name }}</td>
			<td>{{ $item->email }}</td>
			<td>{{ $item->phone }}</td>
			<td>
			@if(!empty($item->getRoleNames()))
            @foreach($item->getRoleNames() as $v)
                <label class="badge badge-success">{{ $v }}</label>
            @endforeach
        		@endif
                   </td>
			<td>{{ $item->created_at }}</td>
		</tr>
		@endforeach
	
	</table>
	<div style="text-align:center;font-size:11px"><i>Note: This is system generated invoice does not required seal and signature.</i></div>
	</div

				