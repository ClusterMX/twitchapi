@extends('master')

@section('content')


    <div class="card mb-5 mb-xxl-8">
        <div class="card-body pt-9 pb-0">
            <!--begin::Details-->
            <div class="d-flex flex-wrap flex-sm-nowrap mb-3">
                <!--begin: Pic-->
                <div class="me-7 mb-4">
                    <div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative">
                        <img src="{{ Auth::user()->avatar }}" alt="image" />
                    </div>
                </div>
                <!--end::Pic-->
                <!--begin::Info-->
                <div class="flex-grow-1">
                    <!--begin::Title-->
                    <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                        <!--begin::User-->
                        <div class="d-flex flex-column">
                            <!--begin::Name-->
                            <div class="d-flex align-items-center mb-2">
                                <a href="#" class="text-gray-900 text-hover-primary fs-2 fw-bolder me-1">{{ Auth::user()->name }}</a>
                            </div>
                            <!--end::Name-->
                            <!--begin::Info-->
                            <div class="d-flex flex-wrap fw-bold fs-6 mb-4 pe-2">
                                <a href="#" class="d-flex align-items-center text-gray-400 text-hover-primary mb-2">
                                    <!--begin::Svg Icon | path: icons/duotune/communication/com011.svg-->
                                    <span class="svg-icon svg-icon-4 me-1">
                                        <i class="far fa-envelope fs-5"></i>
                                    </span>
                                    <!--end::Svg Icon-->{{ Auth::user()->email }}
                                </a>
                            </div>
                            <!--end::Info-->
                        </div>
                        <!--end::User-->
                        <!--begin::Actions-->
                        <div class="d-flex my-4">

                            <a href="https://twitch.tv/{{ Auth::user()->name }}" target="_blank" class="btn btn-sm btn-primary me-3">Ver canal</a>
                        </div>
                        <!--end::Actions-->
                    </div>
                    <!--end::Title-->
                    <!--begin::Stats-->
                    <div class="d-flex flex-wrap flex-stack">
                        <!--begin::Wrapper-->
                        <div class="d-flex flex-column flex-grow-1 pe-8">
                            <!--begin::Stats-->
                            <div class="d-flex flex-wrap">
                                <!--begin::Stat-->
                                <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                    <!--begin::Number-->
                                    <div class="d-flex align-items-center">
                                        <div class="fs-2 fw-bolder" data-kt-countup="true" data-kt-countup-value="{{ $followers }}"
                                            data-kt-countup-prefix="">0</div>
                                    </div>
                                    <!--end::Number-->
                                    <!--begin::Label-->
                                    <div class="fw-bold fs-6 text-gray-400">Followers</div>
                                    <!--end::Label-->
                                </div>
                                <!--end::Stat-->
                                <!--begin::Stat-->
                                <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                    <!--begin::Number-->
                                    <div class="d-flex align-items-center">
                                        <div class="fs-2 fw-bolder" data-kt-countup="true" data-kt-countup-value="{{ $subs }}">0
                                        </div>
                                    </div>
                                    <!--end::Number-->
                                    <!--begin::Label-->
                                    <div class="fw-bold fs-6 text-gray-400">Subs</div>
                                    <!--end::Label-->
                                </div>
                                <!--end::Stat-->
                                <!--begin::Stat-->
                                <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                    <!--begin::Number-->
                                    <div class="d-flex align-items-center">
                                        <div class="fs-2 fw-bolder" data-kt-countup="true" data-kt-countup-value="{{ $viewcount }}"
                                            data-kt-countup-prefix="">0</div>
                                    </div>
                                    <!--end::Number-->
                                    <!--begin::Label-->
                                    <div class="fw-bold fs-6 text-gray-400">Views</div>
                                    <!--end::Label-->
                                </div>
                                <!--end::Stat-->
                            </div>
                            <!--end::Stats-->
                        </div>
                        <!--end::Wrapper-->
                        <!--begin::Progress-->
                        {{-- <div class="d-flex align-items-center w-200px w-sm-300px flex-column mt-3">
                            <div class="d-flex justify-content-between w-100 mt-auto mb-2">
                                <span class="fw-bold fs-6 text-gray-400">Profile Compleation</span>
                                <span class="fw-bolder fs-6">50%</span>
                            </div>
                            <div class="h-5px mx-3 w-100 bg-light mb-3">
                                <div class="bg-success rounded h-5px" role="progressbar" style="width: 50%;"
                                    aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div> --}}
                        <!--end::Progress-->
                    </div>
                    <!--end::Stats-->
                </div>
                <!--end::Info-->
            </div>
            <!--end::Details-->
        </div>
    </div>
    <div class="row g-5 g-xl-8">

        <div class="col-xl-6">
            <div class="card mb-5 mb-xxl-8">
                <!--begin::Header-->
                <div class="card-header align-items-center border-0 mt-4">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="fw-bolder mb-2 text-dark">Lista de eventos</span>
                    </h3>

                </div>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body pt-5">
                    <!--begin::Timeline-->
                    @if ($events->count() == 0)
                    <div class="d-flex flex-row-fluid flex-wrap align-items-center">
                        <div class="flex-grow-1 me-2">
                            <span class="text-muted fw-bold d-block pt-1">Aun no tenemos datos que mostrarte, prende stream y vuelve para volver a revisar :)</span>
                        </div>
                        {{-- <span class="badge badge-light-success fs-8 fw-bolder my-2">Approved</span> --}}
                    </div>
                    @else


                    <div class="timeline-label">
                        @forelse ($events as $item)
                        <!--begin::Item-->
                        <div class="timeline-item">
                            @if ($item->type == 'channel.follow')

                            <div class="timeline-label fw-bolder text-gray-800 fs-8">Follow</div>
                            <div class="timeline-badge">
                                <i class="fa fa-genderless text-success fs-1"></i>
                            </div>
                            <div class="fw-mormal timeline-content ps-3">
                                <a href="https://twitch.tv/{{ $item->user_name }}" target="_blank">{{ $item->user_name }}</a> te ha seguido
                            </div>

                            @elseif ($item->type == 'channel.subscribe')
                            <div class="timeline-label fw-bolder text-gray-800 fs-8">Sub</div>
                            <div class="timeline-badge">
                                <i class="fa fa-genderless text-primary fs-1"></i>
                            </div>
                            <div class="fw-mormal timeline-content ps-3">
                                <a href="https://twitch.tv/{{ $item->user_name }}" target="_blank">{{ $item->user_name }}</a> se ha suscrito a tu canal
                            </div>
                            @elseif ($item->type == 'channel.subscription.gift')
                            <div class="timeline-label fw-bolder text-gray-800 fs-8">Gift</div>
                            <div class="timeline-badge">
                                <i class="fa fa-genderless text-danger fs-1"></i>
                            </div>
                            <div class="fw-mormal timeline-content ps-3">
                                <a href="https://twitch.tv/{{ $item->user_name }}" target="_blank">{{ $item->user_name }}</a> ha regalado {{ $item->total }} subs, lleva un total de {{ $item->cumulative_total }} subs regaladas
                            </div>
                            @elseif ($item->type == 'channel.subscription.message')
                            <div class="timeline-label fw-bolder text-gray-800 fs-8">Resub</div>
                            <div class="timeline-badge">
                                <i class="fa fa-genderless text-primary fs-1"></i>
                            </div>
                            <div class="fw-mormal timeline-content ps-3">
                                <a href="https://twitch.tv/{{ $item->user_name }}" target="_blank">{{ $item->user_name }}</a> se ha resuscrito
                            </div>
                            @elseif ($item->type == 'channel.cheer')
                            <div class="timeline-label fw-bolder text-gray-800 fs-8">Cheer</div>
                            <div class="timeline-badge">
                                <i class="fa fa-genderless text-white fs-1"></i>
                            </div>
                            <div class="fw-mormal timeline-content ps-3">
                                <a href="https://twitch.tv/{{ $item->user_name }}" target="_blank">{{ $item->user_name }}</a> ha dado {{ $item->bits }} bits: "<i class="text-white-50">{{ $item->message }}</i>"
                            </div>
                            @elseif ($item->type == 'channel.raid')
                            <div class="timeline-label fw-bolder text-gray-800 fs-8">Raid</div>
                            <div class="timeline-badge">
                                <i class="fa fa-genderless text-warning fs-1"></i>
                            </div>
                            <div class="fw-mormal timeline-content ps-3">
                                <a href="https://twitch.tv/{{ $item->user_name }}" target="_blank">{{ $item->user_name }}</a> ha hecho una raid de {{ $item->viewers }} personas
                            </div>

                            @endif



                        </div>
                        <!--end::Item-->

                        @empty

                        @endforelse

                    </div>

                    @endif

                    <!--end::Timeline-->
                </div>
                <!--end: Card Body-->
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card mb-5 mb-xxl-8">
                <!--begin::Header-->
                <div class="card-header align-items-center border-0 mt-4">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="fw-bolder text-dark">Videos</span>
                        <span class="text-muted mt-1 fw-bold fs-7">Ultimos streams</span>
                    </h3>
                </div>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body pt-3">
                    <!--begin::Item-->
                    @forelse ($videos as $video)
                    <div class="d-flex align-items-sm-center mb-7">
                        <!--begin::Symbol-->
                        <div class="symbol symbol-60px symbol-2by3 me-4">
                            <div class="symbol-label"
                                style="background-image: url('{{ str_replace($search, $replace, $video->thumbnail_url) }}')">
                            </div>
                        </div>
                        <!--end::Symbol-->
                        <!--begin::Title-->
                        <div class="d-flex flex-row-fluid flex-wrap align-items-center">
                            <div class="flex-grow-1 me-2">
                                <a href="{{ $video->url }}" class="text-gray-800 fw-bolder text-hover-primary fs-6">{{ $video->title }}</a>
                                <span class="text-muted fw-bold d-block pt-1">{{ $video->duration }}</span>
                            </div>
                            {{-- <span class="badge badge-light-success fs-8 fw-bolder my-2">Approved</span> --}}
                        </div>
                        <!--end::Title-->
                    </div>

                    @empty
                    <div class="d-flex align-items-sm-center mb-7">
                        <!--begin::Title-->
                        <div class="d-flex flex-row-fluid flex-wrap align-items-center">
                            <div class="flex-grow-1 me-2">
                                <span class="text-muted fw-bold d-block pt-1">Al parecer no has hecho stream en un largo tiempo :(</span>
                            </div>
                            {{-- <span class="badge badge-light-success fs-8 fw-bolder my-2">Approved</span> --}}
                        </div>
                        <!--end::Title-->
                    </div>
                    @endforelse

                    <!--end::Item-->
                </div>
                <!--end::Body-->
            </div>
        </div>
    </div>

@endsection
