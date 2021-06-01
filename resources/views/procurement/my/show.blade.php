@extends('layouts.main')

@section('page-title', $procurement->name)

@section('main-content')
<div class="container">
    <a href="{{ Route('home') }}" class="btn btn-sm btn-danger mb-3">Back</a>
    <h3 class="mb-2 font-weight-bold">Current Status: <span class="badge badge-pill badge-primary p-2">{{ $procurement->status_name }}</span></h3>
    <div class="d-flex justify-content-between align-items-start mb-2">
        <p>Last Update: @php echo date('d F Y - H:i:s', strtotime($procurement->updated_at)) @endphp</p>
        @if ($role == 'Staf' And $unit->name == 'Fungsi Pengadaan Barang dan Jasa' Or ($procurement->applicant == Auth::user()->id And $procurement->editable))
            <a href="{{ Route('edit-procurement', ['id' => $procurement->id]) }}" class="btn btn-warning font-weight-bold text-dark">Edit</a>
        @endif
    </div>

    {{-- Information --}}
    <div class="card shadow p-4 mb-4">                
        <div class="row g-3">
            <div class="col-md-6 mb-3">
                <label for="priority" class="form-label font-weight-bold">Prioritas</label>
                @if ($procurement->priority)
                    <input type="text" class="form-control-plaintext" id="priority" name="priority" value="{{ $priority[0]->name }}" required>
                @else
                    <br>
                    <p class="p-2 badge badge-pill badge-danger">Not Available</p>
                @endif
            </div>
            <div class="col-md-6 mb-3">
                <label for="pic" class="form-label font-weight-bold">PIC Pengadaan</label>
                @if ($procurement->pic)
                    <input type="text" class="form-control-plaintext" id="pic" name="pic" value="{{ $pic[0]->name }}" required>
                @else
                    <br>
                    <p class="p-2 badge badge-pill badge-danger">Not Available</p>
                @endif
            </div>
            <div class="col-md-6 mb-3">
                <label for="ref" class="form-label font-weight-bold">Referensi</label>
                <input type="text" class="form-control-plaintext" id="ref" name="ref" placeholder="000/---/MEMO/---/yyyy" value="{{ $procurement->ref }}" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="name" class="form-label font-weight-bold">Nama Pengadaan</label>
                <input type="text" class="form-control-plaintext" id="name" name="name" value="{{ $procurement->name }}" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="value" class="form-label font-weight-bold">OE</label>
                <input type="text" class="form-control-plaintext" id="value" name="value" value="@php echo 'Rp' . number_format($procurement->value, 2, ',', '.'); @endphp" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="date" class="form-label font-weight-bold">Tanggal Pengajuan</label>
                <input type="text" class="form-control-plaintext" id="date" name="date" value="@php echo date('d F Y - H:i:s', strtotime($procurement->created_at)) @endphp" required readonly>
            </div>
            <div class="col-md-6 mb-3">
                <label for="mechanism" class="form-label font-weight-bold">Mekanisme</label>
                <input type="text" class="form-control-plaintext" id="mechanism" name="mechanism" value="{{ $procurement->mech_name }}" required readonly>
            </div>
            <div class="col-md-6 mb-3">
                <label for="category" class="form-label font-weight-bold">Kategori</label>
                @if ($procurement->category)
                    <input type="text" class="form-control-plaintext" id="category" name="category" value="{{ $category[0]->name }}" required readonly>
                @else
                    <br>
                    <p class="p-2 badge badge-pill badge-danger">Not Available</p>
                @endif
            </div>
            <div class="col-md-6 mb-3">
                <label for="tor" class="form-label font-weight-bold">ToR</label>
                @foreach ($documents as $doc)
                    @if ($doc->type == 'tor')
                        <div class="d-flex justify-content-between align-items-baseline">
                            <a href="{{ Route('view-document', ['id' => $doc->id]) }}" target="_blank" id="tor">{{ $doc->name }}</a>
                            <a class="btn btn-sm btn-primary" href="{{ Route('view-document', ['id' => $doc->id]) }}" target="_blank">Download</a>
                        </div>                        
                    @else
                        <br>
                        <p class="p-2 badge badge-pill badge-danger" id="tor">Not Available</p>                        
                    @endif
                @endforeach
            </div>
            <div class="col-md-6 mb-3">
                <label for="spec" class="form-label font-weight-bold">Specs</label>
                @foreach ($documents as $doc)
                    @if ($doc->type == 'spec')
                        <div class="d-flex justify-content-between align-items-start">
                            <a href="{{ Route('view-document', ['id' => $doc->id]) }}" target="_blank" id="spec">{{ $doc->name }}</a>
                            <a class="btn btn-sm btn-primary" href="{{ Route('view-document', ['id' => $doc->id]) }}" target="_blank">Download</a>
                        </div>
                    @else
                        <br>
                        <p class="p-2 badge badge-pill badge-danger" id="spec">Not Available</p>
                    @endif
                @endforeach                    
            </div>
            <div class="col-md-6 mb-3">
                <label for="bapp" class="form-label font-weight-bold">BAPP - Berita Acara Penjunjukan Pemenang</label>
                @foreach ($documents as $doc)
                    @if ($doc->type == 'bapp')
                        <div class="col-md-6 mb-3">
                            <div class="d-flex justify-content-between">
                                <a href="{{ Route('view-document', ['id' => $doc->id]) }}" target="_blank" id="bapp">{{ $doc->name }}</a>
                                <a class="btn btn-sm btn-primary" href="{{ Route('view-document', ['id' => $doc->id]) }}" target="_blank">Download</a>
                            </div>
                        </div>
                    @else
                        <br>
                        <p class="p-2 badge badge-pill badge-danger" id="bapp">Not Available</p>
                    @endif
                @endforeach
            </div>
            <div class="col-md-6 mb-3">
                <label for="bast" class="form-label font-weight-bold">BAST - Berita Acara Serah Terima</label>
                @foreach ($documents as $doc)
                    @if ($doc->type == 'bast')
                        <div class="col-md-6 mb-3">
                            <div class="d-flex justify-content-between">
                                <a href="{{ Route('view-document', ['id' => $doc->id]) }}" target="_blank" id="bast">{{ $doc->name }}</a>
                                <a class="btn btn-sm btn-primary" href="{{ Route('view-document', ['id' => $doc->id]) }}" target="_blank">Download</a>
                            </div>
                        </div>
                    @else
                        <br>
                        <p class="p-2 badge badge-pill badge-danger" id="bast">Not Available</p>
                    @endif
                @endforeach
            </div>
        </div>
        @if ($procurement->approver == Auth::user()->role)
            <div class="d-flex justify-content-center">
                <form action="{{ Route('update-procurement', ['id' => $procurement->id]) }}" method="post">
                    @csrf
                    @if ($role == 'Manajer' And $unit->name == 'Fungsi Pengadaan Barang dan Jasa')
                        @php
                            $pic_list = \App\Models\User::join('units', 'units.id', '=', 'users.unit')
                                            ->select('users.id', 'users.name')
                                            ->where('units.name', 'LIKE', '%Pengadaan%')
                                            ->orderBy('users.role', 'ASC')
                                            ->get()
                        @endphp
                        <div class="form-group row align-items-center">
                            <label class="col-md-auto" for="pic">PIC:</label>
                            <select class="form-control col mb-3" name="pic" id="pic" required>
                                <option></option>
                                @foreach ($pic_list as $pic)
                                    <option value="{{ $pic->id }}">{{ $pic->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="row justify-content-center">
                            <button class="btn btn-primary" name="assign">Kirim ke Staf</button>
                        </div>
                    @elseif (($role == 'Wakil Rektor' And $unit->name == 'Bidang Keuangan dan Sumber Daya Organisasi Universitas Pertamina') Or ($role == 'Direktur' And $origin == 'Fungsi Pengelola Fasilitas Universitas'))
                        <button class="btn btn-primary" name="approve">Disposisi</button>
                    @elseif ($role != 'Staf' And $unit->name != 'Fungsi Pengadaan Barang dan Jasa')
                        <button class="btn btn-primary" name="approve">Approve</button>
                    @endif
                </form>
            </div>
        @endif
    </div>

    <nav class="nav nav-pills nav-justified mb-2">
        <a id="item-tab" class="tab-active nav-link active" href="#">Daftar barang yang diajukan</a>
        <a id="bidder-tab" class="nav-link" href="#">Bidder List</a>
        <a id="log-tab" class="nav-link" href="#">Logs</a>
    </nav>

    {{-- Unit List --}}
    <div id="item-content" class="content-active card shadow p-4 mb-4">
        <table class="table table-hover table-bordered text-center">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Barang</th>
                    <th style="width: 20%;">Harga Satuan (oe)</th>
                    <th style="white-space: nowrap; width: 1%;">Jumlah</th>
                    <th style="width: 20%;">Total Harga</th>
                    <th style="white-space: nowrap; width: 1%;">#</th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0 @endphp
                @foreach ($items as $item)
                    @php $total += $item->oe * $item->qty @endphp
                    <tr>
                        <th style="white-space: nowrap; width: 1%;">{{ str_pad($loop->iteration, strlen(count($items)), 0, STR_PAD_LEFT) }}</th>
                        <td class="text-left">
                            <p class="mb-2">{{ $item->name }}</p>
                            <div class="more-info" style="display: none;">
                                <p>Spesifikasi: <br>{{ $item->specs }}</p>
                                <div class="row">
                                    <div class="col">
                                        <p class="font-weight-bold">Harga Penawaran:</p>
                                        <div class="d-flex justify-content-between">
                                            <span>Rp</span>
                                            <span>{{ number_format($item->quotation_price, 2, ',', '.') }}</span>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <p class="font-weight-bold">Harga Final:</p>
                                        <div class="d-flex justify-content-between">
                                            <span>Rp</span>
                                            <span>{{ number_format($item->nego_price, 2, ',', '.') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex justify-content-between">
                                <span>Rp</span>
                                <span>{{ number_format($item->oe, 2, ',', '.') }}</span>
                            </div>
                        </td>
                        <td class="text-center">{{ $item->qty }}</td>
                        <td>
                            <div class="d-flex justify-content-between">
                                <span>Rp</span>
                                <span>{{ number_format($item->qty * $item->oe, 2, ',', '.') }}</span>
                            </div>
                        </td>
                        <td>
                            <a href="" class="more-info-btn"><i class="fas fa-fw fa-caret-square-down"></i></a>
                        </td>
                    </tr>
                @endforeach
                    <tr>
                        <td colspan="2" class="text-right font-weight-bold">Total (OE)</td>
                        <td colspan="3" class="font-weight-bold">
                            <div class="d-flex justify-content-between">
                                <span>Rp</span>
                                <span>{{ number_format($total, 2, ',', '.') }}</span>
                            </div>
                        </td>
                    </tr>
            </tbody>
        </table>
    </div>

    {{-- Bidder List --}}
    <div id="bidder-content" class="card shadow p-4 mb-4" style="display: none;">
        @foreach ($items as $item)
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h3 class="font-weight-bold" style="font-size: 15pt;">{{ $item->name }}</h3>
                @if ($item->category)
                    <a href="" class="add-vendor-btn btn btn-sm btn-primary">Daftarkan Vendor</a>
                @else
                    <form action="{{ Route('add-item-category', ['id' => $item->id]) }}" method="post">
                        @csrf
                        <div class="d-flex justify-content-around align-items-center">
                            <select name="category" class="add-item-category form-control mx-2" required>
                                <option value="">Pilih Kategori</option>
                                @foreach ($item_categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            <select name="sub_category" class="add-item-sub-category form-control mx-2" required>
                                <option value="">Pilih Sub Kategori</option>
                            </select>
                            <button class="btn btn-primary btn-sm">Submit</button>
                        </div>
                    </form>
                @endif
            </div>
            @if ($item->category)
                <div class="add-vendor" style="display: none;">
                    <form action="{{ Route('add-item-vendor') }}" method="POST" class="add-vendor-form">
                        @csrf
                        <div class="d-flex justify-content-start align-items-center mb-3"> 
                            <input type="hidden" name="procurement_id" value="{{ $procurement->id }}">
                            <input type="hidden" name="item_id" value="{{ $item->id }}">
                            <select name="vendor" id="vendor" class="form-control mr-3" style="width: 30%" required>
                                <option value="" selected>Pilih vendor yang akan ditambahkan</option>
                                @foreach ($vendors as $vendor)
                                    @if ($vendor->category == $item->category And $vendor->sub_category == $item->sub_category)
                                        <option value="{{ $vendor->id }}">{{ $vendor->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                            <button name="add-vendor" class="btn btn-sm btn-primary mr-2">Add Vendor</button>
                            <a href="" class="add-vendor-close btn btn-sm btn-danger">&times;</a>
                        </div>
                    </form>
                </div>
            @endif
            <table class="{{ "quotation-$item->id" }} table table-hover table-bordered text-center">
                <thead>
                    <tr>
                        <th style="white-space: nowrap; width: 1%;">#</th>
                        <th>Nama Vendor</th>
                        <th class="w-25">Berkas</th>
                        @if ($role == 'Staf')
                            <th class="w-25">Action</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @php $counter = 1 @endphp
                    @foreach ($quotations as $quotation)
                        @if ($quotation->item == $item->id)
                            <tr>
                                <th style="{{ $quotation->winner ? "background-color: #a6ffad" : "" }}">{{ $counter }}</th>
                                <td>{{ $quotation->vendor_name }}</td>
                                <td class="text-left">
                                    @php $doc_count = 0 @endphp
                                    @foreach ($vendor_docs as $doc)
                                        @if ($doc->item == $item->id)
                                            @php $doc_count += 1 @endphp
                                        @endif
                                    @endforeach
                                    @if ($doc_count)
                                        <div class="d-flex justify-content-center">
                                            {{-- Show "SPPH" document badge --}}
                                            @foreach ($vendor_docs as $doc)
                                                @if ($doc->vendor == $quotation->vendor And $doc->item == $quotation->item)
                                                    @if ($doc->type == 'spph')
                                                        <span class="badge badge-pill badge-primary mx-2">SPPH</span>
                                                    @endif
                                                @endif
                                            @endforeach

                                            {{-- Show "Quotation" document badge --}}
                                            @if (strlen($quotation->name))
                                                <span class="badge badge-pill badge-primary mx-2">Penawaran</span>
                                            @endif

                                            {{-- Show "PO" document badge --}}
                                            @foreach ($vendor_docs as $doc)
                                                @if ($doc->vendor == $quotation->vendor And $doc->item == $quotation->item)
                                                    @if ($doc->type == 'po')
                                                        <span class="badge badge-pill badge-primary mx-2">PO</span>
                                                    @endif
                                                @endif
                                            @endforeach
                                        </div>
                                        <div class="more-document" style="display: none">
                                            <hr>
                                            {{-- Show "SPPH" document --}}
                                            @foreach ($vendor_docs as $doc)
                                                @if ($doc->vendor == $quotation->vendor And $doc->item == $quotation->item)
                                                    @if ($doc->type == 'spph')
                                                        SPPH: <br>
                                                        <a href="{{ Route('view-document-vendor', ['id' => $doc->id, 'table' => 'vendor_docs']) }}" target="_blank">{{ $doc->name }}</a>
                                                        <br><br>
                                                    @endif
                                                @endif
                                            @endforeach

                                            {{-- Show "Quotation" document --}}
                                            @if (strlen($quotation->name))
                                            Penawaran: <br>
                                            <a href="{{ Route('view-document-vendor', ['id' => $quotation->id, 'table' => 'vendor_docs']) }}" target="_blank">{{ $quotation->name }}</a>
                                            <br><br>
                                            @endif

                                            {{-- Show "PO" document --}}
                                            @foreach ($vendor_docs as $doc)
                                                @if ($doc->vendor == $quotation->vendor And $doc->item == $quotation->item)
                                                    @if ($doc->type == 'po')
                                                        PO: <br>
                                                        <a href="{{ Route('view-document-vendor', ['id' => $doc->id, 'table' => 'vendor_docs']) }}" target="_blank">{{ $doc->name }}</a>
                                                    @endif
                                                @endif
                                            @endforeach
                                        </div>
                                    @else
                                        <div class="d-flex justify-content-center">
                                            <span class="badge badge-danger">Tidak ada berkas</span>
                                        </div>
                                    @endif
                                </td>
                                @if ($role == 'Staf')
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <a href="" class="more-action-btn btn btn-sm btn-primary mx-2">Detail</a>
                                            {{-- Find any document related to the vendor --}}
                                            @foreach ($vendor_docs as $doc)
                                                @php $documentExist = false @endphp
                                                @if ($doc->item == $item->id And $doc->vendor == $quotation->vendor) 
                                                    @php $documentExist = true; break; @endphp
                                                @endif
                                            @endforeach
                                            {{-- If no document exist, then show button to delete vendor --}}
                                            @if (!$documentExist)
                                                <form action="{{ Route('delete-item-vendor') }}" method="post" class="mx-2">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{ $quotation->id }}">
                                                    <input type="hidden" name="procurement_id" value="{{ $procurement->id }}">
                                                    <button class="btn btn-sm btn-danger">Hapus Vendor</button>
                                                </form>
                                            @endif
                                        </div>
                                        <div class="document-action mt-2" style="display: none">
                                            <div class="d-flex justify-content-around">
                                                @php $spphExist = false; $poExist = false @endphp
                                                @if (count($vendor_docs))
                                                    @foreach ($vendor_docs as $doc)
                                                        @if ($doc->vendor == $quotation->vendor And $doc->item == $quotation->item)
                                                            @if ($doc->type == 'spph') @php $spphExist = true @endphp @endif

                                                            @if ($doc->type == 'po') @php $poExist = true @endphp @endif
                                                        @endif
                                                    @endforeach
                                                @endif

                                                {{-- Count vendor for each item and look for the winner --}}
                                                @php $quotation_counter = 0; $winner_available = false; @endphp
                                                @foreach ($quotations as $quotation)
                                                    @if ($quotation->item == $item->id) @php $quotation_counter += 1 @endphp @endif

                                                    @if ($quotation->winner) @php $winner_available = true @endphp @endif
                                                @endforeach

                                                {{-- If SPPH not exist, then show button to upload SPPH --}}
                                                @if (!$spphExist)
                                                    {{-- If vendor is below minimun, do not allow to create SPPH --}}
                                                    @if ($quotation_counter >= 5)
                                                        <a href="{{ Route('generate-spph-form', ['proc_id' => $procurement->id, 'vendor_id' => $quotation->vendor]) }}" class="btn btn-sm btn-primary">Generate SPPH</a>
                                                        <a href="" class="upload-spph btn btn-sm btn-success">Upload SPPH</a>                                                        
                                                    @else
                                                        <span class="badge badge-danger">Jumlah vendor masih di bawah minimum (5)</span>                                                        
                                                    @endif
                                                @endif

                                                {{-- If SPPH exist and no quoation uploaded, then show button to upload quotation --}}
                                                @if ($spphExist And !strlen($quotation->name))
                                                    <a href="" class="upload-quotation btn btn-sm btn-primary">Unggah Penawaran</a>
                                                @endif
 
                                                {{-- If winner is not set --}}
                                                @if (!$winner_available)
                                                    {{-- If quotation is available, then show button to choose the winner --}}
                                                    @if ($quotation->doc !== NULL)
                                                        <form action="{{ Route('set-winner') }}" method="post">
                                                            @csrf
                                                            <input type="hidden" name="id" value="{{ $quotation->id }}">
                                                            <button class="btn btn-sm btn-success">Pemenang Tender</button>
                                                        </form>
                                                    @endif
                                                @endif

                                                {{-- If PO not exist and quotation declared as winner --}}
                                                @if (!$poExist And $quotation->winner)
                                                    <a href="{{ Route('generate-spph-form', ['proc_id' => $procurement->id, 'vendor_id' => $quotation->vendor]) }}" class="btn btn-sm btn-primary">Generate PO</a>
                                                    <a href="" class="upload-spph btn btn-sm btn-success">Upload PO</a>
                                                @endif
                                            </div>
                                            {{-- Form - Upload SPPH --}}
                                            <form action="{{ Route('upload', ['name' => 'spph']) }}" method="post" enctype="multipart/form-data" class="spph-form mt-2" style="display: none">
                                                @csrf
                                                <input type="hidden" name="procurement" value="{{ $procurement->id }}">
                                                <input type="hidden" name="vendor" value="{{ $quotation->vendor }}">
                                                <input type="hidden" name="item" value="{{ $item->id }}">
                                                <input type="text" id="ref" name="ref" class="form-control mb-2" placeholder="Nomor Surat" required>
                                                <input type="file" name="spph" id="spph" class="form-control-file mb-2" accept="application/pdf" required>
                                                <button class="btn btn-sm btn-primary">Upload</button>
                                            </form>

                                            {{-- Form - Upload Quotation --}}
                                            <form action="{{ Route('upload', ['name' => 'quotation']) }}" method="post" enctype="multipart/form-data" class="quotation-form mt-2" style="display: none">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $quotation->id }}">
                                                <input type="text" id="ref" name="ref" class="form-control mb-2" placeholder="Nomor Surat" required>
                                                <input type="file" name="quotation" id="quotation" class="form-control-file mb-2" accept="application/pdf" required>
                                                <button class="btn btn-sm btn-primary">Upload</button>
                                            </form>
                                        </div>
                                    </td>
                                @endif
                            </tr>
                            @php $counter += 1 @endphp
                        @endif
                    @endforeach
                </tbody>
            </table>
            <hr>
        @endforeach
    </div>

    {{-- Logs --}}
    <div id="log-content" class="card shadow p-4 mb-4" style="display: none;">
        <table>
            <tbody>                
                @foreach ($log_dates as $index => $date)
                    @if ($index < 1 Or ($index > 1 And date('Y-m-d', strtotime($date[$index])) != date('Y-m-d', strtotime($date[$index-1]))))
                        <tr>
                            <td class="text-center pb-2">
                                <span class="p-2 badge badge-pill badge-primary">
                                    {{ date('d F Y', strtotime($date->created_at)) }}
                                </span>
                            </td>
                        </tr>
                    @endif
                    @foreach ($logs as $log)
                        @if ($log->created_at == $date->created_at)
                            <tr>
                                <td class="text-center align-baseline pb-2">{{ date('H:i:s', strtotime($log->created_at)) }}</td>
                                <td class="pb-2">
                                    {{ $log->name }}
                                    <br>
                                    {{ $log->message }}
                                </td>
                            </tr>
                        @endif
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('js')
<script src="{{ asset("js/my-procurement-show.js") }}"></script>
@endpush