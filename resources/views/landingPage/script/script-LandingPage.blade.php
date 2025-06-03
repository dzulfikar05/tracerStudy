<script>
    $(() => {
        onFetchImage();
        onContentHome();
    })

    onFetchImage = () => {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{ route('get-carousel') }}",
            method: 'post',
            processData: false,
            contentType: false,
            success: function(data) {
                var html = "";
                console.log(data);
                for (let i = 0; i < data.length; i++) {
                    let url = "{{ asset('storage/content/') }}/" + data[i].image;
                    html += `
                        <div class="item">
                            <img src="${url}" alt="${data[i].title}"/>
                        </div>
                    `;
                }

                $('.list-image-carousel').html(html);
                initSlider();
            },

        });
    }

    onContentHome = () => {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{ route('get-content-home') }}",
            method: 'post',
            processData: false,
            contentType: false,
            success: function(data) {
                var html = "";

                for (let i = 0; i < data.length; i++) {
                    let url = "{{ asset('storage/content/') }}/" + data[i].image;

                    // Cek apakah indeks genap atau ganjil
                    if (i % 2 === 0) {
                        // Gambar di kanan
                        html += `
                        <section class="about-section" id="about">
                            <div class="container" data-aos="zoom-in-up" data-aos-delay="50" data-aos-duration="1000">
                                <div class="row align-items-center">
                                    <div class="col-lg-6">
                                        <h2 class="section-title">${data[i].title}</h2>
                                        ${data[i].text}
                                    </div>
                                    <div class="col-lg-6">
                                    
                                        <img src="${url}" alt="${data[i].title}" class="illustration-img" style="object-fit: cover; width:100%; height:300px;">
                                    </div>
                                </div>
                            </div>
                        </section>
                    `;
                    } else {
                        // Gambar di kiri
                        html += `
                        <section class="about-section" id="about">
                            <div class="container" data-aos="zoom-in-up" data-aos-delay="50" data-aos-duration="1000">
                                <div class="row align-items-center flex-row-reverse">
                                    <div class="col-lg-6">
                                        <h2 class="section-title">${data[i].title}</h2>
                                        ${data[i].text}
                                    </div>
                                    <div class="col-lg-6">
                                        <img src="${url}" alt="${data[i].title}" class="illustration-img" style="object-fit: cover; width:100%; height:300px;">
                                    </div>
                                </div>
                            </div>
                        </section>
                    `;
                    }
                }

                $('.content-home').html(html);
            },

        });
    }
</script>

<script>
    function initSlider() {
        let slider = document.querySelector('.slider .list');
        let items = document.querySelectorAll('.slider .list .item');
        let next = document.getElementById('next');
        let prev = document.getElementById('prev');
        let dots = document.querySelectorAll('.slider .dots li');

        let lengthItems = items.length - 1;
        let active = 0;

        next.onclick = function() {
            active = active + 1 <= lengthItems ? active + 1 : 0;
            reloadSlider();
        }

        prev.onclick = function() {
            active = active - 1 >= 0 ? active - 1 : lengthItems;
            reloadSlider();
        }

        let refreshInterval = setInterval(() => {
            next.click()
        }, 3000);

        function reloadSlider() {
            slider.style.left = -items[active].offsetLeft + 'px';

            let last_active_dot = document.querySelector('.slider .dots li.active');
            if (last_active_dot) last_active_dot.classList.remove('active');
            if (dots[active]) dots[active].classList.add('active');

            clearInterval(refreshInterval);
            refreshInterval = setInterval(() => {
                next.click()
            }, 3000);
        }

        dots.forEach((li, key) => {
            li.addEventListener('click', () => {
                active = key;
                reloadSlider();
            });
        });

        window.onresize = function(event) {
            reloadSlider();
        };

        // Trigger initial load
        reloadSlider();
    }
</script>
