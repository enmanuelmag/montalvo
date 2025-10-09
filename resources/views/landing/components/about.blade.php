<!-- About Start -->
<div class="container-fluid about py-5">
    <div class="container py-5">
        <div class="row g-5 align-items-center">
            <div class="col-lg-5">
                <div class="h-100" style="border: 50px solid; border-color: transparent #13357B transparent #13357B;">
                    <img src="{{ asset($about->imagen ?? '') }}" class="img-fluid w-100 h-100" alt="">
                </div>
            </div>
            <div class="col-lg-7" style="background: linear-gradient(rgba(255, 255, 255, .8), rgba(255, 255, 255, .8)),
            url({{ asset('files/img/about_fondo.jpg') }});">
                <h5 class="section-about-title pe-3">{{ $about->titulo ?? '' }}</h5>
                <h1 class="mb-4"><span class="text-primary">{{ $about->descripcion1 ?? '' }}</span></h1>
                <p class="mb-4">{{ $about->parrafo1 ?? '' }}</p>
                <p class="mb-4">{{ $about->parrafo2 ?? '' }}</p>
                <div class="row gy-2 gx-4 mb-4">
                    @foreach($aboutItems as $item)
                        <div class="col-sm-6">
                            <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>{{ $item->titulo ?? '' }}</p>
                        </div>
                    @endforeach
                </div>
                <a class="btn btn-primary rounded-pill py-3 px-5 mt-2" target="_blank" href="{{ asset('files/SERVICIOS_PROFESIONALES_MMS.pdf') }}">{{ $about->btn_text ?? '' }}</a>
            </div>
        </div>
    </div>
</div>
<!-- About End -->
