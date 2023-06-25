@extends('layout.app',['title'=>'Show'])
@section('content')
    <section class="bg-white dark:bg-gray-900">
        <div class="py-8 px-4 mx-auto max-w-screen-xl lg:py-16 lg:px-6">
            <article
                class="p-6 bg-white rounded-lg border border-gray-200 shadow-md dark:bg-gray-800 dark:border-gray-700">
                <h2 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white" id="job-title"></h2>
                <p class="mb-5 font-light text-gray-500 dark:text-gray-400" id="job-description"></p>
                <p class="mb-5 font-light text-gray-500 dark:text-gray-400" id="no-data" style="display: none">Sorry there is no data for this entry</p>
            </article>
        </div>
    </section>
@stop
@push('scripts')
    @vite(['resources/js/show-job.js'])
@endpush
