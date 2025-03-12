<x-mail::message>
# Hi {{ $user->name }}

You have been requested to approve data that has been generated today. Kindly log into your account and approve.
{{-- <x-mail::button :url="''">
Button Text
</x-mail::button> --}}

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
