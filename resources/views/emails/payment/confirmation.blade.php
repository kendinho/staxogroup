@component('mail::message')

# Dear {{ucwords($buyer->name)}}

This is a confirmation that your payment has been received as follows:



@component('mail::table')
| Product | Price | Status |
| :------------- |:-------------:| --------:|
| {{$product}} | {!! config('app.currency') . number_format($price,2) !!} | Paid |

@endcomponent

@component('mail::button', ['url' => 'http://127.0.0.1:8000'])
Visit Us Again
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent