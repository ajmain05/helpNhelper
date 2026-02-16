<x-web-layout>
    <x-slot name="title">HelpNHelper - Signup</x-slot>
    <x-signup :countries="$countries" :divisions="$divisions" :districts="$districts" :upazilas="$upazilas" />
    <x-slot name="scripts">
        <script>
            // Password validation
            const passwordInput = document.querySelector(`input[name="password"]`);
            const toggleButton = document.querySelector('#togglePassword');
            const eyeIcon = toggleButton.querySelector('.eye-icon');
            const eyeOffIcon = toggleButton.querySelector('.eye-off-icon');

            toggleButton.addEventListener('click', function() {
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    eyeIcon.classList.add('hidden');
                    eyeOffIcon.classList.remove('hidden');
                } else {
                    passwordInput.type = 'password';
                    eyeIcon.classList.remove('hidden');
                    eyeOffIcon.classList.add('hidden');
                }
            });



            // Confirm Password validation
            const confirmPasswordInput = document.querySelector(`input[name="password_confirmation"]`);
            const confirmToggleButton = document.querySelector('#confirmTogglePassword');
            const confirmEyeIcon = confirmToggleButton.querySelector('.confirm-eye-icon');
            const confirmEyeOffIcon = confirmToggleButton.querySelector('.confirm-eye-off-icon');

            confirmToggleButton.addEventListener('click', function() {
                if (confirmPasswordInput.type === 'password') {
                    confirmPasswordInput.type = 'text';
                    confirmEyeIcon.classList.add('hidden');
                    confirmEyeOffIcon.classList.remove('hidden');
                } else {
                    confirmPasswordInput.type = 'password';
                    confirmEyeIcon.classList.remove('hidden');
                    confirmEyeOffIcon.classList.add('hidden');
                }
            });

            const facebookLinkDiv = document.querySelector(`#fb_link_div`);
            const licenseImageDiv = document.querySelector(`#licenseImageDiv`);
            const officeAddressDiv = document.querySelector(`#officeAddressDiv`);
            const licenseNoDiv = document.querySelector(`#licenseNoDiv`);

            function updateFormOnAccountType(accountTitleSpans) {

                const accountTypeInput = document.querySelectorAll(`input[type="radio"][name="type"]`);
                let accountType = "";
                accountTypeInput.forEach((item) => {
                    if (item.checked) accountType = item.value;
                });

                if (accountType == 'volunteer' || accountType == 'seeker' || accountType == 'donor' || accountType ==
                    'corporate-donor') {
                    licenseImageDiv.classList.add("hidden");
                    officeAddressDiv.classList.add("hidden");
                    licenseNoDiv.classList.add("hidden");
                }
                if (accountType == 'organization') {
                    licenseImageDiv.classList.remove("hidden");
                    officeAddressDiv.classList.remove("hidden");
                    licenseNoDiv.classList.remove("hidden");
                }
                if (accountType == 'volunteer') {
                    facebookLinkDiv.classList.remove("hidden");
                } else {
                    facebookLinkDiv.classList.add("hidden");
                    document.getElementById("fb_link").value = "";
                }

                if (accountType == 'donor' || accountType == 'corporate-donor') {
                    document.querySelector(`#step2SkipBtn`).classList.remove("hidden");
                    document.querySelector(`#step3SkipBtn`).classList.remove("hidden");
                } else {
                    document.querySelector(`#step2SkipBtn`).classList.add("hidden");
                    document.querySelector(`#step3SkipBtn`).classList.add("hidden");
                }

                // Input Field Update
                // const nidInput = document.querySelector(".nid-input-div");
                // if(accountType == "volunteer" || accountType == "seeker" || accountType == "organization"){
                //     nidInput.classList.remove("hidden");
                // }else{
                //     nidInput.classList.add("hidden");
                // }
                accountTitleSpans.forEach((titleSpan, index) => {
                    accountType = accountType[0].toUpperCase() + accountType.substring(1);
                    accountType = accountType.replace("-", " ");

                    titleSpan.textContent = accountType;
                });

            }
            const next_btn = document.querySelectorAll(".reg-reg-next-btn");
            const prev_btn = document.querySelectorAll(".reg-reg-prev-btn");
            const container = document.querySelector('.reg-step-container');
            const section = document.querySelector('.reg_step');
            const accountTitleSpans = document.querySelectorAll(".registration-title span");
            next_btn.forEach(element => {
                element.addEventListener("click", () => {
                    const selectedType = document.querySelector('input[name="type"]:checked');
                    if (!selectedType) {
                        // Dismiss all existing popups
                        document.querySelectorAll('.message-popup').forEach(el => el.classList.remove('active',
                            'z-50'));
                        document.querySelector('.error-message').classList.remove('hidden');
                        // Display error message
                        const messagePopup = document.querySelector('.error-message');
                        messagePopup.querySelector("strong").textContent = "Error";
                        messagePopup.querySelector("p").textContent = "Please select an account type.";
                        messagePopup.classList.add("active", "z-50");
                        return;
                    }
                    document.querySelectorAll('.message-popup').forEach(el => el.classList.remove('active',
                        'z-50'));

                    container.scrollBy({
                        left: section.offsetWidth,
                        behavior: 'smooth'
                    });
                    updateFormOnAccountType(accountTitleSpans);
                });
            });
            prev_btn.forEach(element => {
                element.addEventListener("click", () => {

                    container.scrollBy({
                        left: -section.offsetWidth,
                        behavior: 'smooth'
                    });
                    updateFormOnAccountType(accountTitleSpans);
                });
            });

            class InputImage extends HTMLElement {
                constructor() {
                    super();
                    this.fileInput = this.querySelector(".file-input");
                    this.imagePlaceholder = this.querySelector(".image-placeholder");
                    this.removeButton = this.querySelector(".removeButton");
                }
                connectedCallback() {

                    this.fileInput.addEventListener("change", (event) => {
                        const file = event.target.files[0];
                        if (file) {
                            if (file.type == 'application/pdf') {
                                this.removeButton.classList.remove("hidden");
                                this.imagePlaceholder.innerHTML =
                                    `<p class="text-lg">${file.name}</p>`;
                                this.imagePlaceholder.appendChild(this.removeButton);
                            } else {
                                const reader = new FileReader();
                                reader.onload = (e) => {
                                    // Set the image as the content of the placeholder
                                    this.imagePlaceholder.innerHTML =
                                        `<img src="${e.target.result}" alt="Selected Image" class="w-full max-w-[300px] h-full object-cover rounded-lg" />`;
                                    // Show the remove button
                                    this.removeButton.classList.remove("hidden");
                                    // Add the button back to the placeholder
                                    this.imagePlaceholder.appendChild(this.removeButton);
                                };
                                reader.readAsDataURL(file);
                            }
                        }
                    });

                    this.removeButton.addEventListener("click", () => {
                        // Clear the placeholder content
                        this.imagePlaceholder.innerHTML = `
                    <svg class="h-[111px]" width="111.012207" height="111.000000" viewBox="0 0 111.012 111" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                        <desc>
                                Created with Pixso.
                        </desc>
                        <defs/>
                        <path id="Icon" d="M96.33 3C102.77 3 108 8.22 108 14.66L108 96.33C108 102.77 102.77 108 96.33 108L14.66 108C8.22 108 3 102.77 3 96.33L3 14.66C3 8.22 8.22 3 14.66 3L96.33 3ZM35.08 43.83C30.25 43.83 26.33 39.91 26.33 35.08C26.33 30.25 30.25 26.33 35.08 26.33C39.91 26.33 43.83 30.25 43.83 35.08C43.83 39.91 39.91 43.83 35.08 43.83ZM108 73L78.83 43.83L14.66 108" stroke="#0F1728" stroke-opacity="1.000000" stroke-width="6.000000" stroke-linejoin="round" stroke-linecap="round"/>
                    </svg>
                    `;
                        // Hide the remove button
                        this.removeButton.classList.add("hidden");
                        // Reset the input field
                        this.fileInput.value = "";
                    });
                }
            }
            customElements.define("input-image", InputImage);

            // Remove popup
            const closePopupBtn = document.querySelector("#dismiss-popup");
            const popup = document.querySelector(".message-popup");
            closePopupBtn.addEventListener("click", () => {
                popup.classList.add("hidden");
            });

            // Form submission
            document.querySelector('form').addEventListener('submit', function(e) {
                e.preventDefault();

                const submitBtn = this.querySelector('.submit-btn');
                submitBtn.disabled = true;
                submitBtn.textContent = "Please wait...";

                const form = this;

                const url = '{{ route('user.request') }}';
                const formData = new FormData(form);
                if (document.querySelector('#terms').checked) {
                    formData.append('terms', 1);
                }

                const xhr = new XMLHttpRequest();
                xhr.open('POST', url, true);
                xhr.setRequestHeader('Accept', 'application/json');
                xhr.setRequestHeader('X-CSRF-TOKEN', "{{ csrf_token() }}");
                xhr.upload.addEventListener('progress', function(e) {
                    if (e.lengthComputable) {
                        const percentComplete = (e.loaded / e.total) * 100;
                        // Update progress bar
                        const progressBar = document.querySelector('.progress-bar');
                        progressBar.setAttribute('aria-valuenow', percentComplete);
                        progressBar.querySelector(".progress-bar-text").textContent = `${percentComplete}%`;
                        progressBar.querySelector(".progress-bar-line").style.width = percentComplete + '%';
                    }
                });

                xhr.onload = function() {

                    if (xhr.status === 200) {

                        console.log(xhr.responseText);
                        const response = JSON.parse(xhr.responseText);
                        // Dismiss all existing popups
                        document.querySelectorAll('.message-popup').forEach(el => el.classList.remove('active',
                            'z-50'));
                        document.querySelector('.success-message').classList.remove('hidden');
                        // Display success message
                        const messagePopup = document.querySelector('.success-message');
                        messagePopup.querySelector("strong").textContent = "Success";
                        messagePopup.querySelector("p").textContent = response.message;
                        messagePopup.classList.add("active", "z-50");

                        form.reset();
                        submitBtn.disabled = false;
                        submitBtn.textContent = "Create Account";

                        document.getElementById('overlay').style.display = 'none';
                        document.getElementById('popup').style.display = 'none';

                        // Reset progress bar
                        const progressBar = document.querySelector('.progress-bar');
                        progressBar.setAttribute('aria-valuenow', 0);
                        progressBar.querySelector(".progress-bar-text").textContent = `${0}%`;
                        progressBar.querySelector(".progress-bar-line").style.width = 0 + '%';
                    } else {
                        handleError(xhr);
                    }
                };

                xhr.onerror = function() {
                    handleError(xhr);
                };

                xhr.send(formData);

                function handleError(xhr) {
                    const response = xhr.responseText ? JSON.parse(xhr.responseText) : {
                        message: "An error occurred."
                    };
                    console.log(response);
                    document.querySelector('.error-message').classList.remove('hidden');

                    submitBtn.disabled = false;
                    submitBtn.textContent = "Create Account";
                    document.getElementById('overlay').style.display = 'none';
                    document.getElementById('popup').style.display = 'none';

                    // Reset progress bar
                    const progressBar = document.querySelector('.progress-bar');
                    progressBar.style.width = '0%';
                    progressBar.setAttribute('aria-valuenow', 0);

                    // Dismiss all existing popups
                    document.querySelectorAll('.message-popup').forEach(el => el.classList.remove('active',
                        'z-50'));
                    // Display error message
                    const messagePopup = document.querySelector('.error-message');
                    messagePopup.querySelector("strong").textContent = "Error";
                    messagePopup.querySelector("p").textContent = response.message;
                    messagePopup.classList.add("active");
                }
            });


            // Searchable select dropdown 
            let countries = @json($countries).map(item => ({
                id: item.id,
                name: item.name
            }));

            const elements = {
                country: {
                    search: "#countrySearchInput",
                    suggestions: "#countrySuggestions",
                    input: "country"
                },
                division: {
                    search: "#divisionSearchInput",
                    suggestions: "#divisionSuggestions",
                    input: "division"
                },
                district: {
                    search: "#districtSearchInput",
                    suggestions: "#districtSuggestions",
                    input: "district"
                },
                upazila: {
                    search: "#upazilaSearchInput",
                    suggestions: "#upazilaSuggestions",
                    input: "upazila"
                }
            };

            const endpoints = {
                country: "/get-divisions",
                division: "/get-districts",
                district: "/get-upazilas"
            };

            let divisions = [];
            let districts = [];
            let upazilas = [];

            function resetFields(type) {
                if (type === "division") {
                    divisions = [];
                } else if (type === "district") {
                    districts = [];
                } else if (type === "upazila") {
                    upazilas = [];
                }
                // Fields to reset based on the type passed
                const fieldsToReset = {
                    division: [elements.division, elements.district, elements.upazila],
                    district: [elements.district, elements.upazila],
                    upazila: [elements.upazila]
                };

                // Get the fields to reset based on type
                const fields = fieldsToReset[type];

                // Reset each field
                fields.forEach(field => {
                    document.querySelector(field.search).value = "";
                    document.querySelector(field.suggestions).innerHTML = "";
                    document.querySelector(`input[name="${field.input}"]`).value = "";
                });
            }


            function searchSelectBox(searchInput, suggestions, hiddenInput, allData, type) {
                function renderSuggestions(filteredData) {
                    suggestions.innerHTML = "";
                    filteredData.forEach((data) => {
                        const option = document.createElement("div");
                        option.textContent = data.name;
                        option.classList = "py-2 px-4 cursor-pointer hover:bg-gray-100 text-[18px] font-medium";
                        option.addEventListener("click", () => {
                            searchInput.value = data.name;
                            hiddenInput.value = data.id;
                            suggestions.classList.add("hidden");
                            if (type === "country") {
                                resetFields("division");
                                resetFields("district");
                                resetFields("upazila");
                                fetch(`/get-divisions/${data.id}`)
                                    .then((response) => response.json())
                                    .then((result) => {
                                        divisions = result.data;
                                        searchSelectBox(
                                            document.querySelector(elements.division.search),
                                            document.querySelector(elements.division.suggestions),
                                            document.querySelector(
                                                `input[name="${elements.division.input}"]`),
                                            divisions,
                                            "division"
                                        );
                                    })
                                    .catch((error) => console.error("Error:", error));
                            } else if (type === "division") {
                                resetFields("district");
                                resetFields("upazila");
                                fetch(`/get-districts/${data.id}`)
                                    .then((response) => response.json())
                                    .then((result) => {
                                        districts = result.data;
                                        searchSelectBox(
                                            document.querySelector(elements.district.search),
                                            document.querySelector(elements.district.suggestions),
                                            document.querySelector(
                                                `input[name="${elements.district.input}"]`),
                                            districts,
                                            "district"
                                        );
                                    })
                                    .catch((error) => console.error("Error:", error));
                            } else if (type === "district") {
                                resetFields("upazila");
                                fetch(`/get-upazilas/${data.id}`)
                                    .then((response) => response.json())
                                    .then((result) => {
                                        upazilas = result.data;
                                        searchSelectBox(
                                            document.querySelector(elements.upazila.search),
                                            document.querySelector(elements.upazila.suggestions),
                                            document.querySelector(
                                                `input[name="${elements.upazila.input}"]`),
                                            upazilas,
                                            "upazila"
                                        );
                                    })
                                    .catch((error) => console.error("Error:", error));
                            }
                        });
                        suggestions.appendChild(option);
                    });
                    suggestions.classList.toggle("hidden", filteredData.length === 0);
                }

                searchInput.addEventListener("click", () => {
                    suggestions.innerHTML = "";
                    if (type === "country") {
                        renderSuggestions(countries);
                    } else if (type === "division") {
                        renderSuggestions(divisions);
                    } else if (type === "district") {
                        renderSuggestions(districts);
                    } else if (type === "upazila") {
                        renderSuggestions(upazilas);
                    }
                    suggestions.classList.remove("hidden");
                });

                searchInput.addEventListener("input", () => {
                    if (type === "country") {
                        const searchValue = searchInput.value.toLowerCase();
                        renderSuggestions(countries.filter(d => d.name.toLowerCase().includes(searchValue)));
                    } else if (type === "division") {
                        const searchValue = searchInput.value.toLowerCase();
                        renderSuggestions(divisions.filter(d => d.name.toLowerCase().includes(searchValue)));
                    } else if (type === "district") {
                        const searchValue = searchInput.value.toLowerCase();
                        renderSuggestions(districts.filter(d => d.name.toLowerCase().includes(searchValue)));
                    } else if (type === "upazila") {
                        const searchValue = searchInput.value.toLowerCase();
                        renderSuggestions(upazilas.filter(d => d.name.toLowerCase().includes(searchValue)));
                    }
                });

                document.addEventListener("click", (event) => {
                    if (!searchInput.contains(event.target) && !suggestions.contains(event.target)) {
                        suggestions.classList.add("hidden");
                    }
                });
            }

            // Initialize search for country
            searchSelectBox(
                document.querySelector(elements.country.search),
                document.querySelector(elements.country.suggestions),
                document.querySelector(`input[name="${elements.country.input}"]`),
                countries,
                "country"
            );


            // External function to get image URL by type
            function getImageUrlByType(type) {
                switch (type) {
                    case 'volunteer':
                        return "{{ asset('web-assets/v2-images/sign-up/2 Volunteer.jpg') }}";
                    case 'seeker':
                        return "{{ asset('web-assets/v2-images/sign-up/3 Sekeer.jpg') }}";
                    case 'donor':
                        return "{{ asset('web-assets/v2-images/sign-up/4 Doner.jpg') }}";
                    case 'corporate-donor':
                        return "{{ asset('web-assets/v2-images/sign-up/5 Corporate.jpg') }}";
                    case 'organization':
                        return "{{ asset('web-assets/v2-images/sign-up/6 organisation.jpg') }}";
                    default:
                        return "{{ asset('web-assets/v2-images/sign-up/1-Main singup.webp') }}";
                }
            }

            // Update background image helper
            function updateBackgroundImage(type) {
                document.querySelector('.signup-container').style.backgroundImage = `url('${getImageUrlByType(type)}')`;
            }

            //The script auto-selects the matching radio input by reading the type parameter from the URL
            // and setting the corresponding input as checked.
            const params = new URLSearchParams(window.location.search);
            const type = params.get('type');

            if (type) {
                const input = document.querySelector(`input[name="type"][value="${type}"]`);
                if (input) {
                    input.checked = true;
                    updateBackgroundImage(input.value);
                    input.dispatchEvent(new Event('change'));
                }
            }

            //On radio change, this updates the type query parameter in the URL using pushState without page reload.
            document.querySelectorAll('input[name="type"]').forEach(input => {
                input.addEventListener('change', () => {
                    const selectedType = input.value;
                    const url = new URL(window.location);
                    url.searchParams.set('type', selectedType);
                    window.history.pushState({}, '', url);

                    // Update background
                    updateBackgroundImage(selectedType);
                });
            });
        </script>
    </x-slot>
</x-web-layout>
