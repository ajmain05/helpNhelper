<div class="relative pt-5 xl:pt-20 pb-5 xl:pb-20 px-2 mt-[93px] bg-cover bg-center bg-no-repeat bg-fixed"
    style="background-image: url('{{ asset('web-assets/v2-images/home/3rd stage under donation campaigns.webp') }}')">
    <div class="absolute inset-0 bg-black bg-opacity-60"></div>
    <div class="max-w-[1200px] mx-auto relative z-10">
        <h3
            class="text-white text-center text-[30px] xl:text-[52px] font-bold leading-[40px] xl:leading-[86px] tracking-[0] mb-5 xl:mb-11">
            {{ __('Frequently Asked Questions') }}
        </h3>

        <div class="flex flex-col gap-6">
            @foreach ($faqs as $faq)
                <div class="border-2 border-gray-300 mb-6 overflow-hidden faq-item rounded-[24px]">
                    <div
                        class="flex justify-between items-center p-6 font-semibold text-lg bg-[rgb(2_31_23/_0.7)] text-white faq-question cursor-pointer">
                        {{ $faq->title }}
                        <span class="transform transition-transform ease-in-out duration-300 faq-toggle">
                            <svg width="48.000000" height="48.000000" viewBox="0 0 48 48" fill="none"
                                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                <desc>
                                    Created with Pixso.
                                </desc>
                                <defs>
                                    <clipPath id="clip119_727">
                                        <rect id="COCO/Bold/Arrow - Left" rx="0.000000" width="24.533333"
                                            height="24.533333"
                                            transform="translate(11.733284 37.333138) rotate(-89.999992)" fill="white"
                                            fill-opacity="0" />
                                    </clipPath>
                                </defs>
                                <g clip-path="url(#clip119_727)">
                                    <path id="Vector"
                                        d="M18.1 20.76C18.41 20.45 18.91 20.45 19.23 20.76L23.99 25.53L28.76 20.76C29.08 20.45 29.58 20.45 29.89 20.76C30.21 21.07 30.21 21.58 29.89 21.89L24.56 27.23C24.41 27.38 24.21 27.46 23.99 27.46C23.78 27.46 23.58 27.38 23.43 27.23L18.1 21.89C17.78 21.58 17.78 21.07 18.1 20.76Z"
                                        fill="#FFFFFF" fill-opacity="1.000000" fill-rule="evenodd" />
                                </g>
                                <rect id="Frame 67" rx="23.600000" width="47.200001" height="47.200001"
                                    transform="translate(0.400000 0.400000)" stroke="#FFFFFF" stroke-opacity="1.000000"
                                    stroke-width="0.800000" />
                            </svg>


                        </span>
                    </div>
                    <div
                        class="max-h-0 overflow-hidden transition-all duration-300 bg-[rgb(2_31_23/_0.7)] text-white faq-answer">
                        <p class="text-sm text-white p-6 faq-answer-wrapper">
                            {{ $faq->description }}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<script>
    document.querySelectorAll('.faq-question').forEach(question => {
        question.addEventListener('click', () => {
            const faqItem = question.parentElement;
            const faqItemAnswer = faqItem.querySelector(".faq-answer");
            if (faqItem.classList.contains('active')) {
                faqItemAnswer.style.maxHeight = '0';
                faqItem.classList.remove('active');
            } else {
                faqItemAnswer.style.maxHeight = faqItemAnswer.scrollHeight + 'px';
                faqItem.classList.add('active');
            }
        });
    });
</script>
