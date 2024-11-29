<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Devices</title>
    <script>
        // Load devices from the API
        async function loadDevices() {
            try {
                const response = await fetch('/api/devices');
                if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);
                const devices = await response.json();

                let html = '<ul>';
                for (const [name, ip] of Object.entries(devices)) {
                    html += `<li>${name} (${ip}) <button onclick="deleteDevice('${name}')">Delete</button></li>`;
                }
                html += '</ul>';
                document.getElementById('deviceList').innerHTML = html;
            } catch (error) {
                console.error('Error loading devices:', error);
                document.getElementById('deviceList').innerHTML = '<p style="color: red;">Error loading devices.</p>';
            }
        }

        // Add a new device
        async function addDevice() {
            const name = document.getElementById('name').value.trim();
            const ip = document.getElementById('ip').value.trim();

            // Basic form validation
            if (!name || !ip) {
                alert('Both Device Name and IP Address are required.');
                return;
            }

            try {
                const formData = new FormData();
                formData.append('action', 'add');
                formData.append('name', name);
                formData.append('ip', ip);

                const response = await fetch('/api/devices', { method: 'POST', body: formData });
                if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);
                loadDevices();
            } catch (error) {
                console.error('Error adding device:', error);
                alert('Failed to add the device. Please try again.');
            }
        }

        // Delete a device
        async function deleteDevice(name) {
            try {
                const formData = new FormData();
                formData.append('action', 'delete');
                formData.append('name', name);

                const response = await fetch('/api/devices', { method: 'POST', body: formData });
                if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);
                loadDevices();
            } catch (error) {
                console.error('Error deleting device:', error);
                alert('Failed to delete the device. Please try again.');
            }
        }

        // Load devices on page load
        window.onload = loadDevices;
    </script>
</head>
<body>
    <h1>Manage Devices</h1>
    <div id="deviceList"></div>
    <form onsubmit="event.preventDefault(); addDevice();">
        <label for="name">Device Name:</label>
        <input type="text" id="name" placeholder="Device Name" required>
        <label for="ip">IP Address:</label>
        <input type="text" id="ip" placeholder="IP Address" required>
        <button type="submit">Add Device</button>
    </form>
</body>
</html>
