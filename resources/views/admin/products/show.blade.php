@extends('admin.layouts.app')

@section('title', 'View Product')

@section('content')
    <div class="ml-admin-page-head">
        <div>
            <h1>{{ $product->name }}</h1>
            <p>View product information, colour variants and stock.</p>
        </div>

        <div class="d-flex gap-2 flex-wrap">
            <a href="{{ route('admin.products.edit', $product) }}" class="ml-admin-add-btn">
                <i class="bi bi-pencil"></i>
                Edit Product
            </a>

            <a href="{{ route('admin.products.index') }}" class="ml-admin-add-btn">
                <i class="bi bi-arrow-left"></i>
                Back to Products
            </a>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-xl-4">
            <div class="ml-admin-card">
                @if ($product->featured_image)
                    <img src="{{ asset('storage/' . $product->featured_image) }}"
                        alt="{{ $product->image_alt ?: $product->name }}"
                        style="width:100%;max-height:380px;object-fit:contain;border-radius:18px;background:#f8fbf7;padding:18px;">
                @else
                    <div class="text-center py-5 text-muted">
                        <i class="bi bi-image" style="font-size:48px;"></i>
                        <p class="mb-0 mt-2">No featured image</p>
                    </div>
                @endif
            </div>
        </div>

        <div class="col-xl-8">
            <div class="ml-admin-card">
                <div class="row g-3">
                    <div class="col-md-6"><strong>SKU:</strong> {{ $product->sku ?: 'Not added' }}</div>
                    <div class="col-md-6"><strong>Category:</strong> {{ $product->category ?: 'Not added' }}</div>
                    <div class="col-md-6"><strong>Brand:</strong> {{ $product->brand ?: 'Not added' }}</div>
                    <div class="col-md-6"><strong>Total Stock:</strong> {{ $product->stock_quantity }} PCS</div>
                    <div class="col-md-6"><strong>Status:</strong> {{ ucfirst(str_replace('_', ' ', $product->stock_status)) }}</div>
                    <div class="col-md-6"><strong>Product Status:</strong> {{ ucfirst($product->status) }}</div>
                </div>

                <hr>

                <h4 class="mb-3">Colour Variants</h4>

                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>Colour</th>
                                <th>SKU</th>
                                <th>Quantity</th>
                                <th>Price Adjustment</th>
                                <th>Status</th>
                                <th>Image</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($product->variants as $variant)
                                <tr>
                                    <td>
                                        <span style="display:inline-block;width:18px;height:18px;border-radius:50%;background:{{ $variant->colour_code ?: '#31a050' }};border:1px solid #ddd;vertical-align:middle;margin-right:8px;"></span>
                                        {{ $variant->colour_name }}
                                    </td>
                                    <td>{{ $variant->sku }}</td>
                                    <td>{{ $variant->quantity }} PCS</td>
                                    <td>A${{ number_format($variant->price_adjustment, 2) }}</td>
                                    <td>{{ ucfirst($variant->status) }}</td>
                                    <td>
                                        @if ($variant->image)
                                            <img src="{{ asset('storage/' . $variant->image) }}"
                                                alt="{{ $variant->colour_name }}"
                                                style="width:54px;height:54px;object-fit:contain;border-radius:10px;border:1px solid #e5e7eb;padding:5px;">
                                        @else
                                            —
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">
                                        No colour variants added.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
