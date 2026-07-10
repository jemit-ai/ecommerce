window.loadUnreadNotifications = function () {

    
    console.log('#wire light');
    fetch('/notifications/unread', {
        headers: {
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {


        console.log('Rules:---'+data.count)
        // Update notification count
        document.getElementById('notificationCount').textContent = data.count;

        // Update notification list
        const list = document.getElementById('notificationList');
        list.innerHTML = '';


        data.notifications.forEach(notification => {

            list.innerHTML += `
                <li class="px-4 py-3 border-b hover:bg-gray-50">
                    <div class="font-medium">
                        ${notification.data.title ?? 'Notification'}
                    </div>
                    <div class="text-sm text-gray-500">
                        ${notification.data.message ?? ''}
                    </div>
                </li>
            `;
        });

    })
    .catch(error => console.error(error));

}

const notificationBtn = document.getElementById('notificationBtn');
const notificationList = document.getElementById('notificationList');

notificationBtn.addEventListener('click', async () => {

    // Toggle dropdown
    notificationList.classList.toggle('hidden');

});