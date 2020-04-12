hola {{$user->name}}

Thanks for creating an account.  

Please verify it by clicking on the following link:

{{route('verify', $user->verification_token)}}