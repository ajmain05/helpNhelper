<footer class="bg-gradient-to-b from-[rgb(2,31,23)] to-[rgb(2,31,23,0.85)] pt-16 pb-36">
    <div class="max-w-[1200px] mx-auto flex flex-col px-2">
            <div class="flex flex-col lg:flex-row gap-7 justify-between mb-12 flex-wrap text-center lg:text-left">
                <div class="flex flex-col w-full lg:max-w-[350px] items-center lg:items-start">
                    <a href="#" class="flex border-white/20 border-2 border-dashed mb-7 max-w-[300px]">
                        <img src="{{ asset('web-assets/images/text-logo.svg') }}" alt="Footer Logo" class="w-fit">
                    </a>
                    <h3 class="text-white text-[28px] font-bold leading-[37.14px] tracking-[0] mb-8 lg:mb-16">{{ __('100% trusted & reliable platform for help seeker & donors') }}</h3>
                    <div class="flex gap-4 justify-center lg:justify-start">
                        <a target="_blank" href="https://www.facebook.com/shamsulhoquefoundation/"
                            class="group flex rounded-[6px] bg-white/20 hover:bg-[#27e36a] py-2 px-2 transition-colors">
                            <img src="{{ asset('web-assets/icons/facebook.svg') }}" alt="Facebook Icon"
                                class="w-full max-w-[14px]">
                        </a>
                        <a target="_blank" href="https://x.com/ashfoundationbd"
                            class="flex rounded-[6px] bg-white/20 hover:bg-[#27e36a] py-2 px-2 transition-colors">
                            <img src="{{ asset('web-assets/icons/twitter.svg') }}" alt="Twitter Icon"
                                class="w-full max-w-[14px]">
                        </a>
                        <a target="_blank" href="https://bd.linkedin.com/company/ashfbd"
                            class="flex rounded-[6px] bg-white/20 hover:bg-[#27e36a] py-2 px-2 transition-colors">
                            <img src="{{ asset('web-assets/icons/linkedin.svg') }}" alt="Linkedin Icon"
                                class="w-full max-w-[14px]">
                        </a>
                        <a target="_blank" href="https://www.youtube.com/@AlhajShamsulHoqueFoundation"
                            class="flex rounded-[6px] bg-white/20 hover:bg-[#27e36a] py-2 px-2 transition-colors">
                            <img src="{{ asset('web-assets/icons/youtube.svg') }}" alt="Youtube Icon"
                                class="w-full max-w-[14px]">
                        </a>
                        <a target="_blank" href="#"
                            class="flex rounded-[6px] bg-white/20 hover:bg-[#27e36a] py-2 px-2 transition-colors">
                            <img src="{{ asset('web-assets/icons/instagram.svg') }}" alt="Instagram Icon"
                                class="w-full max-w-[14px]">
                        </a>
                    </div>

                </div>
                <div class="flex flex-col w-full lg:max-w-[175px] items-center lg:items-start">
                    <h4 class="text-white text-[24px] font-bold leading-[27.14px] tracking-[0] mb-5">{{ __('Quick Links') }}</h4>
                    <div class="flex flex-col gap-3">
                        <a href="{{ route('home') }}"
                            class="text-[20px] font-medium leading-[36px] tracking-[0] text-[#C1C5CC] hover:text-[#27e36a] transition-colors">{{ __('Home') }}</a>
                        <a href="{{ route('current-campaigns') }}"
                            class="text-[20px] font-medium leading-[36px] tracking-[0] text-[#C1C5CC] hover:text-[#27e36a] transition-colors">{{ __('Current Campaign') }}</a>
                        <a href="{{ route('web.our-works') }}"
                            class="text-[20px] font-medium leading-[36px] tracking-[0] text-[#C1C5CC] hover:text-[#27e36a] transition-colors">{{ __('Our Works') }}</a>
                        <a href="{{ route('about-us') }}"
                            class="text-[20px] font-medium leading-[36px] tracking-[0] text-[#C1C5CC] hover:text-[#27e36a] transition-colors">{{ __('About Us') }}</a>
                        <a href="{{ route('web.contact') }}"
                            class="text-[20px] font-medium leading-[36px] tracking-[0] text-[#C1C5CC] hover:text-[#27e36a] transition-colors">{{ __('Contact Us') }}</a>
                    </div>
                </div>
                <div class="flex flex-col w-full lg:max-w-[190px] items-center lg:items-start">
                    <h4 class="text-white text-[24px] font-bold leading-[27.14px] tracking-[0] mb-5">{{ __('Company') }}</h4>
                    <div class="flex flex-col gap-3">
                        <a href="{{ route('terms') }}" class="text-[20px] font-medium leading-[36px] tracking-[0] text-[#C1C5CC] hover:text-[#27e36a] transition-colors">{{ __('Terms & Conditions') }}</a>
                        <a href="{{ route('cookies') }}" class="text-[20px] font-medium leading-[36px] tracking-[0] text-[#C1C5CC] hover:text-[#27e36a] transition-colors">{{ __('Cookie Preferences') }}</a>
                    </div>
                </div>
                <div class="w-full lg:max-w-[400px] flex flex-col items-center lg:items-start">
                    <h4 class="text-white text-[24px] font-bold leading-[27.14px] tracking-[0] mb-5">{{ __('Address') }}</h4>
                    <p class="text-[20px] font-medium leading-[36px] tracking-[0] text-[#c1c5cc] mb-6">Golam Ali Nazir Para,
                        Chandgaon, Chittagong 4212, Bangladesh.</p>
                    
                    <div class="flex flex-col gap-4 w-full items-center lg:items-start">
                        <!-- Phone -->
                        <a href="tel:+8801841040543"
                            class="flex gap-1.5 items-center text-[#C1C5CC] hover:text-[#25D366] transition-colors group w-fit p-2 rounded-lg hover:bg-white/5" title="Call Us">
                            <span class="bg-white/10 p-1 rounded-full group-hover:bg-[#25D366]/20 transition-colors">
                                <img src="{{ asset('web-assets/icons/call.svg') }}" alt="Call Icon"
                                    class="w-5 h-5">
                            </span>
                            <span class="text-[18px] lg:text-[20px] font-medium leading-[28px] tracking-[0]">
                                +880 1841-040543</span>
                        </a>

                        <!-- WhatsApp -->
                        <a href="https://wa.me/8801841040543" target="_blank" 
                            class="flex gap-1.5 items-center text-[#C1C5CC] hover:text-[#25D366] transition-colors group w-fit p-2 rounded-lg hover:bg-white/5" title="WhatsApp">
                            <span class="bg-white/10 p-1 rounded-full group-hover:bg-[#25D366]/20 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"/></svg>
                            </span>
                            <span class="text-[18px] lg:text-[20px] font-medium leading-[28px]">WhatsApp</span>
                        </a>

                        <!-- Email -->
                        <a href="mailto:shamsulhoquefoundation@gmail.com"
                            class="flex gap-1.5 items-center text-[#C1C5CC] hover:text-[#25D366] transition-colors group w-fit p-2 rounded-lg hover:bg-white/5" title="Email Us">
                            <span class="bg-white/10 p-1 rounded-full group-hover:bg-[#25D366]/20 transition-colors shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5"><path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
                            </span>
                            <span class="text-[16px] xl:text-[18px] font-medium leading-[24px] xl:leading-[30px] break-words text-left">
                                shamsulhoquefoundation@gmail.com
                            </span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="flex flex-col lg:flex-row justify-between items-center gap-5 mt-12 w-full">
                <p class="text-[#c1c5cc] text-[14px] font-medium leading-[27.14px] tracking-[0] w-auto text-center lg:text-left">©
                    {{ date('Y') }} helpNhelper.
                    {{ __('All Rights Reserved.') }}</p>
                <div class="flex items-center gap-3 xl:gap-[28px] w-full justify-center lg:justify-end xl:w-auto flex-wrap">
                    <a href="{{ route('current-campaigns') }}"
                        class="flex justify-between gap-2 items-center bg-[#27E36A] pl-[24px] pr-2 py-[6px] rounded-[100px] w-full max-w-[205px]">
                        <span class="text-lg font-semibold leading-7 tracking-normal text-[#101828]">{{ __('Donate Now') }}</span>
                        <span class="bg-white/55 p-4 rounded-full">
                            <svg width="24.000000" height="18.000000" viewBox="0 0 24 18" fill="none"
                                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                <desc>
                                    Created with Pixso.
                                </desc>
                                <defs />
                                <path id="Vector"
                                    d="M9.23 15.57C8.89 15.62 8.54 15.68 8.16 15.75C7.79 15.82 7.35 15.94 6.86 16.11C6.36 16.28 5.79 16.52 5.14 16.82C4.49 17.12 3.71 17.51 2.82 18L0 13.91C1.9 12.79 3.42 11.9 4.56 11.25C5.69 10.61 6.59 10.12 7.24 9.8C7.89 9.48 8.37 9.27 8.69 9.18C9 9.09 9.3 9.03 9.59 9C10.15 8.94 10.78 8.9 11.48 8.9C12.18 8.9 12.86 8.88 13.54 8.83C14.22 8.81 14.83 8.79 15.37 8.76C15.91 8.74 16.33 8.77 16.62 8.87C16.88 8.94 17.02 9.07 17.02 9.26C17.02 9.46 16.96 9.63 16.84 9.76C16.69 9.88 16.52 9.97 16.33 10.04C16.14 10.11 15.92 10.18 15.68 10.25C15.46 10.3 15.25 10.34 15.04 10.37C14.84 10.4 14.64 10.44 14.45 10.49C14.25 10.54 14.08 10.57 13.94 10.59C13.79 10.62 13.65 10.67 13.51 10.77C13.36 10.86 13.21 10.97 13.05 11.11C12.9 11.25 12.72 11.41 12.53 11.6C13.47 11.64 14.28 11.67 14.97 11.67C15.66 11.67 16.25 11.65 16.75 11.63C17.24 11.61 17.66 11.58 18.01 11.54C18.36 11.51 18.67 11.47 18.94 11.42C19.47 11.31 19.9 11.16 20.22 10.99C20.55 10.82 20.84 10.64 21.11 10.46C21.38 10.25 21.63 10.04 21.87 9.83C22.11 9.63 22.33 9.46 22.52 9.35C22.91 9.12 23.23 9.06 23.5 9.18C23.77 9.31 23.92 9.51 23.97 9.76C24.02 9.88 23.99 10.01 23.9 10.16C23.8 10.31 23.57 10.57 23.21 10.94C23.02 11.1 22.79 11.29 22.54 11.51C22.29 11.73 22.02 11.96 21.74 12.2C21.47 12.44 21.19 12.68 20.91 12.91C20.63 13.14 20.37 13.34 20.13 13.5C19.67 13.84 19.31 14.07 19.05 14.19C18.78 14.31 18.49 14.41 18.18 14.5C17.55 14.64 16.78 14.75 15.86 14.85C14.94 14.94 13.93 15.04 12.82 15.16C12.26 15.2 11.69 15.26 11.11 15.31C10.54 15.37 9.91 15.46 9.23 15.57L9.23 15.57ZM11.44 6.27C10.91 5.95 10.41 5.57 9.95 5.13C9.5 4.69 9.13 4.22 8.87 3.71C8.63 3.23 8.52 2.73 8.56 2.23C8.6 1.72 8.81 1.25 9.19 0.81C9.36 0.6 9.59 0.41 9.86 0.24C10.14 0.07 10.47 -0.01 10.86 0C11.25 0.01 11.67 0.14 12.15 0.39C12.62 0.65 13.14 1.07 13.72 1.67C14.3 1.07 14.83 0.65 15.31 0.39C15.8 0.14 16.23 0.01 16.62 0C17 -0.02 17.33 0.07 17.6 0.24C17.86 0.41 18.09 0.6 18.28 0.81C18.67 1.25 18.88 1.72 18.92 2.23C18.95 2.73 18.84 3.23 18.57 3.71C18.31 4.22 17.95 4.69 17.51 5.13C17.06 5.57 16.56 5.95 16 6.27C15.59 6.53 15.19 6.76 14.79 6.96C14.39 7.17 14.1 7.47 13.9 7.86C13.85 7.95 13.8 8 13.74 8C13.68 8 13.62 7.95 13.58 7.86C13.38 7.47 13.09 7.17 12.69 6.96C12.29 6.76 11.87 6.52 11.44 6.27L11.44 6.27ZM9.52 1.5C9.37 1.82 9.33 2.11 9.37 2.36C9.4 2.6 9.47 2.69 9.59 2.64C9.64 2.62 9.71 2.48 9.81 2.23C9.86 2.11 9.9 2 9.95 1.88C10 1.77 10.09 1.65 10.21 1.54C10.35 1.35 10.54 1.24 10.79 1.19C10.91 1.14 11.02 1.13 11.11 1.14C11.21 1.15 11.28 1.16 11.33 1.16C11.5 1.11 11.57 1.06 11.55 1.02C11.5 0.86 11.35 0.75 11.11 0.71C10.85 0.59 10.56 0.61 10.24 0.77C9.9 0.94 9.66 1.18 9.52 1.5L9.52 1.5ZM15.64 11.49C16.15 11.1 16.64 10.75 17.11 10.44C17.58 10.13 17.97 9.88 18.28 9.7C18.62 9.51 18.9 9.38 19.12 9.31C19.33 9.25 19.66 9.23 20.09 9.28C19.64 9.63 19.15 9.97 18.63 10.32C18.11 10.66 17.56 11.03 16.98 11.42C16.81 11.45 16.61 11.47 16.38 11.48C16.15 11.49 15.91 11.49 15.64 11.49L15.64 11.49ZM19.41 11.01C19.19 11.08 18.92 11.15 18.61 11.22C18.29 11.29 17.88 11.34 17.38 11.39C18.17 10.91 18.8 10.49 19.26 10.13C19.72 9.77 20.1 9.49 20.42 9.28C20.73 9.1 21.02 8.99 21.27 8.95C21.52 8.92 21.87 9 22.3 9.21C21.96 9.47 21.64 9.7 21.34 9.92C21.04 10.14 20.78 10.33 20.56 10.49C20.32 10.65 20.12 10.77 19.97 10.84C19.81 10.91 19.62 10.96 19.4 11.01L19.41 11.01Z"
                                    fill="#101828" fill-opacity="1.000000" fill-rule="nonzero" />
                            </svg>
                        </span>
                    </a>
                </div>    {{-- <a href="#"
                    class="text-[18px] font-semibold leading-[28px] tracking-[0] py-5 px-10 text-white bg-[rgb(23_153_234)] rounded-full w-fit">I
                    Want to Fund Request</a> --}}
            </div>
        </div>
    </div>
</footer>
