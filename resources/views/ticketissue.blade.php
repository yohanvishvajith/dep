<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mobile Token System</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        
        .container {
            width: 100%;
            max-width: 500px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
            overflow: hidden;
        }
        
        .header {
            background: #2c3e50;
            color: white;
            padding: 20px;
            text-align: center;
        }
        
        .header h1 {
            font-size: 1.8rem;
            margin-bottom: 5px;
        }
        
        .header p {
            opacity: 0.8;
        }
        
        .step {
            display: none;
            padding: 30px;
            animation: fadeIn 0.5s ease;
        }
        
        .step.active {
            display: block;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        h2 {
            color: #2c3e50;
            margin-bottom: 20px;
            text-align: center;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #34495e;
        }
        
        input, select {
            width: 100%;
            padding: 15px;
            border: 2px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            transition: border-color 0.3s;
        }
        
        input:focus, select:focus {
            border-color: #3498db;
            outline: none;
        }
        
        .btn {
            display: block;
            width: 100%;
            padding: 15px;
            background: #3498db;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s;
        }
        
        .btn:hover {
            background: #2980b9;
        }
        
        .btn:disabled {
            background: #bdc3c7;
            cursor: not-allowed;
        }
        
        .ticket {
            text-align: center;
            padding: 30px;
        }
        
        .ticket-header {
            background: #2c3e50;
            color: white;
            padding: 15px;
            border-radius: 8px 8px 0 0;
            margin: -30px -30px 20px -30px;
        }
        
        .ticket-content {
            background: #ecf0f1;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        .ticket-field {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px dashed #bdc3c7;
        }
        
        .ticket-field:last-child {
            border-bottom: none;
        }
        
        .ticket-label {
            font-weight: 600;
            color: #2c3e50;
        }
        
        .ticket-value {
            font-weight: 500;
            color: #34495e;
        }
        
        .token-number {
            font-size: 2.5rem;
            font-weight: 700;
            color: #e74c3c;
            margin: 20px 0;
        }
        
        .counter-number {
            background: #3498db;
            color: white;
            display: inline-block;
            padding: 5px 15px;
            border-radius: 20px;
            font-weight: 600;
            margin: 10px 0;
        }
        
        .progress-bar {
            display: flex;
            justify-content: space-between;
            margin: 20px 0;
            position: relative;
        }
        
        .progress-bar::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 4px;
            background: #ecf0f1;
            transform: translateY(-50%);
            z-index: 1;
        }
        
        .progress-step {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: #ecf0f1;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: #7f8c8d;
            z-index: 2;
            border: 3px solid white;
        }
        
        .progress-step.active {
            background: #3498db;
            color: white;
        }
        
        .progress-step.completed {
            background: #2ecc71;
            color: white;
        }
        
        .step-indicator {
            text-align: center;
            margin-top: 10px;
            color: #7f8c8d;
            font-weight: 500;
        }

        .error-message {
            color: #e74c3c;
            font-size: 14px;
            margin-top: 5px;
        }

        .nav-links {
            position: absolute;
            top: 20px;
            right: 20px;
        }

        .nav-links a {
            background: rgba(255,255,255,0.2);
            color: white;
            padding: 8px 16px;
            border-radius: 20px;
            text-decoration: none;
            margin-left: 10px;
            transition: background 0.3s;
        }

        .nav-links a:hover {
            background: rgba(255,255,255,0.3);
        }
        
        @media (max-width: 480px) {
            .container {
                border-radius: 10px;
            }
            
            .step {
                padding: 20px;
            }
            
            .ticket-header {
                margin: -20px -20px 20px -20px;
            }
        }
    </style>
</head>
<body>
    <div class="nav-links">
   
    </div>

    <div class="container">
        <div class="header">
            <h1>Mobile Token System</h1>
            <p>Get your service ticket in seconds</p>
        </div>
        
        <div class="progress-bar">
            <div class="progress-step active">1</div>
            <div class="progress-step">2</div>
            <div class="progress-step">3</div>
            <div class="progress-step">4</div>
        </div>
        
        <div class="step-indicator">Step 1 of 4: Enter Mobile Number</div>
        
        <div class="step active" id="step1">
            <h2>Enter Your Mobile Number</h2>
            <div class="form-group">
                <label for="mobileNumber">Mobile Number</label>
                <input type="tel" id="mobileNumber" placeholder="Enter 10-digit mobile number" maxlength="10">
                <div class="error-message" id="mobileError"></div>
            </div>
            <button class="btn" id="nextStep1">Next</button>
        </div>
        
        <div class="step" id="step2">
            <h2>Select Service</h2>
            <div class="form-group">
                <label for="service">Choose a Service</label>
                <select id="service">
                    <option value="">-- Select Service --</option>
                    <!-- Services will be loaded dynamically -->
                    @foreach ($services as $service)
                        <option value="{{ $service['id']}}">{{ $service['name']}}</option>
                    @endforeach
                </select>
                <div class="error-message" id="serviceError"></div>
            </div>
            <button class="btn" id="nextStep2">Next</button>
        </div>

        <div class="step" id="step3">
            <h2>Enter Your Name</h2>
            <div class="form-group">
                <label for="customerName">Full Name</label>
                <input type="text" id="customerName" placeholder="Enter your full name">
                <div class="error-message" id="nameError"></div>
            </div>
            <button class="btn" id="nextStep3">Generate Ticket</button>
        </div>
        
        <div class="step" id="step4">
            <div class="ticket">
                <div class="ticket-header">
                    <h2>Service Ticket</h2>
                </div>
                <div class="ticket-content">
                    <div class="token-number" id="tokenNumber">A00001</div>
                    <div class="counter-number" id="counterNumber">Counter 1</div>
                    
                    <div class="ticket-field">
                        <span class="ticket-label">Company:</span>
                        <span class="ticket-value" id="companyName">Company Name</span>
                    </div>

                    <div class="ticket-field">
                        <span class="ticket-label">Branch:</span>
                        <span class="ticket-value" id="branchName">Branch Name</span>
                    </div>
                    
                    <div class="ticket-field">
                        <span class="ticket-label">Date & Time:</span>
                        <span class="ticket-value" id="dateTime">2023-06-15 14:30</span>
                    </div>
                    
                    <div class="ticket-field">
                        <span class="ticket-label">Service:</span>
                        <span class="ticket-value" id="serviceType">Service Name</span>
                    </div>
                    
                    <div class="ticket-field">
                        <span class="ticket-label">Customer:</span>
                        <span class="ticket-value" id="customer">Customer Name</span>
                    </div>
                    
                    <div class="ticket-field">
                        <span class="ticket-label">Mobile:</span>
                        <span class="ticket-value" id="mobile">1234567890</span>
                    </div>

                    
                </div>
                <button class="btn" id="newTicket" style="margin-top: 20px;">Generate New Ticket</button>
            </div>
        </div>
    </div>

    <script>
        // Set up CSRF token for AJAX requests
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        // DOM Elements
        const steps = document.querySelectorAll('.step');
        const progressSteps = document.querySelectorAll('.progress-step');
        const stepIndicator = document.querySelector('.step-indicator');
        
        // Form fields
        const mobileNumber = document.getElementById('mobileNumber');
        const service = document.getElementById('service');
        const customerName = document.getElementById('customerName');
        
        // Buttons
        const nextStep1 = document.getElementById('nextStep1');
        const nextStep2 = document.getElementById('nextStep2');
        const nextStep3 = document.getElementById('nextStep3');
        const newTicket = document.getElementById('newTicket');
        
        // Ticket fields
        const tokenNumber = document.getElementById('tokenNumber');
        const counterNumber = document.getElementById('counterNumber');
        const companyName = document.getElementById('companyName');
        const branchName = document.getElementById('branchName');
        const dateTime = document.getElementById('dateTime');
        const serviceType = document.getElementById('serviceType');
        const customer = document.getElementById('customer');
        const mobile = document.getElementById('mobile');
       
        
        // State variables
        let currentStep = 1;

        // Initialize
        updateProgress();
     
        // Event Listeners
        nextStep1.addEventListener('click', () => {
            if (validateMobile()) {
                goToStep(2);
            }
        });
        
        nextStep2.addEventListener('click', () => {
            if (validateService()) {
                goToStep(3);
            }
        });
        
        nextStep3.addEventListener('click', () => {
            if (validateName()) {
                generateTicket();
            }
        });
        
        newTicket.addEventListener('click', () => {
            resetForm();
            goToStep(1);
        });

        // Validation functions
        function validateMobile() {
            const mobile = mobileNumber.value.trim();
            const mobileRegex = /^[6-9]\d{9}$/;
            
            if (!mobile) {
                showError('mobileError', 'Please enter your mobile number');
                return false;
            }
            
            if (!mobileRegex.test(mobile)) {
                showError('mobileError', 'Please enter a valid 10-digit Indian mobile number (starts with 6, 7, 8, or 9)');
                return false;
            }
            
            clearError('mobileError');
            return true;
        }

        function validateService() {
            if (!service.value) {
                showError('serviceError', 'Please select a service');
                return false;
            }
            clearError('serviceError');
            return true;
        }

        function validateName() {
            if (!customerName.value.trim()) {
                showError('nameError', 'Please enter your name');
                return false;
            }
            clearError('nameError');
            return true;
        }

        function showError(elementId, message) {
            document.getElementById(elementId).textContent = message;
        }

        function clearError(elementId) {
            document.getElementById(elementId).textContent = '';
        }
        
        // Navigation functions
        function goToStep(step) {
            currentStep = step;
            
            // Hide all steps
            steps.forEach(s => s.classList.remove('active'));
            
            // Show current step
            document.getElementById(`step${step}`).classList.add('active');
            
            // Update progress
            updateProgress();
        }
        
        function updateProgress() {
            // Update progress steps
            progressSteps.forEach((step, index) => {
                if (index < currentStep) {
                    step.classList.add('completed');
                    step.classList.remove('active');
                } else if (index === currentStep - 1) {
                    step.classList.add('active');
                    step.classList.remove('completed');
                } else {
                    step.classList.remove('active', 'completed');
                }
            });
            
            // Update step indicator
            const stepLabels = ['Enter Mobile Number', 'Select Service', 'Enter Name', 'Your Ticket'];
            stepIndicator.textContent = `Step ${currentStep} of 4: ${stepLabels[currentStep - 1]}`;
        }
        
        // Ticket generation
        function generateTicket() {
            const submitButton = document.getElementById('nextStep3');
            submitButton.disabled = true;
            submitButton.textContent = 'Generating...';

            const formData = {
                mobile_number: mobileNumber.value.trim(),
                service_id: service.value,
                customer_name: customerName.value.trim()
            };

            fetch('/ticketissue', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify(formData)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update ticket display
                    tokenNumber.textContent = data.ticket.id;
                    counterNumber.textContent = `Counter 1`;
                    companyName.textContent = "sltmobitel";
                    branchName.textContent = data.ticket.branch_name;
                    dateTime.textContent = data.ticket.issued_at;
                    serviceType.textContent = data.ticket.service_name;
                    customer.textContent = data.ticket.customer_name;
                    mobile.textContent = data.ticket.mobile;
                   
                    goToStep(4);
                } else {
                    alert('Error generating ticket. Please try again.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error generating ticket. Please try again.');
            })
            .finally(() => {
                submitButton.disabled = false;
                submitButton.textContent = 'Generate Ticket';
            });
        }
        
        // Reset form
        function resetForm() {
            // Reset form values
            mobileNumber.value = '';
            service.value = '';
            customerName.value = '';
            
            // Clear all error messages
            clearError('mobileError');
            clearError('serviceError');
            clearError('nameError');
        }
    </script>
</body>
</html>
