@extends('layouts.app')
@section('content') 
@if(Session::has('success'))           
        <div class="alert alert-success" role="alert">
            {{ Session::get('success')}}
        </div>       
@endif 
    
<script> 
 
 var total=0;
    function Cal() {
        var prices = document.getElementsByName('price[]');
        var cboxes = document.getElementsByName('item[]');    
        var totalP=0;
        
        for (var i=0; i<cboxes.length; i++) {        
            if(cboxes[i].checked){		
                totalP+=parseFloat(prices[i].value);
            }else if (cboxes[i].checked=false){
				totalP-=parseFloat(prices[i].value);
			}
        }
        document.getElementById('amount').value=totalP.toFixed(2);
    }

    
    </script>
    

<div class="container">
	    <div class="row">
        <form   method="post" action="{{ route('create.order') }}" >
            @csrf
		    <table class="table table-hover table-striped">
		        <thead>
		        <tr class="thead-dark">
		            <th>ID</th>
                    <th>Image</th>
		            <th>Name</th>
		            <th>Quantity</th>
		            <th>Amount</th>
                    <th>Action</th>
		        </tr>
		    </thead>
		        <tbody>	
                @foreach($carts as $cart)
		            <tr>
		                <td><input type="checkbox" name="item[]"value="{{$cart->cid}}" onchange="Cal()"  /></td>
                        <td><img src="{{ asset('images/') }}/{{$cart->image}}" alt="" width="50"></td>
		                <td style="max-width:300px">
		                    <h6>{{$cart->name}}</h6>	                    
		                </td>
                        <td>{{$cart->cartQty}}</td>
                        @php
                        $subtotal=$cart->price*$cart->cartQty;
                        @endphp
                        <td>{{$subtotal}} </td>
                        <input type="hidden" value="{{$subtotal}}" name="price[]" id="price[]"/>
		                <td>
		                    | 
                            <a href="{{ route('deleteCart', ['id' => $cart->cid]) }}" 
 class="btn btn-danger" onclick="return confirm('Sure Want Delete?')">Delete</a>
		                </td>
		            </tr> 
                @endforeach

                <tr class="thead-dark">
		            <td>&nbsp;</td>
                    <td>&nbsp;</td>
		            <td>&nbsp;</td>                   
		            <td>Total</td>
		            <td><input type="text" name="amount" id="amount" value=""></td>
                <td><input type="submit" name="checkout" value="Checkout"></td>
		        </tr>
				</form>
		        </tbody>
		    </table>
		
		<div class="text-center">
			{{ $carts->links() }}
        </div>

	</div>
    </div>

@endsection