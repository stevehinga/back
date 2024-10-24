// Handle 6 Hours Package
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('purchaseForm6Hours').addEventListener('submit', function(event) {
        event.preventDefault();  // Prevent the form from submitting and causing a page reload

        const phoneNumber = document.getElementById('phoneNumber6Hours').value;
        const packagePrice = document.getElementById('package6Hours').value;

        const buyButton = document.getElementById('buyButton6Hours');
        const processingMessage = document.getElementById('processingMessage6Hours');
        const responseMessage = document.getElementById('responseMessage6Hours');

        if (!phoneNumber || !packagePrice) {
            responseMessage.innerHTML = "Please enter all required information.";
            return;
        }

        // Display processing message and disable the button
        buyButton.style.display = 'none';
        processingMessage.style.display = 'block';

        fetch('https://mchwaapi.wifimashinani.co.ke/stk_push.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                phoneNumber: phoneNumber,
                amount: packagePrice
            })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            if (data.status === 'success') {
                responseMessage.innerHTML = "Payment initiated. Check your phone!";
            } else {
                responseMessage.innerHTML = `Payment failed. ${data.message || 'Please try again.'}`;
            }
        })
        .catch(error => {
            responseMessage.innerHTML = "An error occurred. Please try again.";
        })
        .finally(() => {
            // Reset button and processing message
            buyButton.style.display = 'block';
            processingMessage.style.display = 'none';
        });
    });
});



// Handle 24 Hours Package
document.addEventListener('DOMContentLoaded', function() {
    // Your form submission handling code
    document.getElementById('purchaseForm24Hours').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent form submission

        // Fetch phone number and package price from form fields
        const phoneNumber = document.getElementById('phoneNumber24Hours').value;
        const packagePrice = document.getElementById('package24Hours').value;

        // Get references to buttons and messages
        const buyButton = document.getElementById('buyButton24Hours');
        const processingMessage = document.getElementById('processingMessage24Hours');
        const responseMessage = document.getElementById('responseMessage');

        // Ensure all necessary DOM elements are present
        if (!phoneNumber || !packagePrice) {
            console.error('Phone number or package price is missing!');
            responseMessage.innerHTML = "Please enter all required information.";
            return;
        }

        if (!buyButton || !processingMessage || !responseMessage) {
            console.error('One or more DOM elements are missing!');
            return;
        }

        // Show "Processing" message and hide the Buy button
        buyButton.style.display = 'none';
        processingMessage.style.display = 'block';

        // Send the phone number and package details to the backend for M-Pesa STK push
        fetch('https://mchwaapi.wifimashinani.co.ke/stk_push.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                phoneNumber: phoneNumber,
                amount: packagePrice
            })
        })
        .then(response => {
            // Check if the response is OK and return JSON
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            // Handle success or failure based on the backend response
            if (data.status === 'success') {
                responseMessage.innerHTML = "Payment initiated. Check your phone!";
            } else {
                responseMessage.innerHTML = `Payment failed. ${data.message || 'Please try again.'}`;
            }
        })
        .catch(error => {
            // Handle network or fetch errors
            console.error('Error:', error);
            responseMessage.innerHTML = "An error occurred. Please try again.";
        })
        .finally(() => {
            // Reset button and messages regardless of success or failure
            buyButton.style.display = 'block';
            processingMessage.style.display = 'none';
        });
    });
});
// Handle 1 Week Package
document.addEventListener('DOMContentLoaded', function() {
    // Your form submission handling code
    document.getElementById('purchaseForm1Week').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent form submission

        // Fetch phone number and package price from form fields
        const phoneNumber = document.getElementById('phoneNumber1Week').value;
        const packagePrice = document.getElementById('package1Week').value;

        // Get references to buttons and messages
        const buyButton = document.getElementById('buyButton1Week');
        const processingMessage = document.getElementById('processingMessage1Week');
        const responseMessage = document.getElementById('responseMessage');

        // Ensure all necessary DOM elements are present
        if (!phoneNumber || !packagePrice) {
            console.error('Phone number or package price is missing!');
            responseMessage.innerHTML = "Please enter all required information.";
            return;
        }

        if (!buyButton || !processingMessage || !responseMessage) {
            console.error('One or more DOM elements are missing!');
            return;
        }

        // Show "Processing" message and hide the Buy button
        buyButton.style.display = 'none';
        processingMessage.style.display = 'block';

        // Send the phone number and package details to the backend for M-Pesa STK push
        fetch('https://mchwaapi.wifimashinani.co.ke/stk_push.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                phoneNumber: phoneNumber,
                amount: packagePrice
            })
        })
        .then(response => {
            // Check if the response is OK and return JSON
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            // Handle success or failure based on the backend response
            if (data.status === 'success') {
                responseMessage.innerHTML = "Payment initiated. Check your phone!";
            } else {
                responseMessage.innerHTML = `Payment failed. ${data.message || 'Please try again.'}`;
            }
        })
        .catch(error => {
            // Handle network or fetch errors
            console.error('Error:', error);
            responseMessage.innerHTML = "An error occurred. Please try again.";
        })
        .finally(() => {
            // Reset button and messages regardless of success or failure
            buyButton.style.display = 'block';
            processingMessage.style.display = 'none';
        });
    });
});
// Handle 1 Month Package
document.addEventListener('DOMContentLoaded', function() {
    // Your form submission handling code
    document.getElementById('purchaseForm1Month').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent form submission

        // Fetch phone number and package price from form fields
        const phoneNumber = document.getElementById('phoneNumber1Month').value;
        const packagePrice = document.getElementById('package1Month').value;

        // Get references to buttons and messages
        const buyButton = document.getElementById('buyButton1Month');
        const processingMessage = document.getElementById('processingMessage1Month');
        const responseMessage = document.getElementById('responseMessage');

        // Ensure all necessary DOM elements are present
        if (!phoneNumber || !packagePrice) {
            console.error('Phone number or package price is missing!');
            responseMessage.innerHTML = "Please enter all required information.";
            return;
        }

        if (!buyButton || !processingMessage || !responseMessage) {
            console.error('One or more DOM elements are missing!');
            return;
        }

        // Show "Processing" message and hide the Buy button
        buyButton.style.display = 'none';
        processingMessage.style.display = 'block';

        // Send the phone number and package details to the backend for M-Pesa STK push
        fetch('https://mchwaapi.wifimashinani.co.ke/stk_push.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                phoneNumber: phoneNumber,
                amount: packagePrice
            })
        })
        .then(response => {
            // Check if the response is OK and return JSON
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            // Handle success or failure based on the backend response
            if (data.status === 'success') {
                responseMessage.innerHTML = "Payment initiated. Check your phone!";
            } else {
                responseMessage.innerHTML = `Payment failed. ${data.message || 'Please try again.'}`;
            }
        })
        .catch(error => {
            // Handle network or fetch errors
            console.error('Error:', error);
            responseMessage.innerHTML = "An error occurred. Please try again.";
        })
        .finally(() => {
            // Reset button and messages regardless of success or failure
            buyButton.style.display = 'block';
            processingMessage.style.display = 'none';
        });
    });
});