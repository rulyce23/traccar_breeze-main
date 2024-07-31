<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Toggle</title>

</head>
<body>
    @if (request()->is('dashboard'))
        <div class="min-h-[88vh] border-r border-gray-300 bg-white">
            <div style="background-image: linear-gradient(#F1F5FD, #E9F0FF); background-color: aliceblue; border-bottom: 1px solid #ddd"
                class="px-[15px] py-1">
                <p class="text-sm font-bold text-[#333333] leading-loose">My Account</p>
            </div>
            <div class="bg-white">
                <div class="py-[10px]">
                    <ul class="text-sm" id="myTab" data-tabs-toggle="#myTabContent" role="tablist">
                        <li role="presentation">
                            <button class="inline-block button-tab py-2 px-5 w-full text-start leading-[normal]"
                                style="color: #666666" id="account-tab" data-tabs-target="#account" type="button"
                                role="tab" aria-controls="account" aria-selected="true" autofocus>Account
                                Details</button>
                        </li>
                        <li role="presentation">
                            <button class="inline-block button-tab py-2 px-5 w-full text-start leading-[normal]"
                                style="color: #666666" id="messages-tab" data-tabs-target="#messages" type="button"
                                role="tab" aria-controls="messages" aria-selected="false">Messages
                                (0)</button>
                        </li>
                        <li role="presentation">
                            <button class="inline-block button-tab py-2 px-5 w-full text-start leading-[normal]"
                                style="color: #666666" id="va-tab" data-tabs-target="#va" type="button" role="tab"
                                aria-controls="va" aria-selected="false">Virtual
                                Account</button>
                        </li>
                        <li role="presentation">
                            <a href="#" class="inline-block button-tab py-2 px-5 w-full text-start leading-[normal]"
                                style="color: #666666">
                                Report
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    @elseif(request()->is('monitor'))
        <div class="sidebar bg-white border-r border-gray-300">
            <div class="menu menu-visible" id="menu">
                <div style="background-image: linear-gradient(#F1F5FD, #E9F0FF); background-color: aliceblue; border-bottom: 1px solid #ddd"
                    class="px-[15px] py-1">
                    <p class="text-sm font-bold text-[#333333] leading-loose">{{$userName}} Stok / Total</p>
                    <span id="console_userTree_1_span">
                            </span>
                </div>
            </div>

            <div class="container">
    <form action="/accounts/search" method="POST">
        @csrf
        <input type="text" name="query" placeholder="Please enter the full customer name">
        <button type="submit" class="btn btn-small btn-primary">Search</button>
    </form>
    </div>
    <div style="margin-left: 25px; margin-top: 20px;">
    @foreach($users as $account)
        <span><i class="fas fa-user"></i> {{ $account->name }}</span><br>
        @if(is_array($account->administrator) || is_object($account->administrator))
        @foreach($account->administrator as $child)
            <li><i class="fas fa-user"></i> {{ $child->name }}</li>
        @endforeach
        @endif

    @endforeach


</div>

        @elseif(request()->is('device'))
        <div class="min-h-[88vh] w-[275px] border-r border-gray-300 bg-white">
            <div class="menu menu-visible" id="menu">
                <div style="background-color: white; border-bottom: 1px solid #ddd"
                    class="px-[40px] py-1">
                    <p class="text-sm font-bold text-[#333333] leading-loose">Account List</p>
                    <span id="console_userTree_1_span"></span>
                    <br>
                </div>
            </div>
    <div class="container">
    <form action="/accounts/search" method="POST">
        @csrf
        <input type="text" name="query" placeholder="Please enter the full customer name">
        <button type="submit" class="btn btn-small btn-primary">Search</button>
    </form>
    </div>
    <div style="margin-left: 25px; margin-top: 20px;">
    @foreach($users as $account)
        <span><i class="fas fa-user"></i> {{ $account->name }}</span><br>
        @if(is_array($account->administrator) || is_object($account->administrator))
        @foreach($account->administrator as $child)
            <li><i class="fas fa-user"></i> {{ $child->name }}</li>
        @endforeach
        @endif

    @endforeach

</div>


    @endif
</body>
</html>
