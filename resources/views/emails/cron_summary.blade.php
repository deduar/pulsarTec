Date Between <br>
Begin : {{$begin}} <br>
End   : {{$end}} <br>
<br>
Users list : <br>
@foreach ($data as $user)
    User: {{ $user->name }} , Created: {{ $user->created_at }}, EndDate: {{ Carbon\Carbon::parse($user->created_at)->addDay(30)->format('Y-m-d h:s') }}<br>
@endforeach