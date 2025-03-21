<?php $user = $_GET['user'] ?? 'Unknown'; ?>
<div class="w-full md:flex-1 flex flex-col h-screen">
    
    <!-- Header (Fixed) -->
    <div class="bg-white p-4 border-b flex items-center shadow-md fixed top-0 left-0 right-0 md:relative">
        <a href="index.php" class="md:hidden p-2">🔙</a>
        <img src="https://i.pravatar.cc/42" class="w-12 h-12 rounded-full mr-3">
        <div>
            <p class="font-semibold text-lg"><?= $user ?></p>
            <p class="text-sm text-green-500">Online</p>
        </div>
    </div>

    <!-- Messages (Scrollable) -->
    <div class="flex-1 p-4 overflow-y-auto space-y-4 flex flex-col-reverse mt-16 mb-16">
        <div class="flex flex-col items-end">
            <div class="bg-blue-500 text-white p-3 rounded-lg w-fit max-w-xs">Hello!</div>
            <span class="text-xs text-gray-500 mt-1">10:30 AM</span>
        </div>
        <div class="flex flex-col items-start">
            <div class="bg-gray-300 p-3 rounded-lg w-fit max-w-xs">Hi! How are you?</div>
            <span class="text-xs text-gray-500 mt-1">10:32 AM</span>
        </div>
    </div>

    <!-- Input Box (Fixed) -->
    <div class="bg-white p-4 border-t flex items-center shadow-md fixed bottom-0 left-0 right-0 md:relative">
        <input type="text" placeholder="Type a message..." class="flex-1 p-3 border rounded-full focus:outline-none focus:ring-2 focus:ring-blue-400">
        <button class="bg-blue-500 text-white px-6 py-3 ml-3 rounded-full hover:bg-blue-600">Send</button>
    </div>

</div>
