<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Slots</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <h2>Available Appointment Slots</h2>
    <table border="1">
        <thead>
            <tr>
                <th>Doctor Name</th>
                <th>Appointment Date</th>
                <th>Reason</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="slotsTable">
            <!-- Slots will be loaded here -->
        </tbody>
    </table>

    <script>
       $(document).ready(function () {
    fetchSlots(); // Load available slots

    function fetchSlots() {
        $.ajax({
            url: 'get_appointment_slots.php',
            type: 'GET',
            success: function (data) {
                console.log("Fetched Data:", data);  // Debug response
                try {
                    let slots = JSON.parse(data);

                    if (!Array.isArray(slots)) {
                        console.error("Invalid JSON format:", data);
                        return;
                    }

                    if (slots.length === 0) {
                        $("#slotsTable").html("<tr><td colspan='4'>No available slots</td></tr>");
                        return;
                    }

                    let tableHTML = "";
                    slots.forEach(slot => {
                        tableHTML += `
                            <tr>
                                <td>${slot.doctor_name}</td>
                                <td>${slot.appointment_date}</td>
                                <td>${slot.reason}</td>
                                <td>
                                    <button onclick="confirmSlot(${slot.appointment_id}, 1)">Confirm Slot</button>
                                </td>
                            </tr>
                        `;
                    });
                    $("#slotsTable").html(tableHTML);
                } catch (error) {
                    console.error("Error parsing JSON:", error, data);
                }
            },
            error: function (xhr, status, error) {
                console.error("AJAX Error:", status, error);
            }
        });
    }

    window.confirmSlot = function (appointment_id, elder_id) {
        $.ajax({
            url: 'confirm_slot.php',
            type: 'POST',
            data: { appointment_id: appointment_id, elder_id: elder_id },
            success: function (response) {
                let res;
                try {
                    res = JSON.parse(response);
                } catch (error) {
                    console.error("Error parsing confirmation response:", error, response);
                    return;
                }

                alert(res.message);
                fetchSlots(); // Reload slots
            }
        });
    };
});

    </script>
</body>
</html>
