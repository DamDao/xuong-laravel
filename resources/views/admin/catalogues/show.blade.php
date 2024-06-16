@extends('admin.layouts.master')
@section('title')
    Chi Tiết Danh Mục
@endsection
@section('content')
    <table>
        <tr>
            <th>Trường</th>
            <th>Giá trị</th>
        </tr>
        @foreach ($model->toArray() as $key => $value)
            <tr>
                <th>{{ $key }}</th>
                <th>
                    @php
                        if ($key == 'cover') {
                            $url = \Storage::url($value);
                            echo "<img src=\"$url\" width=\"50px\" alt=\"\">";
                        } elseif (\Str::contains($key,'is_')) {
                            echo $value
                                ? '<span class="badge bg-primary">Yes</span>'
                                : '<span class="badge bg-danger">No</span>';
                        } else {
                            echo $value;
                        }
                    @endphp
                </th>
            </tr>
        @endforeach
    </table>
@endsection
