<!-- Services Start -->
<div class="container-fluid bg-light service py-5">
    <div class="container py-5">
        <div class="mx-auto text-center mb-5" style="max-width: 900px;">
            <h5 class="section-title px-3">{{ $services->title}}</h5>
            <h1 class="mb-0">{{ $services->description}}</h1>
        </div>
        <div class="row g-4">
            <!-- Columna de elementos pares -->
            <div class="col-lg-6 col-md-6 col-12">
                <div class="row g-4">
                    @php $index = 0; @endphp
                    @foreach($services_items as $item)
                        @if($index % 2 == 0)
                            <div class="col-12">
                                <div class="service-content-inner d-flex align-items-center bg-white border border-primary rounded p-4 pe-0">
                                    <div class="service-content text-end">
                                        <h5 class="mb-4">{{ $item->title ?? ' ' }}</h5>
                                        <p class="mb-0">{{ $item->description ?? ' ' }}</p>
                                    </div>
                                    <div class="service-icon p-4">
                                        <i class="fa {{ $item->icon ?? '' }} fa-4x text-primary"></i>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @php $index++; @endphp
                    @endforeach
                </div>
            </div>

            <!-- Columna de elementos impares -->
            <div class="col-lg-6 col-md-6 col-12">
                <div class="row g-4">
                    @php $index = 0; @endphp
                    @foreach($services_items as $item)
                        @if($index % 2 != 0)
                            <div class="col-12">
                                <div class="service-content-inner d-flex align-items-center bg-white border border-primary rounded p-4 pe-0">
                                    <div class="service-content text-end">
                                        <h5 class="mb-4">{{ $item->title ?? ' ' }}</h5>
                                        <p class="mb-0">{{ $item->description ?? ' ' }}</p>
                                    </div>
                                    <div class="service-icon p-4">
                                        <i class="fa {{ $item->icon ?? '' }} fa-4x text-primary"></i>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @php $index++; @endphp
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="text-center">
                <a class="btn btn-primary rounded-pill py-3 px-5 mt-2" target="_blank" href="{{ asset('files/SERVICIOS_PROFESIONALES_MMS.pdf') }}">{{ $services->boton_text}}</a>
            </div>
        </div>
    </div>
</div>
<!-- Services End -->