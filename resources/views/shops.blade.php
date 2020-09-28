@extends('layouts.app')

@section('content')


<div class="container">
    <h1>Seller Shops</h1>
        <table>
            <tr>
                <td>Toko Terverivikasi</td>
                <td> : </td>
                <td> {{$count}} </td>
            </tr>
        </table><br><br><hr>
        <div class="table-responsive text-nowrap">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID.</th>
                        <th>Nama Toko</th>
                        <th>Nama Pemilik</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $nomor=1; ?>
                    @foreach ($shops as $shop)
                    <tr>
                        <td>{{$shop->id}}</td>
                        <td>{{$shop->shop}}</td>
                        <td>{{$shop->user}}</td>
                        <?php $nomor++; ?>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
</div>

<div class="container">
    <h1>Driver Shop</h1>
    <table>
        <tr>
            <td>Toko Dengan Driver</td>
            <td> : </td>
            <td> {{$counts}} </td>
        </tr>
    </table>
    <div class="table-responsive text-nowrap">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No. </th>
                    <th>Nama Toko</th>
                    <th>Driver</th>
                </tr>
            </thead>
            <tbody>
                <?php $nomor=1; ?>
                @foreach ($drivers as $d)
                    <tr>
                        <td><?php echo $nomor;?></td>
                        <td>{{$d->shop}}</td>
                        <td>{{$d->driver}}</td>
                        <?php $nomor++; ?>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection