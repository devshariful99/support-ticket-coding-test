@extends('admin.layouts.master', ['page_slug' => 'ticket'])
@push('css')
    <link rel="stylesheet" href="{{ asset('custom_litebox/litebox.css') }}">

    <style>
        .message_wrap::-scrollbar-track {
        box-shadow: inset 0 0 6px rgba(0,0,0,0.9);
        border-radius: 10px;
        background-color: #00204B;
        }

        .message_wrap::-scrollbar {
        width: 6px;
        background-color: #F5F5F5;
        }

        .message_wrap::-scrollbar-thumb {
        border-radius: 10px;
        background-color: #28A349;
        background-image: linear-gradient(90deg,
                                        transparent,
                                        #28A349 50%,
                                        transparent,
                                        transparent);
        }

        .message_wrap::-webkit-scrollbar-track
        {
            -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.9);
            border-radius: 10px;
            background-color: #00204B;
        }

        .message_wrap::-webkit-scrollbar
        {
            width: 6px;
            background-color: #F5F5F5;
        }

        .message_wrap::-webkit-scrollbar-thumb
        {
            border-radius: 10px;
            background-color: #28A349;
            background-image: -webkit-linear-gradient(90deg,
                                                    transparent,
                                                    #28A349 50%,
                                                    transparent,
                                                    transparent)
        }
    </style>
@endpush
@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center gap-2">
                        <h4 class="cart-title fw-bold">{{ __($ticket->title." - ($ticket->ticket_number)") }}</h4><sup class="ticket_status"><span class="{{$ticket->getStatusBadgeBg}}">{{ $ticket->getStatusBadgeTitle }}</span></sup>
                    </div>
                    @include('user.includes.button', [
                            'routeName' => 'ticket.index',
                            'label' => 'Back',
                        ])
                </div>
                <div class="card-body bg-secondary">
                    <div class="row">
                        <div class="col-12">
                            <div class="description">
                                <p class="text-white fs-5" style="text-align: justify">{!! $ticket->description !!}</p>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="files d-flex align-items-center gap-2">
                                @if($ticket->files)
                            @foreach (json_decode($ticket->files) as $file)
                                @if (isImage($file))
                                    <div class="imagePreviewDiv d-inline-block">
                                        <div id="lightbox" class="lightbox">
                                            <div class="lightbox-content">
                                                <img src="{{ storage_url($file) }}"
                                                    class="lightbox_image">
                                            </div>
                                            <div class="close_button fa-beat">X</div>
                                        </div>
                                    </div>
                                @else
                                    <a class="btn btn-info btn-sm"
                                        href="{{ route('admin.file.download', encrypt($file)) }}"><i
                                            class="fas fa-download"></i></a>
                                @endif
                            @endforeach
                        @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer" style="background-color: transparent">
                    <div class="message_wrap" style="min-height: 30vh; max-height: 50vh; overflow-y: auto; overflow-x: hidden">
                       
                            <div class="row message_row" >
                                @if($ticket->status == 0)
                                    <h4 class='empty_message'>{{__('Waiting for response...')}}</h4>
                                @else
                                    @foreach ($ticket->messages as $message)
                                        <div class="col-12 mb-2">
                                            <div class="message d-flex gap-3 max-w-50 align-items-center {{$message->author == 'Admin' ? 'float-end' : 'float-start'}}" >
                                                @if($message->author == 'User')
                                                    <img style="height: 40px; width: 40px; object-fit: cover; object-position: center; border: 1px solid #28A349" src="{{ $message->author_image }}" class="rounded-circle p-1" alt="">
                                                @endif
                                                <p class="text-white fs-6 p-2 m-0 rounded {{$message->author == 'User' ? 'bg-info' : 'bg-primary'}}" style="text-align: justify">{!! $message->message !!}</p>
                                                @if($message->author == 'Admin')
                                                    <img style="height: 40px; width: 40px; object-fit: cover; object-position: center; border: 1px solid #28A349" src="{{ $message->author_image }}" class="rounded-circle p-1" alt="">
                                                @endif
                                            </div>
                                        </div> 
                                    @endforeach
                                @endif
                            </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-12">
                            @if($ticket->status == 2)
                                <h4 class="cart-title text-center text-danger" >{{__('Ticket Closed')}}</h4>
                            @else
                                <form id="ticketMessageForm" action="{{ route('message.send') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">
                                    <div class="form-group">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <label for="message">{{__('Message')}}</label>
                                            <div class="ticket_close_button">
                                                @if($ticket->status == 1)
                                                    <a href="{{ route('ticket.close', encrypt($ticket->id)) }}" class="btn btn-danger"> {{__('Ticket Close')}}</a>
                                                @endif
                                            </div>
                                        </div>
                                        
                                        <textarea name="message" id="message_text" class="form-control" rows="5"></textarea> 
                                    </div>
                                    <div class="form-group float-end">
                                        <input type="submit" class="btn btn-primary" value="Send">
                                    </div>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('js')
    <script src="{{ asset('custom_litebox/litebox.js') }}"></script>

    <script>
        function scrollToBottom() {
            const messageContainer = $('.message_wrap');
            messageContainer.scrollTop(messageContainer[0].scrollHeight);
        }
        $(document).ready(function() {
            scrollToBottom();
            $('#ticketMessageForm').on('submit', function(e) {
                
                e.preventDefault(); // Prevent default form submission
                
                let formData = new FormData(this); // Create a FormData object to handle file uploads
                let url = $(this).attr('action');
                
                $.ajax({
                    url: url, // Form action URL
                    type: 'POST',
                    data: formData,
                    contentType: false, // Important for file upload
                    processData: false, // Prevent jQuery from processing the data
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // CSRF token
                    },
                    success: function(response) {
                        if (response.success) {
                            let result = `
                                <div class="col-12 mb-2">
                                        <div class="message d-flex gap-3 max-w-50 align-items-center ${response.data.author == 'Admin' ? 'float-end' : 'float-start'}" >`;
                            if(response.data.author == 'User'){
                                result+=`<img style="height: 40px; width: 40px; object-fit: cover; object-position: center; border: 1px solid #28A349" src="${response.data.author_image}" class="rounded-circle p-1" alt="">`;
                            }
                            result+=`<p class="text-white fs-6 p-2 m-0 rounded ${response.data.author == 'User' ? 'bg-info' : 'bg-primary'}" style="text-align: justify">${response.data.message}</p>`;
                            if(response.data.author == 'Admin') {
                                result+=`<img style="height: 40px; width: 40px; object-fit: cover; object-position: center; border: 1px solid #28A349" src="${response.data.author_image}" class="rounded-circle p-1" alt="">`;
                            }
                            result+=`</div>
                                </div> 
                            `;
                            $('.message_row').append(result);
                            $('.empty_message').hide();
                            $('#message_text').val('');
                            $('.ticket_status').html(`<span class="${response.data.ticket.getStatusBadgeBg}">${response.data.ticket.getStatusBadgeTitle }</span>`);
                            $('.ticket_close_button').html(`<a href="{{ route('ticket.close', encrypt($ticket->id)) }}" class="btn btn-danger"> {{__('Ticket Close')}}</a>`);
                            scrollToBottom();
                        }else{
                            handleErrors(response);
                        }
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText); // Log the error message
                        alert('An error occurred. Please try again.');
                    }
                });
            });
        });
    </script>
@endpush
