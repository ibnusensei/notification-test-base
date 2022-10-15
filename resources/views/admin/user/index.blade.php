<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if (Auth::user()->roles('admin'))
                        <div id="new-user"></div>
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

                function markAsRead(id) {
                    console.log(id);
                    let request = sendMarkRequest(id);
                    request.done(() => {
                        // $('#mark-'+id).remove();
                        getNewUsers();    
                    });
                };

                function markAll() {
                    let request = sendMarkRequest();
                    request.done(() => {
                        $("#new-user").html('No New User Found');
                    });
                };

                function sendMarkRequest(id = null) {
                    return $.ajax({
                        url: "/admin/markNotification/",
                        method: "POST",
                        data: {
                            '_token': "{{ csrf_token() }}",
                            id
                        }
                    });
                };

                $(document).ready(function() {


                    getNewUsers();
                    var channel = pusher.subscribe('my-channel');
                    channel.bind('register-user', function(data) {
                        if (data) {
                            getNewUsers();
                        }
                    });

                });

                function getNewUsers() {
                    $.ajax({
                        url: "/admin/get-user/",
                        type: "POST",
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        cache: false,
                        async: true, 
                        beforeSend: function(){
                            $("#new-user").html('<div class="flex flex-wrap justify-center mx-auto"><x-loader /></div>');
                        },
                        success: function(result) {
                            $("#new-user").html(result);
                        },
                    });
                };

                
            </script>
        @endif
    @endpush
</x-admin-layout>
