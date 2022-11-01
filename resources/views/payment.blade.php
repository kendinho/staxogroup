@extends('layouts.app')

@section('content')
<div class="container">
    <form action="{{route('process-payment', [$product, $price])}}" method="POST" id="subscribe-form">
        <div class="form-group">
            <div class="row">
                <div class="col-md-4">
                    <div class="subscription-option">
                        <label for="plan-silver">
                            <span class="plan-price">Product / Item: {{strtoupper($product)}} &nbsp; | &nbsp; Price: {{env('CURRENCY') . number_format($price,2)}}</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <label for="card-holder-name">Card Holder Name</label><br>
        <input id="card-holder-name" type="text" value="{{$buyer->name}}" disabled>
        <input type="hidden" name="buyer_id" value="{{$buyer->id}}">
        <br><br>
        @csrf
        <div class="form-group col-6">
            <label for="card-element">Credit or Debit card</label>
            <div id="card-element" class="form-control "> </div>
            <!-- Used to display form errors. -->
            <div id="card-errors" role="alert"></div>
        </div>
        <div class="stripe-errors"></div>
        @if (count($errors) > 0)
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
            {{ $error }}<br>
            @endforeach
        </div>
        @endif
        <br>
        <div class="form-group text-left col-6">
            <button type="button" id="card-button" data-secret="{{ $intent->client_secret }}" class="btn btn-success btn-block">SUBMIT</button>
        </div>
    </form>
</div>
<script src="https://js.stripe.com/v3/"></script>
<script>
    const stripe = Stripe("{{ env('STRIPE_KEY') }}");
    const elements = stripe.elements();
    const style = {
        base: {
            color: '#32325d',
            fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
            fontSmoothing: 'antialiased',
            fontSize: '16px',
            '::placeholder': {
                color: '#aab7c4'
            }
        },
        invalid: {
            color: '#fa755a',
            iconColor: '#fa755a'
        }
    };
    const card = elements.create('card', {
        hidePostalCode: true,
        style: style
    });
    card.mount('#card-element');

    card.addEventListener('change', function(event) {
        const displayError = document.getElementById('card-errors');
        if (event.error) {
            displayError.textContent = event.error.message;
        } else {
            displayError.textContent = '';
        }
    });
    const cardHolderName = document.getElementById('card-holder-name');
    const cardButton = document.getElementById('card-button');
    const clientSecret = cardButton.dataset.secret;
    cardButton.addEventListener('click', async (e) => {

        const {
            setupIntent,
            error
        } = await stripe.confirmCardSetup(
            clientSecret, {
                payment_method: {
                    card: card,
                    billing_details: {
                        name: cardHolderName.value
                    }
                }
            }
        );
        if (error) {
            const errorElement = document.getElementById('card-errors');
            errorElement.textContent = error.message;
        } else {
            paymentMethodHandler(setupIntent.payment_method);
        }
    });

    function paymentMethodHandler(payment_method) {
        const form = document.getElementById('subscribe-form');
        const hiddenInput = document.createElement('input');
        hiddenInput.setAttribute('type', 'hidden');
        hiddenInput.setAttribute('name', 'payment_method');
        hiddenInput.setAttribute('value', payment_method);
        form.appendChild(hiddenInput);
        form.submit();
    }
</script>


@endsection