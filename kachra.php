<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat App UI</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="w-1/4 bg-white p-4 border-r hidden md:block">
            <h2 class="text-xl font-bold mb-4">Chats</h2>
            <div class="space-y-4">
                <div class="flex items-center p-2 hover:bg-gray-200 rounded cursor-pointer">
                    <img src="https://i.pravatar.cc/40" class="w-12 h-12 rounded-full mr-3">
                    <div>
                        <p class="font-semibold text-lg">John Doe</p>
                        <p class="text-sm text-gray-500">Hey, how are you?</p>
                    </div>
                </div>
                <div class="flex items-center p-2 hover:bg-gray-200 rounded cursor-pointer">
                    <img src="https://i.pravatar.cc/41" class="w-12 h-12 rounded-full mr-3">
                    <div>
                        <p class="font-semibold text-lg">Jane Smith</p>
                        <p class="text-sm text-gray-500">Let's catch up soon!</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Chat Area -->
        <div class="flex-1 flex flex-col">
            <!-- Header -->
            <div class="bg-white p-4 border-b flex items-center shadow-md">
                <img src="https://i.pravatar.cc/42" class="w-12 h-12 rounded-full mr-3">
                <div>
                    <p class="font-semibold text-lg">John Doe</p>
                    <p class="text-sm text-green-500">Online</p>
                </div>
            </div>
            
            <!-- Messages -->
            <div class="flex-1 p-4 overflow-y-auto space-y-4 flex flex-col-reverse">
                <div class="flex flex-col items-end">
                    <div class="bg-blue-500 text-white p-3 rounded-lg w-fit max-w-xs">Hello!</div>
                    <span class="text-xs text-gray-500 mt-1">10:30 AM</span>
                </div>
                <div class="flex flex-col items-start">
                    <div class="bg-gray-300 p-3 rounded-lg w-fit max-w-xs">Hi! How are you?</div>
                    <span class="text-xs text-gray-500 mt-1">10:32 AM</span>
                </div>
                <div class="flex flex-col items-end">
                    <div class="bg-blue-500 text-white p-3 rounded-lg w-fit max-w-xs">I'm good, what about you?</div>
                    <span class="text-xs text-gray-500 mt-1">10:35 AM</span>
                </div>
            </div>
            
            <!-- Input Box -->
            <div class="bg-white p-4 border-t flex items-center shadow-md">
                <input type="text" placeholder="Type a message..." class="flex-1 p-3 border rounded-full focus:outline-none focus:ring-2 focus:ring-blue-400">
                <button class="bg-blue-500 text-white px-6 py-3 ml-3 rounded-full hover:bg-blue-600">Send</button>
            </div>
        </div>
    </div>
</body>
</html>