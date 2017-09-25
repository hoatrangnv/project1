<?php use App\News; ?>
@extends('adminlte::layouts.member')

@section('contentheader_title')
    {{ trans('adminlte_lang::news.manage') }}
@endsection

@section('main-content')
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
            <tr class="heading">
                <th>Number</th>
                <th>Title</th>
                <th>Category</th>
                <th>Short Description</th>
            </tr>
            </thead>
            <tbody>
                @foreach ($news as $new)
                    <tr>
                        <td>{{ ++$i }}</td>
                        <td>{{ $new->title }}</td>
                        <td>
                            @if ($new->category_id  == News::CRYPTO )
                                Crypto
                            @elseif ( $new->category_id  == News::BLOCKCHAIN )
                                Blockchain
                            @elseif ( $new->category_id  == News::CLP)
                                CLP
                            @else ( $new->category_id  == News::P2P )
                                P2P
                            @endif
                        </td>
                        <td>{!! $new->short_desc !!}</td>
                        <td><a href="/news/edit/{{ $new->id }}" class="btn btn-default glyphicon glyphicon-edit">Edit</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {!! $news->links('pagination') !!}
    </div>
@endsection