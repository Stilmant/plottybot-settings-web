<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Devices</title>
    <script>
        async function loadDevices() {
            const response = await fetch('/api/devices');
            const devices = await response.json();
            let html = '<ul>';
            devices.forEach((device, index) => {
                html += `<li>${device.name} (${device.ip}) <button onclick="deleteDevice(${index})">Delete</button></li>`;
            });
            html += '</ul>';
            document.getElementById('deviceList').innerHTML = html;
        }

        async function addDevice() {
            const name = document.getElementById('name').value;
            const ip = document.getElementById('ip').value;
            
            const formData = new FormData();
            formData.append('action', 'add');
            formData.append('name', name);
            formData.append('ip', ip);
            
            await fetch('/api/devices', { method: 'POST', body: formData });
            loadDevices();
        }

        async function deleteDevice(index) {
            const formData = new FormData();
            formData.append('action', 'delete');
            formData.append('index', index);
            
            await fetch('/api/devices', { method: 'POST', body: formData });
            loadDevices();
        }

        window.onload = loadDevices;
    </script>
</head>
<body>
    <h1>Manage Devices</h1>
    <div id="deviceList"></div>
    <form onsubmit="event.preventDefault(); addDevice();">
        <input type="text" id="name" placeholder="Device Name">
        <input type="text" id="ip" placeholder="IP Address">
        <button type="submit">Add Device</button>
    </form>
</body>
</html>
