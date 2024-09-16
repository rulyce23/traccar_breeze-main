<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Toggle</title>
    <style>
        .clickable {
            cursor: pointer;
            color: #007bff;
            text-decoration: underline;
        }

        .container {
            max-width: 730px;
            margin-top: 25px;
        }

        .input-search {
            width: calc(100% - 85px); /* Adjust width to fit the button */
            border-radius: 24px;
            border: 1px solid #ccc;
            padding: 8px 13px;
            font-size: 12px;
            box-sizing: border-box;
        }

        .hidden {
            display: none;
        }

        .highlighted {
            background-color: yellow;
            transition: background-color 0.5s ease;
        }

        .btn-search {
            width: 75px;
            border-radius: 25px;
            border: 1px solid #007bff;
            background-color: #007bff;
            color: white;
            padding: 8px;
            margin-left: 5px;
            font-size: 12px;
            box-sizing: border-box;
        }

        .btn-search:hover {
            background-color: #0056b3;
            border-color: #004494;
        }

        .separator {
            border: 0;
            border-top: 1px solid #ddd;
            margin: 20px 0;
        }
    </style>
  
</head>
<body>
    @if (request()->is('dashboard'))
        <div class="min-h-[88vh] w-[275px] border-r border-gray-300 bg-white">
            <div style="background-image: linear-gradient(#F1F5FD, #E9F0FF); background-color: aliceblue; border-bottom: 1px solid #ddd" class="px-[15px] py-1">
                <p class="text-sm font-bold text-[#333333] leading-loose">My Account</p>
            </div>
            <div class="bg-white">
                <div class="py-[10px]">
                    <ul class="text-sm" id="myTab" data-tabs-toggle="#myTabContent" role="tablist">
                        <li role="presentation">
                            <button class="inline-block button-tab py-2 px-5 w-full text-start leading-[normal]" style="color: #666666" id="account-tab" data-tabs-target="#account" type="button" role="tab" aria-controls="account" aria-selected="true" autofocus>Account Details</button>
                        </li>
                        <li role="presentation">
                            <button class="inline-block button-tab py-2 px-5 w-full text-start leading-[normal]" style="color: #666666" id="messages-tab" data-tabs-target="#messages" type="button" role="tab" aria-controls="messages" aria-selected="false">Messages (0)</button>
                        </li>
                        <li role="presentation">
                            <button class="inline-block button-tab py-2 px-5 w-full text-start leading-[normal]" style="color: #666666" id="va-tab" data-tabs-target="#va" type="button" role="tab" aria-controls="va" aria-selected="false">Virtual Account</button>
                        </li>
                        <li role="presentation">
                            <a href="#" class="inline-block button-tab py-2 px-5 w-full text-start leading-[normal]" style="color: #666666">Report</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    @elseif(request()->is('monitor') || request()->is('device') || request()->is('account'))
        <div class="min-h-[88vh] w-[275px] border-r border-gray-300 bg-white">
            <div class="menu menu-visible" id="menu">
                <div style="background-color: white; border-bottom: 1px solid #ddd" class="px-[40px] py-1">
                    <p class="text-sm font-bold text-[#333333] leading-loose">
                        @if(request()->is('monitor'))
                            {{ $userName }} Stok 0 / Total {{ count($devices) }}
                        @elseif(request()->is('device'))
                            Account List
                        @elseif(request()->is('account'))
                            Account
                        @endif
                    </p>
                </div>
            </div>
            <div class="container">
                <form action="{{ route(request()->route()->getName()) }}" method="POST" class="form-inline" onsubmit="performSearch(event)">
                    @csrf
                    <input type="text" name="query" id="search-query1" value="{{ old('query', $query ?? '') }}" placeholder="Please enter the full customer name" class="input-search" autocomplete="off">
                    <button type="submit" class="btn-search">Search</button>
                </form>
                <div style="margin-left: 25px; margin-top: 20px;">
                    {{-- Display users based on account type --}}
                    @foreach($users as $account)
                        @if($account->attributes->account_type === 'Distributor')
                            <div class="user-container">
                                <span class="clickable" onclick="toggleVisibility('distributor-{{ $account->id }}')">
                                    <i class="fas fa-user" style="color:orange;"></i> {{ $account->name }} ( Device {{ $userDeviceCounts[$account->attributes->deviceId] ?? 0 }} / Total {{ count($devices) }} )
                                </span><br>
                                <div id="distributor-{{ $account->id }}" class="hidden" style="margin-left: 25px;">
                                    @foreach($users as $subAccount)
                                        @if($subAccount->attributes->account_type === 'Enterprise User' && $subAccount->attributes->distributor_id === $account->id)
                                            <div class="user-container">
                                                <span class="clickable" onclick="toggleVisibility('enterprise-{{ $subAccount->id }}')">
                                                    <i class="fas fa-user" style="color:orange;"></i> {{ $subAccount->name }} ({{ $userDeviceCounts[$subAccount->attributes->deviceId] ?? 0 }})
                                                </span><br>
                                                <div id="enterprise-{{ $subAccount->id }}" class="hidden" style="margin-left: 15px;">
                                                    @foreach($users as $endUser)
                                                        @if($endUser->attributes->account_type === 'End User' && $endUser->attributes->enterprise_id === $subAccount->id)
                                                            <span style="margin-left: 15px;" class="clickable">
                                                                <i class="fas fa-user" style="color:blue;"></i> {{ $endUser->name }}  ({{ $userDeviceCount[$endUser->attributes->deviceId] ?? 0 }})
                                                            </span><br>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                    @foreach($users as $endUser)
                                        @if($endUser->attributes->account_type === 'End User' && empty($endUser->attributes->enterprise_id) && $endUser->attributes->distributor_id === $account->id)
                                            <span style="margin-left: 30px;" class="clickable">
                                                <i class="fas fa-user" style="color:blue;"></i> {{ $endUser->name }}
                                            </span><br>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <script>
        function toggleVisibility(id) {
            var element = document.getElementById(id);
            if (element) {
                element.classList.toggle('hidden');
            } else {
                console.log('Element with ID ' + id + ' not found.');
            }
        }

        function performSearch(event) {
            event.preventDefault();

            var query = document.getElementById('search-query1').value.toLowerCase();
            var allUsers = document.querySelectorAll('.user-container');

            allUsers.forEach(function(container) {
                var containerVisible = false;

                container.querySelectorAll('.clickable').forEach(function(userElement) {
                    var userText = userElement.textContent.toLowerCase();
                    if (userText.includes(query)) {
                        userElement.classList.add('highlighted');
                        containerVisible = true;
                    } else {
                        userElement.classList.remove('highlighted');
                    }
                });

                container.style.display = containerVisible ? 'block' : 'none';
            });
        }

        // Initialize autocomplete
        $(function() {
            $("#search-query1").autocomplete({
                source: function(request, response) {
                    axios.get('/search-users', { params: { term: request.term } })
                        .then(function(result) {
                            response(result.data);
                        })
                        .catch(function(error) {
                            console.error('Error fetching autocomplete data:', error);
                        });
                }
            });
        });
    </script>
</body>
</html>
