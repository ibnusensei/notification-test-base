<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if (Auth::user()->roles('admin'))    
                    @forelse ($notifications as $notification)
                        <div class="py-3 px-4 bg-sky-100 rounded-md my-2 flex flex-wrap justify-between border border-sky-200 alert" role="alert">
                            <p class="text-slate-700 text-sm">
                                <span class="text-slate-500">[{{ $notification->created_at }}] </span> 
                                <span class="font-bold">{{ $notification->data['name'] }}</span>
                                <span class="font-thin">({{ $notification->data['email'] }})</span>
                                has just registered
                            </p>
                            <a class="text-sm hover:text-sky-800 mark-as-read" href="#" data-id="{{ $notification->id }}">Mark as read</a>
                        </div>

                        @if ($loop->last)
                            <a href="#" id="mark-all" class="text-sm">
                                Mark all as read
                            </a>
                        @endif
                    @empty
                        There are no new notification
                    @endforelse
                    @else
                        You're logged in!
                    @endif
                </div>
            </div>
        </div>
    </div>

    @push('script')
        @if (Auth::user()->roles('admin'))
            <script>
                function sendMarkRequest(id = null) {
                    return $.ajax({
                        url: "/admin/markNotification",
                        method: "POST",
                        data: {
                            '_token': "{{ csrf_token() }}",
                            'id': id
                        }
                    });
                };

                $(document).ready(function(){
                    $('.mark-as-read').click(function() {
                        console.log($(this).data('id'));
                        let request = sendMarkRequest($(this).data('id'));
                        request.done(() => {
                            $(this).parents('div.alert').remove();
                        });
                    });

                    $('#mark-all').click(function(){
                        let request = sendMarkRequest();

                        request.done(() => {
                            $('div.alert').remove();
                            $('#mark-all').remove();
                        })
                    })
                });
            </script>
            
        @endif
    @endpush
</x-admin-layout>
