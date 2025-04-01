@extends('layouts.master')

@section('styles')
    <style>
        .center-container {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .donation-container {
            display: flex;
            justify-content: center;
            align-items: start;
            gap: 40px;
            flex-wrap: wrap;
        }

        .donation-text,
        .donation-form {
            max-width: 500px;
            width: 100%;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <div>
                <p class="fw-semibold fs-18 mb-0">Welcome back, {{ Auth::user()->name }}!</p>
            </div>
        </div>
        <h3 class="text-center">{{ env('APP_NAME') }}</h3>
        <div class="container mt-5 donation-container" style="font-weight: 600">
            <!-- Left Side: Donation Message -->
            <div class="donation-text">
                <div class="card p-4" style="height: 470px">
                    <h5>Dear {{ Auth::user()->name }},</h5>
                    <p>We are deeply grateful for your donation to our church. Your kindness
                        supports our
                        mission to serve
                        the community and share God's love. Your generosity enables us to continue important initiatives
                        like [briefly mention specific programs or causes].</p>
                    <p>Thank you for believing in our mission and for being a part of making a lasting impact. May God bless
                        you for your kindness and faithfulness.</p>
                    <p>With gratitude and blessings,</p>
                </div>
            </div>

            <!-- Right Side: Donation Form -->
            <div class="donation-form">
                <div class="card text-center">
                    <div class="card-header bg-primary text-white">
                        <h5>Support Our Cause</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('donar.donate') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="church" class="form-label">Select Church</label>
                                <select class="form-select" name="church_id" id="church" required
                                    onchange="updateProducts()">
                                    @foreach ($churches as $church)
                                        <option value="{{ $church->id }}">{{ $church->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="product" class="form-label">Select Product/Service</label>
                                <select class="form-select" name="product_id" id="product" required>
                                    <option value="">Select a church first</option>
                                </select>
                            </div>
                            <label class="form-check-label mb-2">Enter custom amount</label>
                            <div class="btn-group mb-3" role="group">
                                <button type="button" class="btn btn-outline-primary" onclick="setAmount(5)">$5</button>
                                <button type="button" class="btn btn-outline-primary" onclick="setAmount(10)">$10</button>
                                <button type="button" class="btn btn-outline-primary" onclick="setAmount(20)">$20</button>
                                <button type="button" class="btn btn-outline-primary" onclick="setAmount(50)">$50</button>
                                <button type="button" class="btn btn-outline-primary"
                                    onclick="setAmount(100)">$100</button>
                                <button type="button" class="btn btn-outline-primary"
                                    onclick="setAmount(500)">$500</button>
                                <button type="button" class="btn btn-outline-primary"
                                    onclick="setAmount(1000)">$1000</button>
                            </div>
                            <div class="mb-3 form-check d-flex align-items-center gap-2">
                                <input class="form-check-input" type="checkbox" id="enableCustomAmount"
                                    onclick="toggleInput()">
                                <label class="form-check-label" for="enableCustomAmount">Enter custom amount</label>
                            </div>
                            <div class="mb-3">
                                <input type="number" name="amount" id="customAmount" class="form-control"
                                    placeholder="Enter custom amount" min="1" readonly required>
                            </div>
                            <button type="submit" class="btn btn-success mt-4">Donate Now</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        const productsByChurch = @json($allProducts);

        function updateProducts() {
            let churchId = document.getElementById('church').value;
            let productSelect = document.getElementById('product');
            productSelect.innerHTML = '';

            if (churchId && productsByChurch[churchId]) {
                productsByChurch[churchId].forEach((product, index) => {
                    let option = document.createElement('option');
                    option.value = product.id;
                    option.textContent = product.name;
                    if (index === 0) option.selected = true;
                    productSelect.appendChild(option);
                });
            } else {
                let option = document.createElement('option');
                option.value = '';
                option.textContent = 'No products available';
                productSelect.appendChild(option);
            }
        }

        document.addEventListener("DOMContentLoaded", function() {
            updateProducts();
        });

        function setAmount(amount) {
            let input = document.getElementById('customAmount');
            input.value = amount;
            input.readOnly = false;
        }

        function toggleInput() {
            let input = document.getElementById('customAmount');
            let checkbox = document.getElementById('enableCustomAmount');

            if (checkbox.checked) {
                input.value = '';
                input.readOnly = false;
            } else {
                input.readOnly = true;
            }
        }
    </script>
@endsection
