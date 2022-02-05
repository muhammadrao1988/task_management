@extends('layouts.app')

@section('content')
    <div class="md:mx-4 relative overflow-hidden">
        <main class="h-full flex flex-col overflow-auto">
            <task-detail :initial-data="{{ $data }}"></task-detail>
        </main>
    </div>
@endsection