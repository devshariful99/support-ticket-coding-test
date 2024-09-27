@extends('user.layouts.master', ['page_slug' => 'ticket-details'])
@push('css')
    <link rel="stylesheet" href="{{ asset('custom_litebox/litebox.css') }}">
@endpush
@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center gap-2">
                        <h4 class="cart-title fw-bold">{{ __($ticket->title." - ($ticket->ticket_number)") }}</h4><sup><span class="{{$ticket->getStatusBadgeBg()}}">{{ $ticket->getStatusBadgeTitle() }}</span></sup>
                    </div>
                    @include('user.includes.button', [
                            'routeName' => 'user.dashboard',
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
                                        href="{{ route('user.file.download', encrypt($file)) }}"><i
                                            class="fas fa-download"></i></a>
                                @endif
                            @endforeach
                        @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer" style="min-height: 50vh; max-height: 80vh; overflow-y: auto; background-color: transparent">
                    @if($ticket->status == 0)
                        <h4>{{__('Waiting for response...')}}</h4>
                    @else
                        @foreach ($ticket->messages as $message)
                            
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
    <script src="{{ asset('custom_litebox/litebox.js') }}"></script>
@endpush
