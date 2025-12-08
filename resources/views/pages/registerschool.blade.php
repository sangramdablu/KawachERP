<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School ERP Registration</title>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- SweetAlert v1 -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    @include('modals.successmodal')
    <style>
        /* Base styles */
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #f4f7f6;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    margin: 0;
    padding: 20px;
}

/* Container for the form */
.container {
    background-color: #ffffff;
    padding: 40px;
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    max-width: 800px;
    width: 100%;
}

/* Header styling */
h1 {
    color: #004d99; /* A professional blue */
    text-align: center;
    margin-bottom: 5px;
}

p {
    text-align: center;
    color: #666;
    margin-bottom: 30px;
}

/* Fieldset and Legend for structure */
fieldset {
    border: 1px solid #ccc;
    padding: 20px;
    margin-bottom: 25px;
    border-radius: 8px;
}

legend {
    font-weight: bold;
    color: #004d99;
    padding: 0 10px;
    font-size: 1.2em;
}

/* Form Group Layout */
.form-group {
    margin-bottom: 20px;
    display: flex;
    flex-direction: column;
}

/* Label Styling */
label {
    margin-bottom: 8px;
    font-weight: 600;
    color: #333;
    font-size: 0.95em;
}

/* Input, Select, Textarea Styling */
input[type="text"],
input[type="email"],
input[type="tel"],
input[type="password"],
select,
textarea {
    width: 100%;
    padding: 12px;
    border: 1px solid #ddd;
    border-radius: 6px;
    box-sizing: border-box; /* Includes padding and border in the element's total width and height */
    font-size: 1em;
    transition: border-color 0.3s;
}

input:focus,
select:focus,
textarea:focus {
    border-color: #007bff; /* Highlight on focus */
    outline: none;
    box-shadow: 0 0 5px rgba(0, 123, 255, 0.2);
}

textarea {
    resize: vertical; /* Allows vertical resizing but not horizontal */
}

/* Form Actions (Buttons) */
.form-actions {
    display: flex;
    justify-content: space-between;
    gap: 15px;
    margin-top: 30px;
}

/* Button Styling */
.submit-btn, .reset-btn {
    padding: 12px 25px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-weight: bold;
    transition: background-color 0.3s, transform 0.1s;
    flex-grow: 1; /* Makes buttons take equal width */
}

.submit-btn {
    background-color: #28a745; /* Green for submission */
    color: white;
}

.submit-btn:hover {
    background-color: #218838;
    transform: translateY(-1px);
}

.reset-btn {
    background-color: #dc3545; /* Red for reset */
    color: white;
}

.reset-btn:hover {
    background-color: #c82333;
    transform: translateY(-1px);
}

/* Terms and Conditions Text */
.terms {
    text-align: center;
    font-size: 0.9em;
    margin-top: 20px;
}

.terms a {
    color: #007bff;
    text-decoration: none;
}

.terms a:hover {
    text-decoration: underline;
}

/* Responsive Design for smaller screens (e.g., phones) */
@media (max-width: 600px) {
    .container {
        padding: 20px;
        margin: 10px;
    }

    h1 {
        font-size: 1.5em;
    }

    .form-actions {
        flex-direction: column; /* Stack buttons vertically on small screens */
    }
    
    .submit-btn, .reset-btn {
        width: 100%;
        margin-bottom: 10px;
    }
}
    </style>
<body>
    @include('modals.confirmmodal')
    
    <div class="container">
        <h1>🏫 Register Your School</h1>
        <p>Please provide the details required to register your school with our Enterprise Resource Planning (ERP) system.</p>

        <form id="schoolForm" action="{{ route('school.register') }}" method="POST">
            @csrf
            <fieldset>
                <legend>School Information</legend>
                <div class="form-group">
                    <label for="school_name">School Name</label>
                    <input type="text" id="school_name" name="school_name" required>
                </div>
                <div class="form-group">
                    <label for="affiliation_no">Affiliation/License No.</label>
                    <input type="text" id="affiliation_no" name="affiliation_no" required>
                </div>
                <div class="form-group">
                    <label for="school_type">School Type</label>
                    <select id="school_type" name="school_type" required>
                        <option value="">Select Type</option>
                        <option value="public">Public/Government</option>
                        <option value="private">Private/Independent</option>
                        <option value="international">International</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="address">Full Address</label>
                    <textarea id="address" name="address" rows="3" required></textarea>
                </div>
                <div class="form-group">
                    <label for="pincode">Pincode/Zip Code</label>
                    <input type="text" id="pincode" name="pincode" maxlength="6" required>
                </div>
            </fieldset>

            <fieldset>
                <legend>Primary Contact & Admin Details</legend>
                <div class="form-group">
                    <label for="principal_name">Principal/Head Name</label>
                    <input type="text" id="principal_name" name="principal_name" required>
                </div>
                <div class="form-group">
                    <label for="email">Official Email</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="phone">Official Phone No.</label>
                    <input type="tel" id="phone" name="phone" maxlength="15" required>
                </div>
                <div class="form-group">
                    <label for="admin_username">Admin Username (for ERP)</label>
                    <input type="text" id="admin_username" name="admin_username" required>
                </div>
                <div class="form-group">
                    <label for="admin_password">Admin Password</label>
                    <input type="password" id="admin_password" name="admin_password" required>
                </div>
            </fieldset>

            <div class="form-actions">
                <button type="submit" class="submit-btn">Register School</button>
                <button type="reset" class="reset-btn">Clear Form</button>
            </div>

            <p class="terms">By registering, you agree to the <a href="#">Terms and Conditions</a>.</p>
        </form>
    </div>

<!-- Include SweetAlert -->
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script>
$(document).ready(function() {

    // Restrict pincode input to 6 digits only
    $('#pincode').on('input', function() {
        this.value = this.value.replace(/\D/g, '').slice(0, 6);
    });

    $('#schoolForm').on('submit', function(e) {
        e.preventDefault(); // stop default form for now to validate

        // Validate required fields
        let valid = true;
        $('#schoolForm [required]').each(function() {
            if ($(this).val().trim() === '') {
                valid = false;
                swal("Missing Information", "Please fill out all required fields.", "error");
                return false;
            }
        });
        if (!valid) return;

        // Validate pincode
        const pincode = $('#pincode').val().trim();
        if (!/^\d{6}$/.test(pincode)) {
            swal("Invalid Pincode", "Pincode must be exactly 6 digits.", "error");
            return;
        }

        showConfirm(
            'Confirm Submission',
            'Are you sure you want to register this school?',
            function(confirmed) {
                if (confirmed) {
                e.target.submit();
                }
            }
        );
    });
});
</script>


</body>
</html>