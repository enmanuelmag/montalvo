<!-- Testimonial Start -->
<div class="container-fluid testimonial py-5">
    <div class="container py-5">
        <div class="mx-auto text-center mb-5" style="max-width: 900px;">
            <h5 class="section-title px-3">{{ $seccionTestimonios->titulo }}</h5>
            <h1 class="mb-0">{{ $seccionTestimonios->subtitulo }}</h1>
        </div>
        <div class="testimonial-carousel owl-carousel">
            @foreach($testimonios as $item)
            <div class="testimonial-item text-center rounded pb-4">
                <div class="testimonial-comment bg-light rounded p-4">
                    <p class="text-center mb-5">
                       {{ $item->detalle }}
                    </p>
                </div>
                <div class="testimonial-img p-1">
                    <img src="{{ asset($item->imagen) }}" class="img-fluid rounded-circle" width="100%"
                            height="100%" alt="Image">
                </div>
                <div style="margin-top: -35px;">
                    <h5 class="mb-0">{{ $item->nombre }}</h5>
                    <p class="mb-0">{{ $item->cargo }}</p>
                    <p class="mb-0">{{ $item->empresa }}</p>

                    <div class="d-flex justify-content-center">
                        @for($i = 0; $i < $item->calificacion; $i++)
                            <i class="fas fa-star text-primary"></i>
                        @endfor

                    </div>
                </div>
            </div>
            @endforeach

        </div>
    </div>
</div>
<!-- Testimonial End -->

