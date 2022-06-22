@extends('layouts.app')


@section('content')
    <div class="container-lg">
        <h1 class="mt-5 mb-3">Сайты</h1>
        <div class="table-responsive">
            <table class="table table-bordered table-hover text-nowrap">
                <tbody>
                <tr>
                    <th>ID</th>
                    <th>Имя</th>
                    <th>Последняя проверка</th>
                    <th>Код ответа</th>
                </tr>
                @if ($urls)
                    @foreach($urls as $url)
                        <tr>
                            <td>{{$url->id}}</td>
                            <td>
                                <a href="{{route('urls.show', $url->id)}}">{{ $url->name }}</a>
                            </td>
                            <td>{{ $lastChecks[$url->id]->created_at ?? ''}}</td>
                            <td>{{ $lastChecks[$url->id]->status_code ?? '' }}</td>
                        </tr>
                    @endforeach
                @endif

                </tbody>
            </table>

            {{ $urls->links('pagination::bootstrap-5') }}
        </div>
    </div>
@endsection
