@extends('layouts.app')

@section('title', 'Step 4: Billing Information')
@section('header', 'Billing Details')

@section('content')
<script src="https://code.iconify.design/3/3.1.0/iconify.min.js"></script>

<style>
    :root {
        --primary: #0d6efd; /* Matching Bootstrap's primary color */
    }
    .iconify {
        width: 25px;
        height: 25px;
    }
    .select-box {
        position: relative;
        width: 100%;
    }
    .selected-option {
        display: flex;
        border-radius: .375rem;
        border: 1px solid #ced4da;
        overflow: hidden;
        transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
    }
    .selected-option:has(input:focus) {
        border-color: #86b7fe;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    }
    .country-code-selector {
        display: flex;
        align-items: center;
        gap: .5rem;
        padding: .375rem .75rem;
        background-color: #e9ecef;
        cursor: pointer;
        position: relative;
        padding-right: 2rem;
    }
    .country-code-selector::after {
        position: absolute;
        content: "";
        right: .8rem;
        top: 50%;
        transform: translateY(-50%) rotate(45deg);
        width: .6rem;
        height: .6rem;
        border-right: .1rem solid var(--primary);
        border-bottom: .1rem solid var(--primary);
        transition: transform .2s;
    }
    .country-code-selector.active::after {
        transform: translateY(-50%) rotate(225deg);
    }
    .select-box input[type="tel"] {
        flex-grow: 1;
        width: auto;
        border: none;
        outline: none;
        padding: .375rem .75rem;
        font-size: 1rem;
    }
    .select-box .options {
        display: none;
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        width: 100%;
        background-color: #fff;
        border-radius: .375rem;
        border: 1px solid #ced4da;
        margin-top: .5rem;
        z-index: 10;
        box-shadow: 0 .5rem 1rem rgba(0,0,0,.15);
    }
    .select-box .options.active {
        display: block;
    }
    .select-box .options::before {
        position: absolute;
        content: "";
        left: 1.5rem;
        top: -0.7rem;
        width: 0;
        height: 0;
        border: .6rem solid transparent;
        border-bottom-color: #ced4da;
    }
    .select-box .options::after {
        position: absolute;
        content: "";
        left: 1.5rem;
        top: -0.6rem;
        width: 0;
        height: 0;
        border: .6rem solid transparent;
        border-bottom-color: #fff;
    }
    input.search-box {
        width: 100%;
        border: none;
        outline: none;
        background-color: var(--primary);
        color: #fff;
        padding: 1rem;
        border-bottom: 1px solid #ddd;
        border-radius: .375rem .375rem 0 0;
    }
    input.search-box::placeholder {
        color: #f8f9fa;
    }
    .select-box ol {
        list-style: none;
        max-height: 20rem;
        overflow-y: auto;
        padding: 0;
        margin: 0;
    }
    .select-box ol::-webkit-scrollbar {
        width: 0.5rem;
    }
    .select-box ol::-webkit-scrollbar-thumb {
        background-color: #ccc;
        border-radius: .4rem;
    }
    .select-box ol li {
        padding: .75rem 1rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        cursor: pointer;
        gap: .5rem;
    }
    .select-box ol li.hide {
        display: none;
    }
    .select-box ol li:not(:last-child) {
        border-bottom: .1rem solid #eee;
    }
    .select-box ol li:hover {
        background-color: #f0f8ff;
    }
</style>

<div class="card shadow-sm">
    <div class="card-body p-5">
        <h5 class="card-title text-center mb-4">Step 4 of 5: Billing Information</h5>
        <p class="text-center text-muted small">This is for demonstration purposes only. No payment will be taken.</p>

        <form action="{{ route('onboarding.step4.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="billing_name" class="form-label">Billing Name</label>
                <input type="text" class="form-control" id="billing_name" name="billing_name" value="{{ old('billing_name', $session->billing_name ?? '') }}" required>
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <input type="text" class="form-control" id="address" name="address" value="{{ old('address', $session->address ?? '') }}" required>
            </div>
            <div class="mb-3">
                <label for="country" class="form-label">Country</label>
                <input type="text" class="form-control" id="country" name="country" value="{{ old('country', $session->country ?? '') }}" required>
            </div>

            <div class="mb-4">
                <label for="phone_number" class="form-label">Phone Number</label>
                <div class="select-box">
                    <div class="selected-option">
                        <div class="country-code-selector">
                            <span class="iconify" data-icon="flag:gb-4x3"></span>
                            <strong>+44</strong>
                        </div>
                        <input type="tel" placeholder="Phone Number" id="phone_number" name="phone_number" value="{{ old('phone_number', $session->phone_number ?? '+44') }}" required>
                    </div>
                    <div class="options">
                        <input type="text" class="search-box" placeholder="Search Country Name">
                        <ol></ol>
                    </div>
                </div>
            </div>

            <div class="row g-3">
                <div class="col">
                    <a href="javascript:history.back()" class="btn btn-outline-secondary w-100">
                        &larr; Back
                    </a>
                </div>
                <div class="col">
                    <button type="submit" class="btn btn-primary w-100">Continue</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const countries = [
            { name: "Pakistan", code: "PK", phone: 92, numberLength: 10 },
            { name: "India", code: "IN", phone: 91, numberLength: 10 },
            { name: "United Kingdom", code: "GB", phone: 44, numberLength: 10 },
            { name: "United States", code: "US", phone: 1, numberLength: 10 },
            { name: "Saudi Arabia", code: "SA", phone: 966, numberLength: 9 },
            { name: "United Arab Emirates", code: "AE", phone: 971, numberLength: 9 }

        ];

        const selectBox = document.querySelector('.select-box');
        const optionsContainer = document.querySelector('.options');
        const searchBox = document.querySelector('.search-box');
        const phoneInput = document.querySelector('input[type="tel"]');
        const countryCodeSelector = document.querySelector('.country-code-selector');
        const optionsList = document.querySelector('.select-box ol');

        let currentCode = '+44';
        let options = null;

        function findCountryByCode(code) {
            if (!code.startsWith('+')) return null;
            const numericCode = code.substring(1);
            return countries.find(c => String(c.phone) === numericCode);
        }

        function getInitialCode() {
            const initialValue = phoneInput.value.trim();
            if (initialValue.startsWith('+')) {
                const potentialCode = countries.map(c => `+${c.phone}`)
                    .filter(c => initialValue.startsWith(c))
                    .sort((a, b) => b.length - a.length)[0];
                if (potentialCode) {
                    return potentialCode;
                }
            }
            return '+44';
        }

        function updateCodeSelectorUI(code) {
            const country = findCountryByCode(code) || countries.find(c => c.code === 'GB');
            if(country) {
                const icon = document.createElement('span');
                icon.className = 'iconify';
                icon.dataset.icon = `flag:${country.code.toLowerCase()}-4x3`;

                const strong = document.createElement('strong');
                strong.innerText = `+${country.phone}`;

                countryCodeSelector.innerHTML = '';
                countryCodeSelector.append(icon, strong);
            }
        }

        currentCode = getInitialCode();
        if (!phoneInput.value.trim()) {
            phoneInput.value = currentCode;
        }
        updateCodeSelectorUI(currentCode);

        let countryOptionsHTML = '';
        for (const country of countries) {
            countryOptionsHTML += `
            <li class="option">
                <div>
                    <span class="iconify" data-icon="flag:${country.code.toLowerCase()}-4x3"></span>
                    <span class="country-name">${country.name}</span>
                </div>
                <strong>+${country.phone}</strong>
            </li>`;
        }
        optionsList.innerHTML = countryOptionsHTML;
        options = optionsList.querySelectorAll('.option');

        function selectOption() {
            const newIcon = this.querySelector('.iconify').cloneNode(true);
            const newCodeStrong = this.querySelector('strong');
            const newCode = newCodeStrong.innerText;

            const currentNumber = phoneInput.value.substring(currentCode.length);

            countryCodeSelector.innerHTML = '';
            countryCodeSelector.append(newIcon, newCodeStrong.cloneNode(true));

            currentCode = newCode;
            phoneInput.value = newCode + currentNumber;

            phoneInput.dispatchEvent(new Event('input'));

            closeDropdown();
            phoneInput.focus();
            phoneInput.setSelectionRange(phoneInput.value.length, phoneInput.value.length);
        }

        function searchCountry() {
            const searchQuery = searchBox.value.toLowerCase();
            for (const option of options) {
                const isMatched = option.querySelector('.country-name').innerText.toLowerCase().includes(searchQuery);
                option.classList.toggle('hide', !isMatched);
            }
        }

        function toggleDropdown() {
            optionsContainer.classList.toggle('active');
            countryCodeSelector.classList.toggle('active');
            if (optionsContainer.classList.contains('active')) {
                searchBox.value = '';
                searchCountry();
                searchBox.focus();
            }
        }

        function closeDropdown() {
            optionsContainer.classList.remove('active');
            countryCodeSelector.classList.remove('active');
        }

        countryCodeSelector.addEventListener('click', toggleDropdown);
        options.forEach(option => option.addEventListener('click', selectOption));
        searchBox.addEventListener('input', searchCountry);

        phoneInput.addEventListener('keydown', (e) => {
            const cursorPosition = e.target.selectionStart;
            if ((e.key === 'Backspace' && cursorPosition <= currentCode.length) || (e.key === 'Delete' && cursorPosition < currentCode.length)) {
                e.preventDefault();
            }
        });

        // This is the key event listener for length validation
        phoneInput.addEventListener('input', (e) => {
            if (!e.target.value.startsWith(currentCode)) {
                e.target.value = currentCode;
            }

            const country = findCountryByCode(currentCode);
            if (country && country.numberLength) {
                const maxLength = currentCode.length + country.numberLength;
                if (e.target.value.length > maxLength) {
                    e.target.value = e.target.value.substring(0, maxLength);
                }
            }
        });

        phoneInput.addEventListener('click', (e) => {
            if (e.target.selectionStart < currentCode.length) {
                e.target.setSelectionRange(currentCode.length, currentCode.length);
            }
        });

        document.addEventListener('click', (e) => {
            if (!selectBox.contains(e.target)) {
                closeDropdown();
            }
        });
    });
</script>

@endsection
