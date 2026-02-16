<div class="custom-container">
    <form action="{{ route('web.donation-store') }}" method="post" class="">
        @csrf
        <input type="hidden" name="campaign_id" value="{{ $campaignId }}">
        @error('amount')
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mt-4 mb-4">{{ $message }}
            </div>
        @enderror
        <div class="flex flex-col items-center rounded-[24px] bg-[#ffffffa3] py-8">
            <div class="flex flex-col items-center w-full">
                <h3 class="text-[#101828] text-4xl font-medium tracking-normal text-center mb-10 w-full">{{ __('Donate Amount') }}
                </h3>
                <div class="w-full bg-white py-5 flex justify-center relative mb-7">
                    <div class=""></div>
                    <input type="text" name="amount" id="amount" value="0"
                        class="text-4xl font-bold text-[#101828] text-center w-full outline-none border-none">
                    <p class="text-3xl text-[#101828] font-medium tracking-normal absolute right-5">BDT</p>
                </div>
            </div>
            <div class="">
                <fieldset class="flex gap-6 flex-wrap p-2">
                    <legend class="sr-only">Color</legend>
                    <div>
                        <label for="value_500"
                            class="flex cursor-pointer px-8 py-3 items-center justify-center rounded-full border-black group bg-transparent text-gray-900 hover:text-[#1799EA] border  hover:border-[#1799EA] has-[:checked]:border-blue-500 has-[:checked]:bg-[#1799EA] has-[:checked]:text-white">
                            <input type="radio" name="selectedAmount" value="500" id="value_500" class="sr-only" />

                            <p
                                class="bg-transparent text-black group-has-[:checked]:text-white rounded-full text-lg font-medium leading-7 tracking-normal">
                                BDT 500</p>
                        </label>
                    </div>
                    <div>
                        <label for="value_1000"
                            class="flex cursor-pointer px-8 py-3 items-center justify-center rounded-full border-black group bg-transparent text-gray-900 hover:text-[#1799EA] border  hover:border-[#1799EA] has-[:checked]:border-blue-500 has-[:checked]:bg-[#1799EA] has-[:checked]:text-white">
                            <input type="radio" name="selectedAmount" value="1000" id="value_1000"
                                class="sr-only" />

                            <p
                                class="bg-transparent text-black group-has-[:checked]:text-white rounded-full text-lg font-medium leading-7 tracking-normal">
                                BDT 1000</p>
                        </label>
                    </div>
                    <div>
                        <label for="value_5000"
                            class="flex cursor-pointer px-8 py-3 items-center justify-center rounded-full border-black group bg-transparent text-gray-900 hover:text-[#1799EA] border  hover:border-[#1799EA] has-[:checked]:border-blue-500 has-[:checked]:bg-[#1799EA] has-[:checked]:text-white">
                            <input type="radio" name="selectedAmount" value="5000" id="value_5000"
                                class="sr-only" />
                            <p
                                class="bg-transparent text-black group-has-[:checked]:text-white rounded-full text-lg font-medium leading-7 tracking-normal">
                                BDT 5000</p>
                        </label>
                    </div>
                    <div>
                        <label for="value_custom"
                            class="flex cursor-pointer px-8 py-3 items-center justify-center rounded-full border-black group bg-transparent text-gray-900 hover:text-[#1799EA] border  hover:border-[#1799EA] has-[:checked]:border-blue-500 has-[:checked]:bg-[#1799EA] has-[:checked]:text-white">
                            <input type="radio" name="selectedAmount" value="0" id="value_custom" class="sr-only"
                                checked />

                            <p
                                class="bg-transparent text-black group-has-[:checked]:text-white rounded-full text-lg font-medium leading-7 tracking-normal">
                                {{ __('Custom') }}</p>
                        </label>
                    </div>

                </fieldset>
            </div>
        </div>
        <div class="mt-10 bg-[#ffffffa3] py-10 px-12 rounded-[24px]">
            <h3 class="text-[#101828] text-4xl font-medium tracking-normal mb-12">{{ __('Personal Information') }}</h3>
            <fieldset class="grid grid-cols-1 xl:grid-cols-2 gap-4 w-fit mb-5">
                <legend class="sr-only">Donor Type</legend>

                <div class="max-w-[115px]">
                    <label for="anonymousDonor"
                        class="block cursor-pointer rounded-lg border border-gray-100 bg-white p-4 text-sm font-medium shadow-sm hover:border-gray-200 has-[:checked]:border-blue-500 has-[:checked]:ring-1 has-[:checked]:ring-blue-500">
                        <div>
                            <p class="text-gray-700">{{ __('Anonymous') }}</p>
                        </div>

                        <input type="radio" name="donor_type" value="anonymous" id="anonymousDonor" class="sr-only"
                            checked />
                    </label>
                </div>

                <div class="max-w-[90px]">
                    <label for="accountDonor"
                        class="block cursor-pointer rounded-lg border border-gray-100 bg-white p-4 text-sm font-medium shadow-sm hover:border-gray-200 has-[:checked]:border-blue-500 has-[:checked]:ring-1 has-[:checked]:ring-blue-500">
                        <div>
                            <p class="text-gray-700">{{ __('Account') }}</p>
                        </div>

                        <input type="radio" name="donor_type" value="account" id="accountDonor" class="sr-only" />
                    </label>
                </div>
            </fieldset>
            <div class="flex mb-6" id="phoneInputDiv">
                <input name="phone" type="text"
                    class="w-full py-2 px-5 text-[#101828] text-xl tracking-normal border-2 border-solid border-[#00000024] bg-[#ffffffa3] rounded-2xl outline-none"
                    placeholder="{{ __('Mobile Number') }}">
            </div>
            @error('phone')
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mt-4 mb-4">{{ $message }}
                </div>
            @enderror
            <div class="flex items-center space-x-2 mb-9">
                <input id="agree" type="checkbox"
                    class="w-5 h-5 text-blue-500 border-gray-300 rounded focus:ring-blue-400 focus:ring-offset-0">
                <label for="agree" class="text-sm text-gray-800">
                    {{ __('I have read & agree to the websites Terms & Conditions, Privacy Policy and Refund Policy') }}
                </label>
            </div>
            <button type="submit"
                class="flex justify-between gap-2 items-center bg-[#27E36A] pl-[24px] pr-2 py-2 rounded-[100px] w-full max-w-[180px]">
                <span class="text-[16px] font-semibold leading-7 tracking-normal text-[#101828]">{{ __('Donate Now') }}</span>
                <span class="bg-white/55 p-2 rounded-full">
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
            </button>
        </div>
</div>
</form>
</div>
