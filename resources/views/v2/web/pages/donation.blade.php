@php
    $heroSectionTitle = 'Donate';
    $bgImage = asset('web-assets/images/current-campaigns.png');
@endphp
<x-web-layout>
    <div>
        <x-hero-section :type="2" :title="$heroSectionTitle" :bgImage="$bgImage"></x-hero-section>
        {{-- <div class="py-12"
            style="background: linear-gradient(180.00deg, rgba(39, 227, 106, 0.9) 19.105%,rgba(39, 227, 106, 0) 87.542%), url('{{ asset('web-assets/images/campaign-collection.png') }}');"> --}}
        <div class="py-12 bg-[rgba(39_227_106)]">
            <x-make-donation :campaignId="$campaign->id" />
        </div>
    </div>
    <x-slot name="title">HelpNHelper - Donate</x-slot>
    <x-slot name="scripts">
        <script>
            const selectedOption = document.querySelectorAll(`input[type="radio"][name="selectedAmount"]`);
            const amountInput = document.querySelector(`input[name="amount"]`);
            selectedOption.forEach(element => {
                element.addEventListener("change", () => {
                    if (element.checked) {
                        amountInput.value = element.value;
                    }
                })
            });

            const selectDonor = document.querySelectorAll(`input[type="radio"][name="donor_type"]`);
            const mobileInput = document.querySelector(`#phoneInputDiv`);
            selectDonor.forEach(element => {
                element.addEventListener("change", () => {
                        if (element.checked && element.value == "account") {
                            mobileInput.classList.add("hidden");
                            @guest
                            window.location.href = "{{ url('/sign-in') }}";
                        @endguest
                    } else {
                        mobileInput.classList.remove("hidden");
                    }
                })
            });
        </script>
    </x-slot>
</x-web-layout>
