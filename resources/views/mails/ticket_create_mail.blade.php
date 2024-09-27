<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{__('Ticket Status Mail')}}</title>
</head>
<body>
    <p>Dear Admin,</p>

    <p>A new ticket has been created</p>
    <p>Ticket Number : {{$mailData['ticket_number']}}</p>
    <p>Title : {{$mailData['title']}}</p>
    <p>Description : {!! $mailData['description'] !!}</p>
    <p>Submitted By : {{ $mailData['author'] }}</p>
    <p><a href="{{ $mailData['url'] }}">Details</a></p>
</body>
</html>