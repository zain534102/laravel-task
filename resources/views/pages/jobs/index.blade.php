@extends('layout.app',['title'=>'welcome'])
@section('content')
    <div class="overflow-x-auto">
        <div class="min-w-screen min-h-screen bg-white flex justify-center bg-gray-100 font-sans overflow-hidden">
            <div class="w-full lg:w-5/6">
                <div class="flex items-center justify-end mt-4">
                    <a href="{{route('jobs.create')}}">
                        <button type="button"
                                class="flex items-center justify-center text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800">
                            <svg class="h-3.5 w-3.5 mr-2" fill="currentColor" viewBox="0 0 20 20"
                                 xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path clip-rule="evenodd" fill-rule="evenodd"
                                      d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"></path>
                            </svg>
                            Add Job
                        </button>
                    </a>
                </div>
                <div class="bg-gray-100 shadow-md rounded my-3">
                    <table class="min-w-max w-full table-auto" id="jobs-table">
                        <thead>
                        <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                            <th class="py-3 px-2 text-left">id</th>
                            <th class="py-3 px-6 text-left">Job Title</th>
                            <th class="py-3 px-12 text-center">Job Descriptions</th>
                            <th class="py-3 px-6 text-center">Actions</th>
                        </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm font-light" id="t-body">

                        </tbody>
                    </table>

                    <div class="flex flex-col items-end my-5" id="pagination">

                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@push('scripts')
    @vite(['resources/js/post.js'])
@endpush
